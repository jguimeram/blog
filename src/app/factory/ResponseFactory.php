<?php

namespace Blog\src\app\factory;

use Blog\src\app\Response;
use Blog\src\app\factory\HttpFactory;

class ResponseFactory extends HttpFactory
{
    private static string $class = Response::class;
    private static ?Response $last = null;

    public static function fake(string $class): void
    {
        self::$class = $class;
    }

    public static function create(): Response
    {
        $class = self::$class;
        return self::$last = new $class;
    }

    /**
     * Returns the last created response instance.
     */
    public static function last(): ?Response
    {
        return self::$last;
    }
}
