<?php declare(strict_types=1);

namespace Palmyr\WebApp\Controller;

use Palmyr\WebApp\Http\Controller\AbstractController;
use Palmyr\WebApp\Http\Request\RequestInterface;
use Palmyr\WebApp\Http\Response\Response;
use Palmyr\WebApp\Http\Response\ResponseInterface;

class LogController extends AbstractController
{

    protected string $rootDirectory;

    public function __construct(
        string $rootDirectory
    )
    {
        $this->rootDirectory = $rootDirectory;
    }

    public function get(RequestInterface $request): ResponseInterface
    {

        $filePath = $this->rootDirectory . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR . 'app.log';

        if ( !$file = @fopen($filePath, 'a') ) {
            return new Response('Failed to write to file', 500);
        }

        $type = (string)$request->attributes->get('type');
        $message = (string)$request->attributes->get('message');

        fwrite($file, sprintf('%s: %s' . PHP_EOL, $type, $message));

        fclose($file);

        return new Response('Data logged!!!');
    }
}