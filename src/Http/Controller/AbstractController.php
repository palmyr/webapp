<?php declare(strict_types=1);

namespace Palmyr\WebApp\Http\Controller;

use Palmyr\WebApp\Http\Request\RequestInterface;
use Palmyr\WebApp\Http\Response\Response;
use Palmyr\WebApp\Http\Response\ResponseInterface;
use Palmyr\WebApp\Render\Render;
use Palmyr\WebApp\Render\RenderInterface;

abstract class AbstractController implements ControllerInterface
{

    protected RenderInterface $render;

    /**
     * @param RenderInterface $render
     */
    public function setRender(RenderInterface $render): ControllerInterface
    {
        $this->render = $render;

        return $this;
    }
}