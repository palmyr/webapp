<?php declare(strict_types=1);

namespace Palmyr\WebApp\Http\Routes;

interface RouteInterface
{

    public function load(): array;
}