<?php declare(strict_types=1);

namespace Palmyr\WebApp\Http\Response;

class Response implements ResponseInterface
{

    protected string $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function send(): void
    {
        $this->sendHeaders();
        $this->sendCookies();
        $this->sendContent();
    }

    protected function sendHeaders(): void
    {

    }

    protected function sendCookies(): void
    {

    }

    protected function sendContent(): void
    {
        echo $this->content;
    }
}