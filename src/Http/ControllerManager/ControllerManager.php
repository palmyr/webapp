<?php declare(strict_types=1);

namespace Palmyr\WebApp\Http\ControllerManager;

use Palmyr\WebApp\Controller\BaseController;
use Palmyr\WebApp\Controller\RouteNotFoundController;
use Palmyr\WebApp\Http\Controller\ControllerInterface;
use Palmyr\WebApp\Http\Request\RequestInterface;

class ControllerManager implements ControllerManagerInterface
{

    protected ControllerFinderInterface $controllerFinder;

    public function __construct(
        ControllerFinderInterface $controllerFinder
    )
    {
        $this->controllerFinder = $controllerFinder;
    }

    public function getController(RequestInterface $request): ControllerInterface
    {

        $this->controllerFinder->loadRoutes();

        if ( !$controller = $this->controllerFinder->getByPath($request->getPathInfo()) ) {
            $controller = new RouteNotFoundController();
        }


        return $controller;
    }
}