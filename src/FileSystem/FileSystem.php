<?php declare(strict_types=1);

namespace Palmyr\WebApp\FileSystem;

class FileSystem implements FileSystemInterface
{

    public function exists(string $path): bool
    {
       return file_exists($path);
    }

    public function open(string $path, string $mode = 'r'): File
    {
        return new File($path, $mode);
    }
}