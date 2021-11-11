<?php declare(strict_types=1);

namespace Palmyr\WebApp\Render\Loader;

use Palmyr\WebApp\Configuration\Exception\ConfigurationException;
use Palmyr\WebApp\Configuration\Loader\AbstractConfigurationLoader;
use Palmyr\WebApp\Configuration\Loader\FileConfigurationLoaderTrait;
use Palmyr\WebApp\FileSystem\File;
use Palmyr\WebApp\Render\RenderInterface;

class TemplateDirectoryLoader extends AbstractConfigurationLoader
{

    use FileConfigurationLoaderTrait;

    public function load(string $config): void
    {
        /** @var RenderInterface $render */
        $render = $this->container->get(RenderInterface::class);

        if ( !$this->getFileSystem()->isDirectory($config) ) {
            throw new ConfigurationException('Failed to load the directory');
        }

        $result = $this->getFileSystem()->search($config . DIRECTORY_SEPARATOR . '**.template.php');

        /** @var File $file */
        foreach ( $result as $file ) {
            $render->addTemplate($file->getFilename(), $file->getRealPath());
        }
    }


}