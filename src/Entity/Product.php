<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity()
 * @Table(name="product")
 */
class Product
{
    /**
     * @id
     * @Column(type="integer")
     * @ORM\GeneratedValue()
     */
    public $id;

    /**
     * @Column(type="string", name="name", length=256, nullable=false)
     */
    public $name;

    /**
     * @Column(type="decimal", name="price", nullable=false)
     */
    public $price;

}