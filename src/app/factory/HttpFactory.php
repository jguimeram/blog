<?php

namespace Blog\src\app\factory;

use Blog\src\app\Request;
use Blog\src\app\Response;

abstract class HttpFactory
{
    public abstract static function create(): Response|Request;
}
