<?php

namespace App\System;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router;

class App
{
    /**
     * @var Request
     */
    private $request;
    /**
     * @var Router
     */
    private $router;
    /**
     * @var array
     */
    private $routes;
    /**
     * @var RequestContext
     */
    private $requestContext;
    private $controller;
    private $arguments;
    /**
     * @var string
     */
    private $basePath;

    public static $instance = null;

    /**
     * App constructor.
     *
     * @param string|null $basePath
     */
    private function __construct(string $basePath = null)
    {
        $this->basePath = $basePath;
        $this->setRequest();
        $this->setRequestContext();
        $this->setRouter();

        $this->setRoutes();
    }

    /**
     * Setter request
     */
    private function setRequest(): void
    {
        $this->request = Request::createFromGlobals();
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * Setter requestContext
     */
    private function setRequestContext(): void
    {
        $this->requestContext = new RequestContext();
        $this->requestContext->fromRequest($this->request);
    }

    /**
     * @return RequestContext
     */
    public function getRequestContext(): RequestContext
    {
        return $this->requestContext;
    }

    /**
     * Setter router
     */
    private function setRouter(): void
    {
        $fileLocator = new FileLocator([__DIR__]);
        $this->router = new Router(
            new YamlFileLoader($fileLocator),
            //TODO: config dir name to config file
            $this->basePath . '/config/routes.yaml'
        );
    }

    /**
     * @return mixed
     */
    public function getRouter(): Router
    {
        return $this->router;
    }

    /**
     * Setter routes
     */
    private function setRoutes(): void
    {
        $this->routes = $this->router->getRouteCollection();
    }

    /**
     * @param string|null $basePath
     *
     * @return null
     */
    public static function getInstance(string $basePath = null): self
    {
        if (null === static::$instance) {
            static::$instance = new static($basePath);
        }
        return static::$instance;
    }

    public function getController()
    {
        return (new ControllerResolver())->getController($this->request);
    }

    /**
     * @param Controller $controller
     *
     * @return array
     */
    public function getArguments(Controller $controller)
    {
        return (new ArgumentResolver())->getArguments($this->request, $controller);
    }

    public function run(): void
    {
        $response = null;
        $matcher = new UrlMatcher($this->routes, $this->requestContext);
        try {
            $this->request->attributes->add($matcher->match($this->request->getPathInfo()));
            $this->controller = $this->getController();
            $this->arguments = $this->getArguments($this->controller);

            $response = call_user_func_array($this->controller, $this->arguments);
        } catch (Exception $e) {
            exit('error');
        }
        if (null !== $response) {
            $response->send();
        }
    }
}
