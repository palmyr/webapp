<?php declare(strict_types=1);

namespace Palmyr\WebApp\Http\Response;

class Response implements ResponseInterface
{

    protected string $content;

    protected int $responseCode;

    protected array $headers = [];

    public function __construct(string $content, int $responseCode = 200, array $headers = [])
    {
        $this->content = $content;
        $this->responseCode = $responseCode;
        $this->headers = $headers;
        $this->setDefaults();
    }

    public function send(): void
    {
        $this->sendHeaders();
        $this->sendCookies();
        $this->sendContent();
    }

    protected function setDefaults(): void
    {
        $this->headers['Application'] = 'webapp';
    }

    protected function sendHeaders(): void
    {
        http_response_code($this->responseCode);

        foreach ( $this->headers as $header => $value ) {
            header(sprintf('%s: %s', $header, $value));
        }
    }

    protected function sendCookies(): void
    {

    }

    protected function sendContent(): void
    {
        echo $this->content;
    }
}