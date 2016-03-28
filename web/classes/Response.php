<?php

class Response
{
    public $status = 200;
    public $error;
    public $data;
    public $timestamp;

    public function __construct($data = null)
    {
        $this->data = $data;
    }

    public function send()
    {
        if ($this->error != null) {
            $this->status = 500;
        }

        $this->timestamp = time();
        http_response_code($this->status);
        echo json_encode($this);
    }
}