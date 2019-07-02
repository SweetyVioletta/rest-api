<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Class ProductService
 * @package App\Service
 */
final class ProductService extends Service
{
    protected const PREFIX_NAME = 'Product_';
    protected const MIN_RICE = 1.3;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * ProductService constructor.
     *
     * @param ProductRepository $productRepository
     */
    public function __construct(ObjectRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param int $productId
     *
     * @return Product|null
     */
    public function getProduct(int $productId): ?Product
    {
        return $this->productRepository->findById($productId);
    }

    /**
     * @return array|null
     */
    public function getAllProducts(): ?array
    {
        return $this->productRepository->findAll();
    }

    /**
     * @param string $name
     * @param float $price
     *
     * @return Product
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addProduct(string $name, float $price): Product
    {
        $product = new Product();
        $product->setName($name);
        $product->setPrice($price);
        $entityManager = $this->getEntityManager();
        $entityManager->persist($product);
        $entityManager->flush();
        $entityManager->clear();
        return $product;
    }

    /**
     * create products batch.
     * @param int $count
     *
     * @return array
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addProducts(int $count = 20): array
    {
        $entityManager = $this->getEntityManager();
        $models = [];
        for ($i = 0; $i < $count; $i++) {
            $model = new Product();
            $model->setName(static::PREFIX_NAME . $i);
            $model->setPrice(($i + 1) * static::MIN_RICE);
            $entityManager->persist($model);
            $models[] = $model;
        }
        $entityManager->flush();
        $entityManager->clear();
        return $models;
    }

    /**
     * @param array $productIds
     *
     * @return float
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getTotalPrice(array $productIds): float
    {
        return $this->productRepository->getTotalPriceByIds($productIds);
    }
}
