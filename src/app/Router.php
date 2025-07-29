<?php

namespace Blog\src\app;

use Blog\src\app\interfaces\ResponseInterface as Response;
use Blog\src\app\interfaces\RequestInterface as Request;
use Blog\src\app\factory\ResponseFactory;
use Blog\src\app\factory\RequestFactory;

class Router
{

    private array $routes = [];
    private object $request;
    private object $response;
    private string $method;
    private string $path = "";

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
        $this->path = $path;
        $this->routes[$method][$this->path] = $handler;
    }

    private function executeHandler(callable $handler, Request $request, Response $response)
    {
        try {
            //code...
            $result = call_user_func($handler, $request, $response);
            if ($result instanceof Response) {
                $result->send();
            } elseif (is_string($result)) {
                $response->text($result)->send();
            } else if (is_array($result)) {
                $response->json($result)->send();
            } else if ($result === null) {
                $response->setCode(204)->send(); // No Content
            } else {
                throw new \Exception('Invalid response type');
            }
        } catch (\Throwable $th) {
            //throw $th;
            $response->setCode(500)->setMessage("Internal Server Error")->send(); //500;
        }
    }

    public function dispatch()
    {
        $this->request = RequestFactory::create();

        $this->response = ResponseFactory::create();
        $this->method = $this->request->getMethod();
        $url = $this->request->getPath(); //client path


        foreach ($this->routes[$this->method] ?? [] as $route => $callback) {

            //rewrite {id} to a regex
            $pattern = '#^' . preg_replace('/\{(\w+)\}/', '(?P<$1>\d+)', $route) . '$#';

            //match the regex and returns an array of matches
            if (preg_match_all($pattern, $url, $matches)) {
                $handler = $this->routes[$this->method][$this->path];
                $this->executeHandler($handler, $this->request, $this->response);
                return;
            } else {
                $this->response->setCode(404)->setMessage("Not found")->send();
            }
        }


        ############

        /*         if (isset($this->routes[$method][$path])) {

            foreach ($this->routes[$method] ?? [] as $url => $callback) {

                $pattern = '#^' . preg_replace('/\{(\w+)\}/', '(?P<$1>\d+)', $url) . '$#';
                if (preg_match_all($pattern, $path, $matches)) {
                    print_r($matches);
                    $handler = $this->routes[$method][$path];
                    $this->executeHandler($handler, $request, $response);
                    return; //prevent bottleneck checking routes;
                }
            }
        } else {
            $response->setCode(404)->setMessage("Not found")->send();
        } */

        ########################





    }
}
