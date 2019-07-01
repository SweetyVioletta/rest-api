<?php

namespace App\Controller;

use App\System\View\View;
use App\System\Controller\ControllerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Controller
 * @package App\Controller
 */
abstract class Controller extends AbstractFOSRestController implements ControllerInterface
{
    /**
     * @var View
     */
    protected $view;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->view = new View();
    }

    public function render(string $path, array $data = []): Response
    {
        return new Response($this->view->make($path, $data));
    }
}