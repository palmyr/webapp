<?php declare(strict_types=1);

namespace Palmyr\WebApp\Controller;

use Palmyr\WebApp\Http\Controller\AbstractController;
use Palmyr\WebApp\Http\Request\RequestInterface;
use Palmyr\WebApp\Http\Response\Response;
use Palmyr\WebApp\Http\Response\ResponseInterface;

class BaseController extends AbstractController
{

    public function get(RequestInterface $request): ResponseInterface
    {
        $content = $this->render->render('base');
        return new Response($content);
    }
}