<?php

namespace App\Service;

use App\Entity\Order;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityNotFoundException;
use InvalidArgumentException;
use Symfony\Component\HttpClient\HttpClient;

/**
 * Class OrderService
 * @package App\Service
 */
final class OrderService extends Service
{
    protected const STATUS_OK = 200;

    /**
     * @var ObjectRepository
     */
    private $orderRepositrory;

    /**
     * OrderService constructor.
     *
     * @param ObjectRepository $orderRepositrory
     */
    public function __construct(ObjectRepository $orderRepositrory)
    {
        $this->orderRepositrory = $orderRepositrory;
    }

    /**
     * @param float $price
     *
     * @return Order
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addOrder(float $price): Order
    {
        $order = new Order();
        $order->setPrice($price);
        $order->setStatus(Order::STATUS_CREATED);
        $entityManager = $this->getEntityManager();
        $entityManager->persist($order);
        $entityManager->flush();
        $entityManager->clear();
        return $order;
    }

    /**
     * @param int $id
     *
     * @return Order|null
     */
    public function getOrder(int $id): ?Order
    {
        return $this->orderRepositrory->findById($id);
    }

    /**
     * @param int $id
     * @param float $price
     *
     * @return Order
     * @throws EntityNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \Exception
     */
    public function chargeOrder(int $id, float $price): Order
    {
        $order = $this->getOrder($id);
        if (null === $order) {
            throw new EntityNotFoundException("Order #$id does not exist!");
        }
        if ($order->getIsCharged()) {
            throw new EntityNotFoundException("Order #$id is already charged!");
        }
        if ($price !== $order->getPrice()) {
            throw new InvalidArgumentException('Price is not equal order price!');
        }
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://ya.ru');
        if (static::STATUS_OK !== $response->getStatusCode()) {
            throw new \Exception('Service ya.ru is not available.');
        }
        $order->setStatus(Order::STATUS_CHARGED);

        $entityManager = $this->getEntityManager();
        $entityManager->persist($order);
        $entityManager->flush();
        return $order;
    }

}