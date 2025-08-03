<?php

namespace Blog\src\app\interfaces;

interface RequestInterface
{
    public function getMethod(): string;
    public function getPath(): string;
    public function setParams(array $params);
    public function getParams(): array;
}
