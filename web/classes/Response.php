<?php

class Response
{
    public $status = 200;
    public $error;
    public $data;

    public function __construct($data = null)
    {
        $this->data = $data;
    }

    public function send()
    {
        if ($this->error != null) {
            $this->status = 500;
        }

        http_response_code($this->status);
        echo json_encode($this);
    }
}