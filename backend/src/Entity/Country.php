<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CountryRepository")
 * @ApiResource(
 *     attributes={"order"={"name":"ASC"}, "pagination_enabled"=false},
 *     itemOperations={"GET"},
 *     collectionOperations={"GET"}
 * )
 */
class Country implements NameFieldInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"get","get-beer-all-data","get-brewer-all-data"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"get","get-beer-all-data","get-brewer-all-data"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Groups({"get","get-beer-all-data","get-brewer-all-data"})
     */
    private $code;

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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }
}
