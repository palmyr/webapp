<?php declare(strict_types=1);

namespace Palmyr\WebApp\Container;

use Palmyr\CommonUtils\Collection\ArrayCollection;
use Palmyr\CommonUtils\Collection\Collection;
use Palmyr\WebApp\Controller\BaseController;
use Palmyr\WebApp\Controller\LogController;
use Palmyr\WebApp\FileSystem\FileSystem;
use Palmyr\WebApp\FileSystem\FileSystemInterface;
use Palmyr\WebApp\Http\Controller\RouteNotFoundController;
use Palmyr\WebApp\Http\ControllerManager\ControllerFinder;
use Palmyr\WebApp\Http\ControllerManager\ControllerFinderInterface;
use Palmyr\WebApp\Http\ControllerManager\ControllerManager;
use Palmyr\WebApp\Http\ControllerManager\ControllerManagerInterface;
use Palmyr\WebApp\Http\Loader\PHPFileRouteLoader;
use Palmyr\WebApp\Http\Loader\RouteLoader;
use Palmyr\WebApp\Http\Loader\RouteLoaderInterface;
use Palmyr\WebApp\Http\Request\RequestInterface;
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
            $container = static::$instance = new static(new ArrayCollection());
        }

        return static::$instance;
    }

    public function load(RequestInterface $request): ContainerInterface
    {
        $this->setParameter('root_dir', $this->getRootDirectory($request));
        $this->services[RequestInterface::class] = $request;
        $this->services[BaseController::class] = new BaseController();
        $this->services[LogController::class] = new LogController($this->getParameter('root_dir'));
        $this->services[RouteNotFoundController::class] = new RouteNotFoundController();
        $this->services[RenderInterface::class] = new Render($this->getParameter('root_dir'));
        $this->services[ControllerFinderInterface::class] = (new ControllerFinder());
        $this->services[FileSystemInterface::class] = new FileSystem();
        $this->services[ControllerManagerInterface::class] = new ControllerManager($this, $this->get(ControllerFinderInterface::class));

        $routeLoader = new PHPFileRouteLoader($this);

        $routeLoader->load(dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . 'routes.php');

        $servicesFile = $this->getParameter('root_dir') . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'services.php';

        if ( file_exists($servicesFile) ) {
            require $servicesFile;
        }

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

    protected function getRootDirectory(RequestInterface $request): string
    {
        return dirname($request->getServer()->get('SCRIPT_FILENAME'), 2);
    }
}