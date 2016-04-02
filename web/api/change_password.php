<?php
require('_bootstrap.inc.php');
Authentication::check();

Request::need_parameters('email', 'password');

$existing = false;

MailboxIterator::forMatchingMailbox(Request::$email, function ($mailbox) {
	global $existing;
	$existing = true;

	$password = Request::$data['password'];
	if (strlen($password) < Config::$config->password_minlength) {
		Response::$error = 'password_too_weak';
		Response::send();
	}
	$mailbox->password = $password;
	Config::save();
});

if (!$existing) {
	Response::$error = 'address_not_found';
}

Response::send();