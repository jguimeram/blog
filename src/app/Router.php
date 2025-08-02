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

        // Store the original path pattern to match against later
        /*  $this->routes[$method][$path] = [
            'pattern' => $path,
            'handler' => $handler
        ]; */
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
        $url = $this->request->getPath();

        // Check if we have any routes for this method

        foreach ($this->routes[$this->method] ?? [] as $route => $callback) {
            $pattern = '#^' . preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $route) . '$#';
            if (preg_match($pattern, $url, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $this->request->setParams($params);
                $this->executeHandler($callback, $this->request, $this->response);
                return;
            }
        }
        $this->response->setCode(404)->setMessage('Not Found')->send();
    }
}
