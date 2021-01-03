<?php

namespace App\Command;

use App\Entity\LibraryPointer;
use App\Entity\User;
use App\Exception\UserNotFoundException;
use App\Service\LoaderService;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;
use Google\ApiCore\ApiException;
use Google\ApiCore\ValidationException;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class LoadDataCommand extends Command
{
    use LoggerAwareTrait;

    protected static $defaultName = 'app:load-data';

    /**
     * @var LibraryPointer|null
     */
    protected $libraryPointer;

    const DEFAULT_USER_ID = 1;

    const DEFAULT_TIMEOUT = 60;

    /**
     * @var LoaderService
     */
    private $loaderService;

    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine, LoaderService $loaderService)
    {
        $this->doctrine = $doctrine;
        $this->loaderService = $loaderService;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('This command loads data about images of the user from Google Photo. It is designed to work only 60 seconds and then stop. So that next iteration will continue from the end of the previous. It prevents memory leak.')
            ->addArgument(
                'userId',
                InputArgument::OPTIONAL,
                'User id. It will load this user images.',
                self::DEFAULT_USER_ID
            )
            ->addOption(
                'timeout',
                null,
                InputOption::VALUE_OPTIONAL,
                'Time of the command to work in seconds.',
                self::DEFAULT_TIMEOUT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $style = new SymfonyStyle($input, $output);
        $userId = (int)$input->getArgument('userId');
        $seconds = (int)$input->getOption('timeout');
        $timeStart = time();
        $timeout = $timeStart + $seconds;
        $style->writeln('Starting loading process for "' . $seconds . '" seconds. User id "' . $userId . '".');
        try {
            $user = $this->getUser($userId);
            $pageToken = $this->getPageToken();
            $style->writeln('Page token: ' . ($pageToken ?? 'not set'));
            $style->progressStart($seconds);

            while (true) {
                $advance = time() - $timeStart;
                $timeStart = time();
                $style->progressAdvance($advance);
                $pageToken = $this->loaderService->load($user, $pageToken);
                if (is_null($pageToken) || $timeout <= time()) {
                    break;
                }
            }
        } catch (UserNotFoundException $exception) {
            $style->error($exception->getMessage());
            return Command::FAILURE;
        } catch (ValidationException|ApiException $exception) {
            $this->destroyLibraryPointer();
            $pageToken = null;
            $this->logger->error($exception->getMessage());
            $style->error('Google Api error.');
            return Command::FAILURE;
        } catch (NoResultException $exception) {
            $this->destroyLibraryPointer();
            $pageToken = null;
        } finally {
            $style->progressFinish();
            if (!empty($pageToken)) {
                $this->savePageToken($pageToken);
                $style->writeln('Last page token "' . $pageToken . '"');
            }
        }
        $style->success('Data loaded.');

        return Command::SUCCESS;
    }

    /**
     * @param int $userId
     * @return User
     * @throws UserNotFoundException
     */
    private function getUser(int $userId): User
    {
        $user = $this->doctrine->getRepository(User::class)->find($userId);
        if (empty($user)) {
            throw new UserNotFoundException('User with id "' . $userId . '" not found.');
        }
        return $user;
    }

    private function getPageToken(): ?string
    {
        $this->libraryPointer = $this->doctrine->getRepository(LibraryPointer::class)->findOneBy([]);
        if (empty($this->libraryPointer)) {
            $this->generateLibraryPointer();
            return null;
        }
        $pageToken = $this->libraryPointer->getPageToken();
        if (is_null($pageToken)) {
            if (time() - $this->libraryPointer->getCreatedAt()->getTimestamp() >= self::DEFAULT_TIMEOUT) {
                // old library token and it should be removed
                $this->destroyLibraryPointer();
                return $this->getPageToken();
            }
            // waiting until previous process to finish
            sleep(1);
            return $this->getPageToken();
        }

        return $pageToken;
    }

    private function generateLibraryPointer(): void
    {
        $this->libraryPointer = new LibraryPointer();
        $this->libraryPointer
            ->setCreatedAt(new \DateTime())
            ->setStatus('Process started the page');
        $this->doctrine->getManager()->persist($this->libraryPointer);
        $this->doctrine->getManager()->flush();
    }

    private function destroyLibraryPointer()
    {
        if (!empty($this->libraryPointer)) {
            $this->doctrine->getManager()->remove($this->libraryPointer);
            $this->doctrine->getManager()->flush();
        }
    }

    private function savePageToken($pageToken): void
    {
        $this->libraryPointer
            ->setPageToken($pageToken)
            ->setStatus('timeout');
        $this->doctrine->getManager()->persist($this->libraryPointer);
        $this->doctrine->getManager()->flush();
        unset($this->libraryPointer);
    }

    public function __destruct()
    {
        $this->destroyLibraryPointer();
    }
}
