<?php

namespace Blog\src\app\factory;

use Blog\src\app\Request;
use Blog\src\app\factory\HttpFactory;

class RequestFactory extends HttpFactory
{
    public static function create(): Request
    {
        return new Request;
    }
}
