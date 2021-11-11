<?php declare(strict_types=1);

namespace Palmyr\WebApp\FileSystem;

interface FileSystemInterface
{

    public function exists(string $path): bool;

    public function open(string $path, string $mode = 'r'): File;

}