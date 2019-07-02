<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\ProductService;
use Doctrine\Common\Persistence\ObjectRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class ProductController
 * @package App\Controller
 */
class ProductController extends AbstractFOSRestController
{
    /**
     * @var ProductService
     */
    private $productService;

    /**
     * ProductController constructor.
     */
    public function __construct()
    {
        Controller::__construct();
        $this->productService = new ProductService($this->getProductRepository());
    }

    /**
     * @return ObjectRepository
     */
    private function getProductRepository(): ObjectRepository
    {
        return $this->getDoctrine()->getRepository(Product::class);
    }

    /**
     * Generates product models
     * @Rest\Post("/generate")
     *
     * @param Request $request
     *
     * @return View
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function postGenerate(Request $request): View
    {
        $products = $this->productService->addProducts($request->get('count'));
        return View::create($products, Response::HTTP_CREATED);
    }

    /**
     * Retrieves a collection of Products resource
     * @Rest\Get("/products")
     */
    public function getProducts()
    {
        $products = $this->productService->getAllProducts();
        return View::create($products, Response::HTTP_OK);
    }
}