<?php

ini_set('display_errors', true);

function __autoload($class_name)
{
    include dirname(__FILE__) . '/classes/' . $class_name . '.php';
}

Config::load();