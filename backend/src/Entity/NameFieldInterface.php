<?php
/**
 * Created by PhpStorm.
 * User: dawid
 * Date: 05.01.19
 * Time: 15:17
 */

namespace App\Entity;


interface NameFieldInterface
{
    public function setName(string $name) :NameFieldInterface;

    public function getName() :?string ;
}