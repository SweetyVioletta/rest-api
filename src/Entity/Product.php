<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use InvalidArgumentException;

/**
 *  @ORM\Entity(repositoryClass="ProductProductRepository")
 */
class Product
{
    /**
     * @id
     * @Column(type="integer")
     * @ORM\GeneratedValue()
     */
    protected $id;

    /**
     * @Column(type="string", name="name", length=256, nullable=false)
     */
    protected $name;

    /**
     * @Column(type="decimal", name="price", nullable=false)
     */
    protected $price;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $len = strlen($name);
        if ($len < 2 || $len > 256) {
            throw new InvalidArgumentException('Name needs to have more then 2 characters and less 256 characters.');
        }
        $this->name = $name;
    }
    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        if ($price < 0) {
            throw new InvalidArgumentException('Price should be more than 0');
        }
        $this->price = $price;
    }

}