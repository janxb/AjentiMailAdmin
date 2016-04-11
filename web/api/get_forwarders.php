<?php
require('_bootstrap.inc.php');
Authentication::check();

Request::need_parameters('email');

$targets = array();

MailboxIterator::forMatchingForwarder(Request::$email, function ($mailbox) {
	global $targets;
	foreach ($mailbox->targets as $target) {
		if (!in_array($target->email, Config::$config->protected_forwarders)) {
			array_push($targets, $target->email);
		}
	}
	Response::$data = $targets;
	Response::send();
});

Response::$error = "address_not_found";
Response::send();
