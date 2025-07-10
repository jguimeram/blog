<?php

namespace Blog\src\app\interfaces;

interface ResponseInterface
{
    public function setCode(int $code): self;
    public function setMessage(string $message): self;
    public function setHeaders(array $headers): self;
    public function send();
}
