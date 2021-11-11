<?php declare(strict_types=1);

namespace Palmyr\WebApp\Http\ControllerManager;

interface ControllerFinderInterface
{

    public function addRoute(string $route, string $className): ControllerFinderInterface;

    public function getByPath(string $basePath): ?array;
}