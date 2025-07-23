<?php

namespace Blog\src\app\interfaces;

interface ResponseInterface
{
    public function setCode(int $code): self;
    public function setMessage(string $message): self;
    public function setHeaders(array $headers): self;
    public function json(array $json): self;
    public function text(string $text): self;
    public function html(string $html): self;
    public function send();
}
