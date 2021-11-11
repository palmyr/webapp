<?php declare(strict_types=1);

namespace Palmyr\WebApp\Configuration\Loader;

interface ConfigurationLoaderInterface
{

    public function load(string $config): void;

}