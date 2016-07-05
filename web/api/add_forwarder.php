<?php
require('_bootstrap.inc.php');
Authentication::check();

Request::need_parameters('email', 'forward');

$target = new stdClass;
$target->email = Request::$data['forward'];

$existing = false;

MailboxIterator::forMatchingForwarder(Request::$email, function ($mailbox) {
	global $target, $existing;
	if (in_array($target->email, Config::$config->protected_forwarders)) {
		Response::$error = 'forwarding_address_protected';
		Response::send();
	}

	$existing = true;
	if (!in_array($target, $mailbox->targets)) {
		array_push($mailbox->targets, $target);
	} else {
		Response::$error = 'duplicated_forwarding_address';
	}
	Config::save();

	if (Config::$config->notify_added_forwarders === true) {
		$mail = new ForwardingMail();
		$mail->to = $target->email;
		$mail->from = Config::$config->accountmails_from;
		$mail->sourceMailbox = Request::$email;
		$mail->subject = Config::$config->forwarder_notification_subject;
		$mail->content = Config::$config->forwarder_notification_content;
		if (Config::$config->accountmails_bcc !== null) {
			$mail->bcc = Config::$config->accountmails_bcc;
		}
		$mail->send();
	}
});

if (!$existing) {
	Response::$error = 'address_not_found';
}
Response::send();