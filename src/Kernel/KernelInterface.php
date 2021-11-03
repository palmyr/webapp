<?php declare(strict_types=1);

namespace Palmyr\WebApp\Kernel;

use Palmyr\WebApp\Http\Request\RequestInterface;

interface KernelInterface
{

    static public function init(): KernelInterface;

    public function handle(RequestInterface $request): KernelInterface;

    public function close(): void;

}