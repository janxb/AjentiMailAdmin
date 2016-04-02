<?php

ini_set('display_errors', false);
set_include_path(dirname(__FILE__) . '/../classes');

function __autoload($class_name)
{
	$file = dirname(__FILE__) . '/../classes/' . $class_name . '.php';

	if (file_exists($file)) {
		require_once $file;
	}
}

Config::$basepath = dirname(__FILE__) . '/../../';
Config::load();

Request::$auth = isset($_REQUEST['auth']) ? $_REQUEST['auth'] : null;
Request::$email = isset($_REQUEST['email']) ? $_REQUEST['email'] : null;
Request::$data = $_REQUEST;

unset($_REQUEST, $_GET, $_POST);
