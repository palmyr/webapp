<?php declare(strict_types=1);

namespace Palmyr\WebApp\Http\Response;

class JsonResponse extends Response
{

    protected array $data;

    public function __construct(array $data, int $responseCode = 200, array $headers = [])
    {
        parent::__construct('', $responseCode, $headers);
        $this->data = $data;
    }

    protected function setDefaults(): void
    {
        parent::setDefaults();
        $this->headers['Content-Type'] = 'application/json; charset=utf-8';
    }

    protected function sendContent(): void
    {
        $this->content = json_encode($this->data);
        parent::sendContent();
    }
}