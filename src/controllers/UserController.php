<?php

namespace Blog\src\controllers;

class UserController
{
    private int $id;

    public function index(): string
    {
        return "here it is a new user\n";
    }

    public function find(int $id): string
    {
        $this->id = 5;
        return ($this->id === $id) ? "exists" : "not exists";
    }
}
