<?php declare(strict_types=1);

namespace Palmyr\WebApp\Container;

interface ContainerInterface
{

    public static function init(): ContainerInterface;

    public function load(): ContainerInterface;

    public function get(string $service): object;

}