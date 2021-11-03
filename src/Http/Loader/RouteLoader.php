<?php declare(strict_types=1);

namespace Palmyr\WebApp\Http\Loader;

use Palmyr\WebApp\Controller\BaseController;

class RouteLoader implements RouteLoaderInterface
{

    protected string $rootDirectory;

    public function __construct(
        string $rootDirectory
    )
    {
        $this->rootDirectory = $rootDirectory;
    }

    public function load(): array
    {
        $routes = [];

        $this->loadCoreRoutes($routes);

        return $routes;
    }

    protected function loadCoreRoutes(array &$routes): void
    {
        $routes['/'] = BaseController::class;
    }
}