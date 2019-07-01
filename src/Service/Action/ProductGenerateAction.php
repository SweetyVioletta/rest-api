<?php

namespace App\Service\Action;

use App\Entity\Product;
use App\Helpers\AppHelper;
use Doctrine\ORM\EntityManager;

class ProductGenerateAction implements ActionInterface
{
    protected const SIZE = 20;
    protected const PREFIX_NAME = 'Product_';
    protected const MIN_RICE = 1.3;

    /**
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function execute(): void
    {
        /** @var EntityManager $entityManager */
        $entityManager = AppHelper::app()->get('orm')->getEntityManager();
        for ($i = 0; $i < static::SIZE; $i++) {
            $model = new Product();
            $model->name = static::PREFIX_NAME . $i;
            $model->price = ($i + 1) * static::MIN_RICE;
            $entityManager->persist($model);
        }
        $entityManager->flush();
        $entityManager->clear();
    }
}