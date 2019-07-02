<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Table;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @Table(name="order")
 */
class Order
{
    public const STATUS_CREATED = 0;
    public const STATUS_CHARGED = 1;

    /**
     * @id
     * @Column(type="integer")
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @Column(type="decimal", name="price", precision=10, scale=2, nullable=false)
     */
    private $price;

    /**
     * @Column(type="int", name="status", default=0, nullable=false)
     */
    private $status;

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return bool
     */
    public function getIsCharged(): bool
    {
        return static::STATUS_CHARGED === $this->status;
    }

}