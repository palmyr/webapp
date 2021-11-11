<?php declare(strict_types=1);

namespace Palmyr\WebApp\Configuration\Loader;

use Palmyr\WebApp\FileSystem\FileSystemInterface;

trait FileConfigurationLoaderTrait
{

    protected FileSystemInterface $fileSystem;

    protected function getFileSystem(): FileSystemInterface
    {
        if ( !isset($this->fileSystem) ) {
            $this->fileSystem = $this->container->get(FileSystemInterface::class);
        }

        return $this->fileSystem;
    }
}