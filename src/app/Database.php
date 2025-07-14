<?php

namespace Blog\src\app;

use PDO;
use PDOException;
use Dotenv\Dotenv;

class Database
{
    private static ?PDO $connection = null;

    /**
     * Returns a PDO connection using environment configuration.
     */
    public static function connect(): PDO
    {
        if (self::$connection === null) {
            // Load environment variables if a .env file exists
            $root = dirname(__DIR__, 2);
            if (file_exists("$root/.env")) {
                Dotenv::createImmutable($root)->load();
            }

            $dsn = $_ENV['DB_DSN'] ?? 'sqlite::memory:';
            $user = $_ENV['DB_USER'] ?? null;
            $pass = $_ENV['DB_PASS'] ?? null;

            self::$connection = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }

        return self::$connection;
    }
}
