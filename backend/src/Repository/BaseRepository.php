<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class BaseRepository extends ServiceEntityRepository
{
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
