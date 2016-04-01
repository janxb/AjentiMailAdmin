<?php

class Request
{
	public static $email;
	public static $auth;

	public static $data;

	public static function need_parameters(...$parameters)
	{
		foreach ($parameters as $parameter){
			if (!isset(self::$data[$parameter])){
				Response::$error = 'missing_parameters';
				Response::send();
			}
		}
	}
}