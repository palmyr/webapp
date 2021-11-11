<?php declare(strict_types=1);

namespace Palmyr\WebApp\Http\ControllerManager;

use Palmyr\WebApp\Controller\BaseController;
use Palmyr\WebApp\Http\Controller\ControllerInterface;
use Palmyr\WebApp\Http\Loader\RouteLoaderInterface;

class ControllerFinder implements ControllerFinderInterface
{

    protected array $routes = [];

    public function addRoute(string $route, string $className): ControllerFinderInterface
    {
        $this->routes[$route] = $className;

        return $this;
    }

    public function getByPath(string $basePath): ?array
    {
        $arguments = [];
        foreach ( $this->routes as $route => $class ) {
            list($pattern, $tokens) = $this->buildRouteRegex($route);
            if ( preg_match('/'.$pattern.'/', $basePath, $matches) ) {
                array_shift($matches);
                $matches = array_values($matches);
                foreach ($matches as $key => $value ) {
                    $arguments[$tokens[$key]] = $value;
                }
                return [
                    'class' => $class,
                    'arguments' => $arguments,
                ];
            }
        }

        return null;
    }

    protected function buildRouteRegex(string $route): array
    {
        $pattern = '{{[a-zA-Z0-9]*}}';
        $tokens = [];

        if ( preg_match_all('/'.$pattern.'/', $route, $matches) ) {
            foreach ( $matches as $match ) {
                foreach ( $match as $matchItem ) {
                    $route = str_replace($matchItem, '([a-zA-Z0-9-_]*)', $route);
                    $tokens[] = trim($matchItem, '{}');
                }
            }
        }

        $route = '^' . str_replace('/', '\/', $route) . '$';

        return [$route, $tokens];
    }
}