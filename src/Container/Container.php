<?php declare(strict_types=1);

namespace Palmyr\WebApp\Container;

use Palmyr\CommonUtils\Collection\ArrayCollection;
use Palmyr\CommonUtils\Collection\Collection;
use Palmyr\WebApp\Http\ControllerManager\ControllerFinder;
use Palmyr\WebApp\Http\ControllerManager\ControllerFinderInterface;
use Palmyr\WebApp\Http\ControllerManager\ControllerManager;
use Palmyr\WebApp\Http\ControllerManager\ControllerManagerInterface;
use Palmyr\WebApp\Http\Loader\RouteLoader;
use Palmyr\WebApp\Http\Loader\RouteLoaderInterface;
use Palmyr\WebApp\Render\Render;
use Palmyr\WebApp\Render\RenderInterface;

class Container implements ContainerInterface
{

    static protected ContainerInterface $instance;

    protected array $services = [];

    protected Collection $parameters;

    protected function __construct(
        ArrayCollection $parameters
    )
    {
        $this->parameters = $parameters;
    }

    public static function init(): ContainerInterface
    {
        if ( !isset(static::$instance) ) {
            static::$instance = new static(new ArrayCollection(['root_dir' => dirname(__FILE__, 3)]));
        }

        return static::$instance;
    }

    public function load(): ContainerInterface
    {

        $this->services[RouteLoaderInterface::class] = new RouteLoader($this->getParameter('root_dir'));
        $this->services[RenderInterface::class] = new Render($this->getParameter('root_dir'));
        $this->services[ControllerFinderInterface::class] = new ControllerFinder($this->get(RouteLoaderInterface::class));
        $this->services[ControllerManagerInterface::class] = new ControllerManager($this->get(ControllerFinderInterface::class));

        return $this;
    }

    public function get(string $service): object
    {
        if ( isset($this->services[$service]) ) {
            return $this->services[$service];
        }

        throw new \RuntimeException('Failed to load service');
    }

    public function set(string $service, object $object): ContainerInterface
    {
        $this->services[$service] = $object;

        return $this;
    }

    public function getParameter(string $parameter)
    {
        if ( $this->parameters->get($parameter) ) {
            return $this->parameters->get($parameter);
        }

        throw new \RuntimeException('No parameter found');
    }

    public function setParameter(string $parameter, $value): ContainerInterface
    {
        $this->parameters->set($parameter, $value);

        return $this;
    }
}