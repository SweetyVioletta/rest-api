<?php
namespace App\Controller;

use App\Entity\Product;
use App\Helpers\AppHelper;
use Doctrine\ORM\EntityManager;

class IndexController extends Controller
{
    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function indexAction()
    {
        /** @var EntityManager $entityManager */
        $entityManager = AppHelper::app()->get('orm')->getEntityManager();
        $product = new Product();
        $product->name = 'Name product';
        $product->price = 10.5;
        $entityManager->persist($product);
        $entityManager->flush();

        $this->render('index');
    }
}