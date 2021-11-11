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
use Palmyr\WebApp\Render\Loader\TemplateDirectoryLoader;
use Palmyr\WebApp\Render\Render;
use Palmyr\WebApp\Render\RenderInterface;

class Container implements ContainerInterface
{

    static protected ContainerInterface $instance;

    protected string $rootDirectory;

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
            static::$instance = new static(new ArrayCollection());
        }

        return static::$instance;
    }

    public function load(RequestInterface $request): ContainerInterface
    {
        $this->services[RequestInterface::class] = $request;
        $this->setParameter('root_dir', $this->getRootDirectory());

        $coreServicesFile = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'services.php';

        require $coreServicesFile;

        /** @var FileSystemInterface $fileSystem */
        $fileSystem = $this->get(FileSystemInterface::class);

        $routeLoader = new PHPFileRouteLoader($this);
        $routeLoader->load(dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . 'routes.php');

        $applicationRoutesFile = $this->getRootDirectory() . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . 'routes.php';

        if ( $fileSystem->isFile($applicationRoutesFile) ) {
            $routeLoader->load($applicationRoutesFile);
        }

        $templateLoader = new TemplateDirectoryLoader($this);

        $templateLoader->load(dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'html');

        $applicationTemplates = $this->getRootDirectory() . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'html';

        if ( $fileSystem->isFile($applicationTemplates) ) {
            $templateLoader->load($applicationTemplates);
        }


        $applicationServicesFile = $this->getRootDirectory() . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'services.php';

        if ( file_exists($applicationServicesFile) && $coreServicesFile !== $applicationServicesFile ) {
            require $applicationServicesFile;
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

    protected function prepareRootDirectory(RequestInterface $request): void
    {
        if ( !isset($this->rootDirectory) ) {
            $this->rootDirectory = dirname($request->getServer()->get('SCRIPT_FILENAME'), 2);
        }
    }

    protected function getRootDirectory(): string
    {
        $this->prepareRootDirectory($this->get(RequestInterface::class));
        return $this->rootDirectory;
    }
}