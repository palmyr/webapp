<?php declare(strict_types=1);

namespace Palmyr\WebApp\Http\Loader;

use Palmyr\WebApp\Configuration\Loader\ConfigurationLoaderInterface;

interface RouteLoaderInterface extends ConfigurationLoaderInterface
{

    public function addRoute(string $route, string $className): RouteLoaderInterface;
}