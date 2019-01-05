<?php

namespace App\Repository;

use App\Entity\Brewer;
use App\Entity\Country;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Brewer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Brewer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Brewer[]    findAll()
 * @method Brewer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BrewerRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Brewer::class);
    }

    public function findBrewerOrCreateByName(string $name, string $country) : Brewer
    {
        $brewer = $this->findOneBy(['name' => $name]);

        if (!$brewer) {
            $country = $this->_em->getRepository(Country::class)->findOneOrCreateByName($country);

            $brewer = new Brewer();
            $brewer->setName($name);
            $brewer->setCountry($country);

            $this->_em->persist($brewer);
            $this->_em->flush();
        }

        return $brewer;
    }
}
