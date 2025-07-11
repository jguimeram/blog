<?php

namespace Blog\src\app;

use Blog\src\app\interfaces\ResponseInterface as Response;
use Blog\src\app\interfaces\RequestInterface as Request;
use Blog\src\app\factory\ResponseFactory;
use Blog\src\app\factory\RequestFactory;

class Router
{

    private array $routes = [];

    public function get(string $path, callable $handler)
    {
        $this->addRoute('GET', $path, $handler);
    }
    public function post(string $path, callable $handler)
    {
        $this->addRoute('POST', $path, $handler);
    }
    public function put(string $path, callable $handler)
    {
        $this->addRoute('PUT', $path, $handler);
    }
    public function patch(string $path, callable $handler)
    {
        $this->addRoute('PATCH', $path, $handler);
    }
    public function delete(string $path, callable $handler)
    {
        $this->addRoute('DELETE', $path, $handler);
    }

    private function addRoute(string $method, string $path, callable $handler)
    {
        $this->routes[$method][$path] = $handler;
    }

    private function executeHandler(callable $handler, Request $request, Response $response)
    {
        try {
            //code...
            $result = call_user_func($handler, $request, $response);
            if ($result instanceof Response) $result->send();
        } catch (\Throwable $th) {
            //throw $th;
            $response->setCode(500)->setMessage("Internal Server Error")->send(); //500;
        }
    }

    public function dispatch()
    {
        $request = RequestFactory::create();

        $response = ResponseFactory::create();


        if (isset($this->routes[$request->getMethod()][$request->getPath()])) {
            $handler = $this->routes[$request->getMethod()][$request->getPath()];
            $this->executeHandler($handler, $request, $response);
            return; //prevent bottleneck checking routes;
        } else {
            $response->setCode(404)->setMessage("Not found")->send(); 
        }
    }
}
