<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CountryRepository")
 */
class Country
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Brewer", mappedBy="country")
     */
    private $brewers;

    public function __construct()
    {
        $this->brewers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Brewer[]
     */
    public function getBrewers(): Collection
    {
        return $this->brewers;
    }

    public function addBrewer(Brewer $brewer): self
    {
        if (!$this->brewers->contains($brewer)) {
            $this->brewers[] = $brewer;
            $brewer->setCountry($this);
        }

        return $this;
    }

    public function removeBrewer(Brewer $brewer): self
    {
        if ($this->brewers->contains($brewer)) {
            $this->brewers->removeElement($brewer);
            // set the owning side to null (unless already changed)
            if ($brewer->getCountry() === $this) {
                $brewer->setCountry(null);
            }
        }

        return $this;
    }
}
