<?php declare(strict_types=1);

namespace Palmyr\WebApp\Http\Controller;

use Palmyr\WebApp\Http\Request\RequestInterface;
use Palmyr\WebApp\Http\Response\ResponseInterface;
use Palmyr\WebApp\Render\RenderInterface;

interface ControllerInterface
{

    public function get(RequestInterface $request): ResponseInterface;

    public function setRender(RenderInterface $render): ControllerInterface;
}