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
        $this->loadApplicationRoutes($routes);

        return $routes;
    }

    protected function loadCoreRoutes(array &$routes): void
    {
        $routes['/'] = BaseController::class;
    }

    protected function loadApplicationRoutes(array &$routes): void
    {
        require $this->rootDirectory . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'routes.php';
    }
}