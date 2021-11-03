<?php declare(strict_types=1);

namespace Palmyr\WebApp\Container;

use Palmyr\WebApp\Http\ControllerManager\ControllerFinder;
use Palmyr\WebApp\Http\ControllerManager\ControllerFinderInterface;
use Palmyr\WebApp\Http\ControllerManager\ControllerManager;
use Palmyr\WebApp\Http\ControllerManager\ControllerManagerInterface;

class Container implements ContainerInterface
{

    static protected ContainerInterface $instance;

    protected array $services = [];

    public static function init(): ContainerInterface
    {
        if ( !isset(static::$instance) ) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function load(): ContainerInterface
    {

        $this->services[ControllerFinderInterface::class] = new ControllerFinder();
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
}