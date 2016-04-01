<?php
require('_bootstrap.inc.php');
Authentication::check();

Request::need_parameters('email', 'password');

$existing = false;

MailboxIterator::forMatchingMailbox(Request::$email, function ($mailbox) {
	global $existing;
	$existing = true;
	$mailbox->password = Request::$data['password'];
	Config::save();
});

if (!$existing) {
	Response::$error = 'address_not_found';
}

Response::send();