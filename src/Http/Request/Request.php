<?php declare(strict_types=1);

namespace Palmyr\WebApp\Http\Request;

class Request implements RequestInterface
{

    protected array $server;

    public function __construct(
        array $server
    )
    {
        $this->server = $server;
    }

    public static function createFromGlobals(): RequestInterface
    {
        return new static($_SERVER);
    }

    public function getMethod(): string
    {
        return 'get';
    }

    public function getRequestUri(): string
    {
        $requestUri = $this->server['REQUEST_URI'];

        $pieces = explode('?', $requestUri);

        if ( substr($pieces[0], -1) !== '/' ) {
            $pieces[0] .= '/';
        }

        return $pieces[0];
    }

    public function getBaseUrl(): string
    {

        $scriptName = dirname($this->server['SCRIPT_NAME']);

        $baseUrl = rtrim($scriptName, '/');

        return $baseUrl;
    }

    public function getPathInfo(): string
    {
        $baseUrl = $this->getBaseUrl();
        $requestUri = $this->getRequestUri();

        return substr($requestUri, strlen($baseUrl));
    }

    public function getDocumentRoot(): string
    {
        return $this->server['DOCUMENT_ROOT'];
    }
}