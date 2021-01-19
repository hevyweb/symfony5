<?php

namespace App\Command;

use App\Service\ProcessImageService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ProcessImageCommand extends Command
{
    const DEFAULT_TIMEOUT = 60;

    /**
     * @var ProcessImageService
     */
    private $processImageService;

    public function __construct(ProcessImageService $processImageService)
    {
        $this->processImageService = $processImageService;
        parent::__construct();
    }

    protected static $defaultName = 'app:process-image';

    protected function configure()
    {
        $this
            ->setDescription('Process downloaded images. Potentially it can work as a daemon.')
            ->addOption(
                'timeout',
                null,
                InputOption::VALUE_OPTIONAL,
                'Time of the command to work in seconds.',
                self::DEFAULT_TIMEOUT
            );;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        try {
            $this->checkFolder();
        } catch (\RuntimeException $exception) {
            $io->error($exception->getMessage());
            return self::FAILURE;
        }
        $timeOut = (int)$input->getOption('timeout');
        $startTime = time();
        $stopTime = time() + $timeOut;
        $count = 0;
        $io->progressStart($timeOut);

        while (time() < $stopTime) {
            try {
                $this->processImageService->process();
                $count++;
                $io->progressAdvance(time() - $startTime);
                $startTime = time();
            } catch (\Exception $exception) {
                $io->error($exception->getMessage());
            }
        }
        $io->progressFinish();

        $io->success($count . ' images processed.');

        return Command::SUCCESS;
    }

    private function checkFolder()
    {
        $this->processImageService->checkAndCreatePublic(ProcessImageService::THUMBNAIL_FOLDER);
        $this->processImageService->checkAndCreatePublic(ProcessImageService::THUMBNAIL_FOLDER . '/images');
    }
}
