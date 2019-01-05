<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeRepository")
 * @ApiResource(
 *     attributes={"order"={"name":"ASC"}, "pagination_enabled"=false},
 *     itemOperations={"GET"},
 *     collectionOperations={"GET"}
 * )
 */
class Type implements NameFieldInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"get","get-beer-all-data"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"get","get-beer-all-data"})
     */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): NameFieldInterface
    {
        $this->name = $name;

        return $this;
    }
}
