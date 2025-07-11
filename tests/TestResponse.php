<?php

use Blog\src\app\Response;

class TestResponse extends Response
{
    public function send()
    {
        // do nothing; properties will be inspected directly
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
