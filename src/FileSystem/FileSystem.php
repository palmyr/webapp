<?php declare(strict_types=1);

namespace Palmyr\WebApp\FileSystem;

use Palmyr\CommonUtils\Collection\ArrayCollection;
use Palmyr\CommonUtils\Collection\Collection;

class FileSystem implements FileSystemInterface
{

    public function exists(string $path): bool
    {
       return file_exists($path);
    }

    public function isFile(string $path): bool
    {
        return is_file($path);
    }

    public function isDirectory(string $path): bool
    {
        return is_dir($path);
    }

    public function scanDirectory(string $path): Collection
    {
        return [];
    }

    public function search(string $path): Collection
    {
        $result = glob($path);

        $result = array_map(function (string $path): File {
            return new File($path);
        },
        $result);

        return new ArrayCollection($result);
    }

    public function open(string $path, string $mode = 'r'): File
    {
        return new File($path, $mode);
    }
}