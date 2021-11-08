<?php declare(strict_types=1);

namespace Palmyr\WebApp\Http\ControllerManager;

use Palmyr\WebApp\Http\Controller\ControllerInterface;

interface ControllerFinderInterface
{

    public function loadRoutes(): void;

    public function getByPath(string $basePath): ?string;
}