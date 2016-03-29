<?php

class Response implements JsonSerializable
{
    public static $status = 200;
    public static $error;
    public static $data;
    public static $timestamp;

    public function jsonSerialize()
    {
        return get_class_vars(get_class($this));
    }

    public static function send()
    {
        if (self::$error != null) {
            self::$status = 200;
        }

        self::$timestamp = time();
        http_response_code(self::$status);
        echo json_encode(new Response());
        exit();
    }
}