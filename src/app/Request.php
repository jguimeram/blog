<?php

namespace Blog\src\app;

use Blog\src\app\interfaces\RequestInterface;

class Request implements RequestInterface
{
    private string $method;
    private string $path;
    private array $params = [];

    private function normalizePath(string $path): string
    {
        $trimmed = rtrim($path, "/");  // Remove trailing slashes
        $parsed = parse_url($trimmed, PHP_URL_PATH);  // Extract path component
        return strtolower($parsed);  // Ensure case consistency
    }

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->path = $this->normalizePath($_SERVER['REQUEST_URI']);
    }

    public function getMethod(): string
    {
        return $this->method;
    }
    public function getPath(): string
    {
        return $this->path;
    }

    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
