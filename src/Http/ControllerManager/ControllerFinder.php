<?php declare(strict_types=1);

namespace Palmyr\WebApp\Http\ControllerManager;

use Palmyr\WebApp\Controller\BaseController;
use Palmyr\WebApp\Http\Controller\ControllerInterface;

class ControllerFinder implements ControllerFinderInterface
{

    public array $routes;

    public function loadRoutes(): void
    {
        $this->routes = [
            [
                'route' => '/',
                'controller' => BaseController::class,
            ],
        ];

    }

    public function getByPath(string $basePath): ?ControllerInterface
    {
        foreach ( $this->routes as $route ) {
            if ( $route['route'] === $basePath ) {
                return new $route['controller']();
            }
        }

        return null;
    }
}