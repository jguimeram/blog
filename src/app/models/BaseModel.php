<?php

namespace Blog\src\app\models;

use Blog\src\app\Database;
use PDO;

abstract class BaseModel
{
    protected static string $table;
    protected static string $primaryKey = 'id';

    protected array $attributes = [];

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    public function __get(string $key)
    {
        return $this->attributes[$key] ?? null;
    }

    public function __set(string $key, $value): void
    {
        $this->attributes[$key] = $value;
    }

    public function fill(array $attributes): void
    {
        foreach ($attributes as $key => $value) {
            $this->attributes[$key] = $value;
        }
    }

    public static function find(int $id): ?static
    {
        $pdo = Database::connect();
        $table = static::$table;
        $pk = static::$primaryKey;
        $stmt = $pdo->prepare("SELECT * FROM {$table} WHERE {$pk} = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new static($data) : null;
    }

    public function save(): bool
    {
        $pdo = Database::connect();
        $table = static::$table;
        $pk = static::$primaryKey;

        if (isset($this->attributes[$pk])) {
            $columns = array_keys($this->attributes);
            $columns = array_filter($columns, fn($c) => $c !== $pk);
            $sets = implode(', ', array_map(fn($c) => "$c = :$c", $columns));
            $sql = "UPDATE {$table} SET {$sets} WHERE {$pk} = :{$pk}";
        } else {
            $columns = array_keys($this->attributes);
            $params = implode(', ', array_map(fn($c) => ":$c", $columns));
            $cols = implode(', ', $columns);
            $sql = "INSERT INTO {$table} ({$cols}) VALUES ({$params})";
        }

        $stmt = $pdo->prepare($sql);
        $success = $stmt->execute($this->attributes);

        if ($success && !isset($this->attributes[$pk])) {
            $this->attributes[$pk] = (int)$pdo->lastInsertId();
        }
        return $success;
    }

    public function delete(): bool
    {
        $pdo = Database::connect();
        $table = static::$table;
        $pk = static::$primaryKey;

        if (!isset($this->attributes[$pk])) {
            return false;
        }

        $stmt = $pdo->prepare("DELETE FROM {$table} WHERE {$pk} = :id");
        return $stmt->execute(['id' => $this->attributes[$pk]]);
    }
}
