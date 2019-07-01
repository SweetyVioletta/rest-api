<?php


namespace App\Controller;


use App\Entity\Order;
use App\Service\Action\OrderChargeAction;
use App\Service\Action\OrderCreateAction;

class OrderController extends Controller
{
    public function create()
    {
        (new OrderCreateAction())->execute();
    }

    public function charge()
    {
        (new OrderChargeAction())->execute();
    }
}