<?php declare(strict_types=1);

namespace Palmyr\WebApp\Http\Response;

interface ResponseInterface
{

    public function send(): void;

}