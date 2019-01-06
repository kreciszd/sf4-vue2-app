<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Filter\BeersCountOrderFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BrewerRepository")
 * @ApiResource(
 *     attributes={
 *          "pagination_client_items_per_page"=true,
 *          "maximum_items_per_page": 100
 *     },
 *     itemOperations={
 *         "GET"={
 *              "normalization_context"={
 *                  "groups"={"get","get-brewer-all-data"}
 *              }
 *          }
 *      },
 *     collectionOperations={
 *         "GET"={
 *              "normalization_context"={
 *                  "groups"={"get","get-brewer-all-data"}
 *              }
 *          }
 *      },
 *     normalizationContext={
 *         "groups"={"read"}
 *     }
 * )
 * @ApiFilter(
 *     SearchFilter::class,
 *     properties={
 *          "name":"partial",
 *          "country.name":"partial"
 *     }
 * )
 * @ApiFilter(
 *     OrderFilter::class,
 *     properties={"beersCount","name"}
 * )
 * @ApiFilter(
 *     BeersCountOrderFilter::class,
 *     properties={"beersCount"}
 * )
 * @ApiFilter(
 *     OrderFilter::class,
 *     properties={"name","country.name"}
 * )
 */
class Brewer implements NameFieldInterface
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

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Country")
     * @Groups({"get","get-beer-all-data", "get-brewer-all-data"})
     */
    private $country;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Beer", mappedBy="brewer", orphanRemoval=true)
     * @ApiSubresource()
     */
    private $beers;

    /**
     * @Groups({"get","get-brewer-all-data"})
     */
    private $beersCount;

    public function __construct()
    {
        $this->beers = new ArrayCollection();
    }

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

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection|Beer[]
     */
    public function getBeers(): Collection
    {
        return $this->beers;
    }

    public function addBeer(Beer $beer): self
    {
        if (!$this->beers->contains($beer)) {
            $this->beers[] = $beer;
            $beer->setBrewer($this);
        }

        return $this;
    }

    public function removeBeer(Beer $beer): self
    {
        if ($this->beers->contains($beer)) {
            $this->beers->removeElement($beer);
            // set the owning side to null (unless already changed)
            if ($beer->getBrewer() === $this) {
                $beer->setBrewer(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBeersCount()
    {
        return $this->getBeers()->count();
    }

    /**
     * @return mixed
     */
    public function setBeersCount()
    {
        return $this->beersCount = $this->getBeers()->count();
    }
}
