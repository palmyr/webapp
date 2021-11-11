<?php declare(strict_types=1);

namespace Palmyr\WebApp\Http\ControllerManager;


use Palmyr\WebApp\Container\ContainerInterface;
use Palmyr\WebApp\Controller\RouteNotFoundController;
use Palmyr\WebApp\Http\Controller\ControllerInterface;
use Palmyr\WebApp\Http\Loader\RouteLoaderInterface;
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

        if ( $params = $this->controllerFinder->getByPath($request->getPathInfo())) {
            $controllerClass = $params['class'];
            $request->attributes->add($params['arguments']);
        } else {
            $controllerClass = RouteNotFoundController::class;
        }

        return $this->container->get($controllerClass);
    }

    public function addLoader(RouteLoaderInterface $loader): ControllerManagerInterface
    {
        $this->loaders[] = $loader;

        return $this;
    }
}