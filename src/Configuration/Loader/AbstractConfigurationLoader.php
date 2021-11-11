<?php declare(strict_types=1);

namespace Palmyr\WebApp\Configuration\Loader;

use Palmyr\WebApp\Container\ContainerInterface;

abstract class AbstractConfigurationLoader implements ConfigurationLoaderInterface
{

    protected ContainerInterface $container;

    public function __construct(
        ContainerInterface $container
    )
    {
        $this->container = $container;
    }

}