<?php

namespace App\Command;

use App\Entity\Beer;
use App\Service\ExternalApiService;
use App\Service\ImportBeerDataService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportBeerDataCommand extends Command
{
    protected static $defaultName = 'import:beer-data';

    private $entityManager;
    private $logger;
    private $externalApiService;
    private $importBeerDataService;

    public function __construct(
        EntityManagerInterface $entityManager,
        LoggerInterface $importerLogger,
        ExternalApiService $externalApiService,
        ImportBeerDataService $importBeerDataService
    ){
        $this->entityManager = $entityManager;
        $this->logger = $importerLogger;
        $this->externalApiService = $externalApiService;
        $this->importBeerDataService = $importBeerDataService;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Import information about beers from external API');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->text('Start import');
        $this->importBeerDataService->execute();
        $io->success('Success with import.');
    }
}
