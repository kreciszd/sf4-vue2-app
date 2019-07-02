<?php

namespace App\Tests\Entity;

use App\Entity\Beer;
use PHPUnit\Framework\TestCase;

class BeerTest extends TestCase
{
    public function testSettersGetters(): void
    {
        $name = 'New beer';
        $id = 2;

        $beer = new Beer();
        $beer->setBeerId($id);
        $beer->setName($name);

        $this->assertSame($name, $beer->getName());
        $this->assertSame($id, $beer->getBeerId());
    }
}