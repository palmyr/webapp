<?php declare(strict_types=1);

use Palmyr\WebApp\Controller\BaseController;
use Palmyr\WebApp\Controller\LogController;
use Palmyr\WebApp\FileSystem\FileSystem;
use Palmyr\WebApp\FileSystem\FileSystemInterface;
use Palmyr\WebApp\Http\Controller\RouteNotFoundController;
use Palmyr\WebApp\Http\ControllerManager\ControllerFinder;
use Palmyr\WebApp\Http\ControllerManager\ControllerFinderInterface;
use Palmyr\WebApp\Http\ControllerManager\ControllerManager;
use Palmyr\WebApp\Http\ControllerManager\ControllerManagerInterface;
use Palmyr\WebApp\Render\Render;
use Palmyr\WebApp\Render\RenderInterface;

$this->services[BaseController::class] = new BaseController();
$this->services[LogController::class] = new LogController($this->getRootDirectory());
$this->services[RouteNotFoundController::class] = new RouteNotFoundController();
$this->services[RenderInterface::class] = new Render();
$this->services[ControllerFinderInterface::class] = (new ControllerFinder());
$this->services[FileSystemInterface::class] = $fileSystem = new FileSystem();
$this->services[ControllerManagerInterface::class] = new ControllerManager($this, $this->get(ControllerFinderInterface::class));
