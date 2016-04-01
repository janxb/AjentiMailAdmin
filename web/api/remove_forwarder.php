<?php
require('_bootstrap.inc.php');
Authentication::check();

Request::need_parameters('email', 'forward');

$target = new stdClass;
$target->email = Request::$data['forward'];

$existing = false;

MailboxIterator::forMatchingForwarder(Request::$email, function ($mailbox) {
	global $target, $existing;
	$target_key = array_search($target, $mailbox->targets);
	if ($target_key !== false) {
		Response::$data = $mailbox->targets[$target_key];
		unset($mailbox->targets[$target_key]);
		$existing = true;
		$mailbox->targets = array_values($mailbox->targets);
	} else {
		Response::$error = 'forwarding_address_not_found';
	}

	Config::save();
});

if (!$existing) {
	Response::$error = 'address_not_found';
}
Response::send();