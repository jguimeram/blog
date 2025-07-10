<?php

namespace Blog\src\app\factory;

use Blog\src\app\Response;
use Blog\src\app\factory\HttpFactory;

class ResponseFactory extends HttpFactory
{
    public static function create(): Response
    {
        return new Response;
    }
}
