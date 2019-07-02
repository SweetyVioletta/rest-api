<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\Service\OrderService;
use App\Service\ProductService;
use Doctrine\Common\Persistence\ObjectRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends AbstractFOSRestController
{
    /**
     * @var OrderService
     */
    private $orderService;
    /**
     * @var ProductService
     */
    private $productService;

    /**
     * OrderController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->orderService = new OrderService($this->getOrderRepository());
        $this->productService = new ProductService($this->getProductRepository());
    }

    /**
     * @return ObjectRepository
     */
    private function getOrderRepository(): ObjectRepository
    {
        return $this->getDoctrine()->getRepository(Order::class);
    }

    /**
     * @return ObjectRepository
     */
    private function getProductRepository(): ObjectRepository
    {
        return $this->getDoctrine()->getRepository(Product::class);
    }

    /**
     * Create order model
     * @Rest\Post("/create")
     *
     * @param Request $request
     *
     * @return View
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Exception
     */
    public function postCreate(Request $request): View
    {
        $productIds = $request->get('productIds');
        $price = $this->productService->getTotalPrice($productIds);
        if (0 === $price) {
            throw new \Exception('No one product is selected.');
        }
        $order = $this->orderService->addOrder($price);
        return View::create($order, Response::HTTP_CREATED);
    }

    /**
     * Create order model
     * @Rest\Put("/charge")
     *
     * @param Request $request
     *
     * @return View
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Exception
     */
    public function putCharge(Request $request): View
    {
        $id = $request->get('id');
        $price = $request->get('price');
        $order = $this->orderService->chargeOrder($id, $price);
        return View::create($order, Response::HTTP_OK);
    }
}