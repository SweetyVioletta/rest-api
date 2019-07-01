<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @Table(name="order")
 */
class Order
{
    /**
     * @id
     * @Column(type="integer")
     * @ORM\GeneratedValue()
     */
    public $id;

    /**
     * @Column(type="decimal", name="price", precision=10, scale=2, nullable=false)
     */
    public $price;

}