<?php declare(strict_types=1);

namespace Palmyr\WebApp\Http\Loader;

interface RouteLoaderInterface
{

    public function load(): array;
}