<?php

namespace App\Controller;

use App\Entity\Product;
use App\Helpers\AppHelper;
use App\Repository\ProductRepository;
use App\Service\Action\ProductGenerateAction;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * @return Response
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function generate()
    {
        (new ProductGenerateAction())->execute();
        $response = new Response();
        $response->setStatusCode(200);
        return $this->handleView($this->view('OK'));
    }

    /**
     * @return Response
     */
    public function index()
    {
        /** @var EntityManager $entityManager */
        $entityManager = AppHelper::app()->get('orm')->getEntityManager();
        $classMetadata = new ClassMetadata(Product::class);
        $repository = new ProductRepository($entityManager, $classMetadata);
        $products = $repository->findAllOrderedByName();
        return $this->handleView($this->view($products));
    }
}