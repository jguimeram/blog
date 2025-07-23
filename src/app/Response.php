<?php

declare(strict_types=1);


namespace Blog\src\app;

use Blog\src\app\interfaces\ResponseInterface;

class Response implements ResponseInterface
{
    private const DEFAULT_STATUS_CODE = 200;
    private const HEADER_CONTENT_TYPE = 'Content-Type';
    private const MIME_JSON = 'application/json; charset=utf-8';
    private const MIME_HTML = 'text/html; charset=utf-8';
    private const MIME_TEXT = 'text/plain; charset=utf-8';

    private int $code = self::DEFAULT_STATUS_CODE;
    private string $message = '';
    private array $headers = [];




    public function setCode(int $code = self::DEFAULT_STATUS_CODE): self
    {
        $clone = clone $this;
        $clone->code = $code;
        return $clone;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function setHeaders(array $headers): self
    {
        $this->headers = array_merge($this->headers, $headers);
        return $this;
    }

    public function json(array $json): self
    {
        $this->setHeaders([self::HEADER_CONTENT_TYPE, self::MIME_JSON]);
        $this->setMessage(json_encode($json));
        return $this;
    }

    public function text(string $text): self
    {
        $this->setHeaders([self::HEADER_CONTENT_TYPE, self::MIME_TEXT]);
        $this->setMessage($text);
        return $this;
    }

    public function html(string $html): self
    {
        $this->setHeaders([self::HEADER_CONTENT_TYPE, self::MIME_HTML]);
        $this->setMessage($html);
        return $this;
    }


    public function send()
    {
        http_response_code($this->code);
        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }
        echo $this->message;
    }
}
