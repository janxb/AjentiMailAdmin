<?php

class Config
{
    public static $config;
    public static $mailconfig;

    public static function load()
    {
        if (Config::$config == null) {
            Config::$config = json_decode(file_get_contents(dirname(__FILE__) . '/../config.json'));
            Config::$config->mailconfig = dirname(__FILE__) . '/../' . Config::$config->mailconfig;
            Config::$mailconfig = json_decode(file_get_contents(Config::$config->mailconfig));
        }
    }

    public static function save()
    {
        file_put_contents(Config::$config->mailconfig,
            JsonFormatter::format(json_encode(Config::$mailconfig, JSON_UNESCAPED_SLASHES)));
    }
}