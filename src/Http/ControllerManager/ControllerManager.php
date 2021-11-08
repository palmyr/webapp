<?php declare(strict_types=1);

namespace Palmyr\WebApp\Http\ControllerManager;


use Palmyr\WebApp\Container\ContainerInterface;
use Palmyr\WebApp\Http\Controller\RouteNotFoundController;
use Palmyr\WebApp\Http\Controller\ControllerInterface;
use Palmyr\WebApp\Http\Request\RequestInterface;

class ControllerManager implements ControllerManagerInterface
{

    protected ContainerInterface $container;

    protected ControllerFinderInterface $controllerFinder;

    public function __construct(
        ContainerInterface $container,
        ControllerFinderInterface $controllerFinder
    )
    {
        $this->container = $container;
        $this->controllerFinder = $controllerFinder;
    }

    public function getController(RequestInterface $request): ControllerInterface
    {

        $this->controllerFinder->loadRoutes();

        if ( !$controllerClass = $this->controllerFinder->getByPath($request->getPathInfo()) ) {
            $controllerClass = RouteNotFoundController::class;
        }

        return $this->container->get($controllerClass);
    }
}