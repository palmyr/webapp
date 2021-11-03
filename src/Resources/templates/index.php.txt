<?php declare(strict_types=1);

use Palmyr\WebApp\Kernel\Kernel;
use Palmyr\WebApp\Http\Request\Request;

require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';


Kernel::init()
    ->handle(Request::createFromGlobals())
    ->close();
