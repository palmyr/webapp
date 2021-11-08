<?php declare(strict_types=1);

namespace Palmyr\WebApp\Http\Request;

use Palmyr\CommonUtils\Collection\Collection;

interface RequestInterface
{

    static public function createFromGlobals(): RequestInterface;

    public function getMethod(): string;

    public function getRequestUri(): string;

    public function getPathInfo(): string;

    public function getDocumentRoot(): string;

    public function getServer(): Collection;
}