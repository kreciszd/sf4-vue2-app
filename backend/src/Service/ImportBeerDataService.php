<?php

namespace App\Service;

use App\Entity\Beer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Psr\Log\LoggerInterface;

class ImportBeerDataService
{
    private $entityManager;
    private $logger;
    private $externalApiService;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $importerLogger, ExternalApiService $externalApiService)
    {
        $this->entityManager = $entityManager;
        $this->logger = $importerLogger;
        $this->externalApiService = $externalApiService;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function execute()
    {
        $id = uniqid('', true);
        try {
            $products = $this->externalApiService->importBeers();
        } catch (Exception $exception) {
            return false;
        }

        $this->logger->notice('Start import: '. $id);
        $i = 0;
        foreach ($products as $apiBeer) {
            $beer = $this->entityManager->getRepository(Beer::class)->findOneBy(['productId' => $apiBeer->product_id]);

            if(!$beer) {
                $beer = $this->entityManager->getRepository(Beer::class)->createNewBeer($apiBeer);
                $this->entityManager->persist($beer);

                if (($i % 20) === 0) {
                    $this->entityManager->flush();
                    $this->entityManager->clear();
                }
                $i++;
            }
        }

        $this->entityManager->flush();
        $this->logger->notice('Success with import: '. $id);

        return true;
    }
}
