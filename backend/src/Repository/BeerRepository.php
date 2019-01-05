<?php

namespace App\Repository;

use App\Entity\Beer;
use App\Entity\Brewer;
use App\Entity\Category;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Beer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Beer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Beer[]    findAll()
 * @method Beer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BeerRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Beer::class);
    }

    public function createNewBeer(object $apiBeer) : Beer
    {
        $brewer = $this->_em
            ->getRepository(Brewer::class)
            ->findBrewerOrCreateByName($apiBeer->brewer, $apiBeer->country);

        $category = $this->_em
            ->getRepository(Category::class)
            ->findOneOrCreateByName($apiBeer->category);

        $type = $this->_em
            ->getRepository(Type::class)
            ->findOneOrCreateByName($apiBeer->category);

        $beer = new Beer();
        $beer->setName($apiBeer->name);
        $beer->setSize($apiBeer->size);
        $beer->setPrice($apiBeer->price);
        $beer->setPricePerLiter($apiBeer->price);
        $beer->setImageUrl($apiBeer->image_url);
        $beer->setAbv($apiBeer->abv);
        $beer->setOnSale($apiBeer->on_sale);
        $beer->setBeerId($apiBeer->beer_id);
        $beer->setProductId($apiBeer->product_id);
        $beer->setBrewer($brewer);
        $beer->setCategory($category);
        $beer->setType($type);

        if ($apiBeer->style !== 'N/A') $beer->setStyle($apiBeer->style);
        if ($apiBeer->attributes !== 'N/A') $beer->setAttributes($apiBeer->style);

        return $beer;
    }
}
