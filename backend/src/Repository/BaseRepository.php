<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class BaseRepository extends ServiceEntityRepository
{
    /**
     * @param string $name
     * @return object|null
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function findOneOrCreateByName(string $name)
     {
        $entity = $this->findOneBy(['name' => $name]);

        if (!$entity) {
            $entity = new $this->_entityName;
            $entity->setName($name);
            $this->_em->persist($entity);
            $this->_em->flush();
        }

        return $entity;
    }
}
