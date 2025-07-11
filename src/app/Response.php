<?php

namespace Blog\src\app;

use Blog\src\app\interfaces\ResponseInterface;

class Response implements ResponseInterface
{
    protected int $code;
    protected string $message;
    protected array $headers = [];


    public function setCode(int $code = 200): self
    {
        $this->code = $code;
        return $this;
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
    public function send()
    {
        if (!headers_sent()) {
            @http_response_code($this->code);
            foreach ($this->headers as $key => $value) {
                @header("$key: $value");
            }
        }
        echo $this->message;
    }
}
