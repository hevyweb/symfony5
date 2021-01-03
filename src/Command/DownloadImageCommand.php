<?php

namespace App\Command;

use App\Entity\Image;
use App\Exception\DownloadFailureException;
use Doctrine\Migrations\Tools\Console\Exception\FileTypeNotSupported;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DownloadImageCommand extends Command
{
    protected static $defaultName = 'app:download-image';
    
    const FILE_STORAGE = '/public/images';

    /**
     * @var EntityManager
     */
    private $entityManager;

    const DEFAULT_TIMEOUT = 60;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Download images from google.')
            ->addOption(
                'timeout',
                null,
                InputOption::VALUE_OPTIONAL,
                'Time till script stop in seconds.',
                self::DEFAULT_TIMEOUT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $style = new SymfonyStyle($input, $output);

        $timeout = (int) $input->getOption('timeout');
        if ($timeout < 0) {
            $timeout = self::DEFAULT_TIMEOUT;
        }

        $timeToStop = time() + $timeout;
        $path = $this->getFolder();

        do {
            try {
                $image = $this->getNextImage();
                if (!$fileData = file_get_contents($image->getPath() . '=d')) {
                    throw new DownloadFailureException('Was not able to download file "' . $image->getPath());
                }

                $localFileName = $this->getFileName($path, $image);
                if (!file_put_contents($localFileName, $fileData)) {
                    throw new \RuntimeException('Not able to save file to the local path "' . $localFileName . '"');
                }
                $this->validateFile($localFileName, $image);
                $style->success('Downloaded file to "' . $localFileName . '"');
                $image->setDownloadedAt(new \DateTime());
                $image->setLocalPath($localFileName);
                $this->entityManager->persist($image);
                $this->entityManager->flush();
            } catch (NoResultException $exception) {
                $style->success('Nothing to download. Process fall asleep.');
                break;
            } catch (DownloadFailureException $exception) {
                $style->error($exception->getMessage());
            } catch (FileTypeNotSupported $exception) {
                $this->removeFile($localFileName);
            }

        } while (time() < $timeToStop);

        return Command::SUCCESS;
    }

    /**
     * @throw NoResultException
     * @return Image|null
     */
    private function getNextImage(): ?Image
    {
        return $this->entityManager->getRepository(Image::class)->getLatestImageRecord();
    }

    private function getFileName(string $path, Image $image)
    {
        $prefix = '';
        do {
            $file = $prefix . $image->getFilename();
            $prefix = (int) $prefix + 1;
        } while (is_file($path . '/' . $file));
        return $path . '/' . $file;
    }

    private function getFolder(): string
    {
        $path = __DIR__ . '/../..' . self::FILE_STORAGE;
        if (!is_dir($path) && !mkdir($path)) {
            throw new \RuntimeException('Directory does not exist.');
        }
        return realpath($path);
    }

    private function validateFile(string $localFileName, Image $image)
    {
        if (mime_content_type($localFileName) != $image->getType()) {
            throw new FileTypeNotSupported('File is corrupted.');
        }
    }

    private function removeFile($localfile)
    {
        if (!unlink($localfile) && is_file($localfile)) {
            throw new \RuntimeException('Not able to remove local file');
        }
    }
}
