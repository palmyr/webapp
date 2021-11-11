<?php declare(strict_types=1);

namespace Palmyr\WebApp\Kernel;

use Palmyr\WebApp\Container\Container;
use Palmyr\WebApp\Container\ContainerInterface;
use Palmyr\WebApp\Http\Controller\ControllerInterface;
use Palmyr\WebApp\Http\ControllerManager\ControllerManagerInterface;
use Palmyr\WebApp\Http\Request\RequestInterface;
use Palmyr\WebApp\Http\Response\Response;
use Palmyr\WebApp\Render\RenderInterface;

class Kernel implements KernelInterface
{

    static protected KernelInterface $instance;

    protected ContainerInterface $container;

    protected function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public static function init(): KernelInterface
    {
        if ( !isset(static::$instance) ) {
            static::$instance = new static(Container::init());
        }

        return static::$instance;
    }

    public function handle(RequestInterface $request): KernelInterface
    {
        $this->loadContainer($request);
        /** @var ControllerManagerInterface $controllerManager */
        $controllerManager = $this->container->get(ControllerManagerInterface::class);

        /** @var ControllerInterface $controller */
        $controller = $controllerManager->getController($request);

        $controller->setRender($this->container->get(RenderInterface::class));

        $method = $request->getMethod();

        /** @var Response $response */
        $response = $controller->$method($request);

        $response->send();

        return $this;
    }

    public function close(): void
    {
        unset($this->container);
    }

    protected function loadContainer(RequestInterface $request): void
    {
        $this->container->load($request);
    }
}