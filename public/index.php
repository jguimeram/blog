<?php

require('../bootstrap.php');
include('../src/app/helper/debug.php');

use Blog\src\app\Router;
use Blog\src\app\interfaces\RequestInterface as Request;
use Blog\src\app\interfaces\ResponseInterface as Response;


$router = new Router;

$router->get('/', function (Request $request, Response $response) {
    return  'from root' . PHP_EOL;
});

$router->get('/about', function (Request $request, Response $response) {
    //  return  'from about' . PHP_EOL;
});

$router->get('/users', function (Request $request, Response $response) {
    return  'from users' . PHP_EOL;
});

$router->get('/users/{id}', function (Request $request, Response $response) {
    $params = $request->getParams();
    debug($params);
    return $params['id'];
});



$router->dispatch();
