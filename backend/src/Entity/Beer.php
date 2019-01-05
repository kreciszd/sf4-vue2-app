<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BeerRepository")
 * @ApiResource(
 *     attributes={
 *          "order"={"name":"ASC"},
 *          "pagination_client_items_per_page"=true,
 *          "maximum_items_per_page": 100
 *     },
 *     itemOperations={
 *         "GET"={
 *              "normalization_context"={
 *                  "groups"={"get","get-beer-all-data"}
 *              }
 *          }
 *      },
 *     collectionOperations={
 *         "GET"={
 *              "normalization_context"={
 *                  "groups"={"read","get-beer-all-data"}
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
 *          "brewer":"exact",
 *          "name":"partial",
 *          "type.name":"partial",
 *          "brewer.country.name":"partial"
 *     }
 * )
 * @ApiFilter(
 *     RangeFilter::class,
 *     properties={"price"}
 * )
 * @ApiFilter(
 *     OrderFilter::class,
 *     properties={"name","brewer","type","country","pricePerLiter","price","type.name","brewer.country.name"}
 * )
 */
class Beer implements NameFieldInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read","get-beer-all-data"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"read", "get-beer-all-data"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"read", "get-beer-all-data"})
     */
    private $size;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Groups({"read", "get-beer-all-data"})
     */
    private $price;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Groups({"read", "get-beer-all-data"})
     */
    private $pricePerLiter;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get"})
     */
    private $imageUrl;

    /**
     * @ORM\Column(type="decimal", precision=3, scale=1)
     * @Groups({"read", "get-beer-all-data"})
     */
    private $abv;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $style;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $attributes;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"read", "get-beer-all-data"})
     */
    private $onSale;

    /**
     * @ORM\Column(type="integer")
     */
    private $beerId;

    /**
     * @ORM\Column(type="integer")
     */
    private $productId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Brewer", inversedBy="beers")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read", "get-beer-all-data"})
     */
    private $brewer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type")
     * @Groups({"read", "get-beer-all-data"})
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     * @Groups({"read", "get-beer-all-data"})
     */
    private $category;

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

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPricePerLiter()
    {
        return $this->pricePerLiter;
    }

    public function setPricePerLiter($pricePerLiter): self
    {
        $this->pricePerLiter = $pricePerLiter;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getAbv()
    {
        return $this->abv;
    }

    public function setAbv($abv): self
    {
        $this->abv = $abv;

        return $this;
    }

    public function getStyle(): ?string
    {
        return $this->style;
    }

    public function setStyle(?string $style): self
    {
        $this->style = $style;

        return $this;
    }

    public function getAttributes(): ?string
    {
        return $this->attributes;
    }

    public function setAttributes(?string $attributes): self
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function getOnSale(): ?bool
    {
        return $this->onSale;
    }

    public function setOnSale(bool $onSale): self
    {
        $this->onSale = $onSale;

        return $this;
    }

    public function getBeerId(): ?int
    {
        return $this->beerId;
    }

    public function setBeerId(int $beerId): self
    {
        $this->beerId = $beerId;

        return $this;
    }

    public function getProductId(): ?int
    {
        return $this->productId;
    }

    public function setProductId(int $productId): self
    {
        $this->productId = $productId;

        return $this;
    }

    public function getBrewer(): ?Brewer
    {
        return $this->brewer;
    }

    public function setBrewer(?Brewer $brewer): self
    {
        $this->brewer = $brewer;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
