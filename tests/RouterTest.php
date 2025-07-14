<?php

use Blog\src\app\Router;
use Blog\src\app\factory\ResponseFactory;
use PHPUnit\Framework\TestCase;

require_once __DIR__.'/TestResponse.php';

class RouterTest extends TestCase
{
    protected function setUp(): void
    {
        ResponseFactory::fake(TestResponse::class);
    }

    protected function tearDown(): void
    {
        ResponseFactory::fake(\Blog\src\app\Response::class);
    }

    public function testDispatchExecutesHandler()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/hello';

        $router = new Router();
        $router->get('/hello', function ($req, $res) {
            return $res->setCode(201)->setMessage('world');
        });

        $router->dispatch();
        $response = ResponseFactory::last();

        $this->assertSame(201, $response->getCode());
        $this->assertSame('world', $response->getMessage());
    }

    public function testDispatchNotFound()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/missing';

        $router = new Router();
        // no routes registered for /missing

        $router->dispatch();
        $response = ResponseFactory::last();

        $this->assertSame(404, $response->getCode());
        $this->assertSame('Not found', $response->getMessage());
    }
}
