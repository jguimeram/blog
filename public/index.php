<?php

require('../bootstrap.php');

use Blog\src\app\Router;
use Blog\src\app\interfaces\RequestInterface as Request;
use Blog\src\app\interfaces\ResponseInterface as Response;


$router = new Router;


$router->get('/', function (Request $request, Response $response) {
    return $response->html('hello, poggers');
});

$router->dispatch();
