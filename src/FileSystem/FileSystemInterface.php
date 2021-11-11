<?php declare(strict_types=1);

namespace Palmyr\WebApp\FileSystem;

use Palmyr\CommonUtils\Collection\Collection;

interface FileSystemInterface
{

    public function exists(string $path): bool;

    public function isFile(string $path): bool;

    public function isDirectory(string $path): bool;

    public function scanDirectory(string $path): Collection;

    public function search(string $path): Collection;

    public function open(string $path, string $mode = 'r'): File;

}