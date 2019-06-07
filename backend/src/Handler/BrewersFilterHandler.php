<?php

namespace App\Handler;

use App\Entity\Brewer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

class BrewersFilterHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * BrewersFilterHandler constructor.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(Brewer $brewer): Paginator
    {
        $brewers = $this->entityManager->getRepository(Brewer::class)->createQueryBuilder('c');
        $doctrinePaginator = new Paginator($brewers);

        return $doctrinePaginator;
    }
}