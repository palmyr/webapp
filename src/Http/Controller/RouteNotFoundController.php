<?php declare(strict_types=1);

namespace Palmyr\WebApp\Http\Controller;

use Palmyr\WebApp\Http\Request\RequestInterface;
use Palmyr\WebApp\Http\Response\Response;
use Palmyr\WebApp\Http\Response\ResponseInterface;

class RouteNotFoundController extends AbstractController
{

    public function get(RequestInterface $request): ResponseInterface
    {
        return new Response('Not found');
    }
}