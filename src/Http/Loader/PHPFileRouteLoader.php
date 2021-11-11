<?php declare(strict_types=1);

namespace Palmyr\WebApp\Http\Loader;

use Palmyr\WebApp\Configuration\Exception\ConfigurationException;
use Palmyr\WebApp\Configuration\Loader\AbstractConfigurationLoader;
use Palmyr\WebApp\Configuration\Loader\FileConfigurationLoaderTrait;

class PHPFileRouteLoader extends AbstractRouteLoader
{

    use FileConfigurationLoaderTrait;

    public function load(string $config): array
    {
        if ( !$this->getFileSystem()->exists($config) ) {
            throw new ConfigurationException('Failed to locate configuration');
        }

        $data = include $config;

        foreach ( $data['routes'] as $route => $className ) {
            $this->addRoute($route, $className);
        }

        return [];
    }
}