<?php declare(strict_types=1);

namespace Palmyr\WebApp\Http\ControllerManager;

use Palmyr\WebApp\Http\Controller\ControllerInterface;
use Palmyr\WebApp\Http\Request\RequestInterface;

interface ControllerManagerInterface
{

    public function getController(RequestInterface $request): ControllerInterface;
}