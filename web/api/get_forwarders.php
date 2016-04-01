<?php
require('_bootstrap.inc.php');
Authentication::check();

Request::need_parameters('email');

$targets = array();

MailboxIterator::forMatchingForwarder(Request::$email, function ($mailbox) {
	global $targets;
	foreach ($mailbox->targets as $target) {
		array_push($targets, $target->email);
	}
	Response::$data = $targets;
});

if (Response::$data == null) {
	Response::$error = "address_not_found";
}

Response::send();