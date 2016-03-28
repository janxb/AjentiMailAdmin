<?php

ini_set('display_errors', true);
set_include_path(dirname(__FILE__) . '/classes');

function __autoload($class_name)
{
    $file = dirname(__FILE__) . '/classes/' . $class_name . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
}

Config::load();