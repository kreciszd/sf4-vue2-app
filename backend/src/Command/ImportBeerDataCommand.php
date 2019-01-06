<?php

namespace App\Command;

use App\Entity\Beer;
use App\Service\ExternalApiService;
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

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger, ExternalApiService $externalApiService)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
        $this->externalApiService = $externalApiService;

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
        $products = $this->externalApiService->importBeers();

        $batchSize = 20;
        $i = 0;
        foreach ($products as $apiBeer) {
            $beer = $this->entityManager->getRepository(Beer::class)->findOneBy(['productId' => $apiBeer->product_id]);

            if(!$beer) {
                $beer = $this->entityManager->getRepository(Beer::class)->createNewBeer($apiBeer);
                $this->entityManager->persist($beer);

                if (($i % $batchSize) === 0) {
                    $this->entityManager->flush();
                    $this->entityManager->clear();
                }
                $i++;
                $io->text('Added new beer to create: ' . $apiBeer->name);
            }
        }

        $this->entityManager->flush();
        $this->logger->notice('Success with import');
        $this->logger->info('Added new beers:'. $i);

        $io->success('Success with import.');
    }
}
