<?php

namespace App\Repository;

use App\Entity\Country;
use App\Service\ExternalApiService;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Country|null find($id, $lockMode = null, $lockVersion = null)
 * @method Country|null findOneBy(array $criteria, array $orderBy = null)
 * @method Country[]    findAll()
 * @method Country[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CountryRepository extends BaseRepository
{
    private $countryExternalApiService;

    public function __construct(RegistryInterface $registry, ExternalApiService $countryExternalApiService)
    {
        parent::__construct($registry, Country::class);
        $this->countryExternalApiService = $countryExternalApiService;
    }

    /**
     * @param string $name
     * @return Country|object|null
     * @throws ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function findOneOrCreateByName(string $name)
    {
        $country = $this->findOneBy(['name' => $name]);

        if (!$country) {
            $country = new Country();
            $code = $this->countryExternalApiService->importCountryCodyByName($name);
            $country->setName($name);
            $country->setCode($code);

            $this->_em->persist($country);
            $this->_em->flush();
        }

        return $country;
    }
}
