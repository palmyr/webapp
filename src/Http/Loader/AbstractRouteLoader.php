<?php declare(strict_types=1);

namespace Palmyr\WebApp\Http\Loader;

use Palmyr\WebApp\Configuration\Loader\AbstractConfigurationLoader;
use Palmyr\WebApp\Controller\BaseController;
use Palmyr\WebApp\Controller\LogController;
use Palmyr\WebApp\Http\ControllerManager\ControllerFinderInterface;

abstract class AbstractRouteLoader extends AbstractConfigurationLoader implements RouteLoaderInterface
{

    private ControllerFinderInterface $controllerFinder;

    public function addRoute(string $route, string $className): RouteLoaderInterface
    {
        $this->getControllerFinder()->addRoute($route, $className);

        return $this;
    }

    private function getControllerFinder(): ControllerFinderInterface
    {
        if ( !isset($this->controllerFinder) ) {
            $this->controllerFinder = $this->container->get(ControllerFinderInterface::class);
        }

        return $this->controllerFinder;
    }

}