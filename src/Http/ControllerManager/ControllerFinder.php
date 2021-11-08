<?php declare(strict_types=1);

namespace Palmyr\WebApp\Http\ControllerManager;

use Palmyr\WebApp\Controller\BaseController;
use Palmyr\WebApp\Http\Controller\ControllerInterface;
use Palmyr\WebApp\Http\Loader\RouteLoaderInterface;

class ControllerFinder implements ControllerFinderInterface
{

    protected array $routes;

    protected RouteLoaderInterface $routeLoader;

    public function __construct(
        RouteLoaderInterface $routeLoader
    )
    {
        $this->routeLoader = $routeLoader;
    }

    public function loadRoutes(): void
    {
        if ( !isset($this->routes) ) {
            $this->routes = $this->routeLoader->load();
        }
    }

    public function getByPath(string $basePath): ?string
    {
        foreach ( $this->routes as $route => $class ) {
            if ( $route === $basePath ) {
                return $class;
            }
        }

        return null;
    }
}