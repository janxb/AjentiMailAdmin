<?php
require('_bootstrap.inc.php');

Request::need_parameters('email');

$mailboxExisting = false;
$forwarderExisting = false;

$mailDomain = '';

MailboxIterator::forMatchingMailbox(Request::$email, function ($mailbox) {
	global $mailboxExisting, $mailDomain;
	$mailboxExisting = true;
	$mailDomain = $mailbox->domain;
	MailboxIterator::forMatchingForwarder(Request::$email, function ($forwarder) {
		global $forwarderExisting, $mailDomain;
		$forwarderExisting = true;
	});
});

if (!$mailboxExisting) {
	Response::$error = 'address_not_found';
	Response::send();
} else if (!$forwarderExisting) {
	Response::$error = 'forwarding_not_enabled';
	Response::send();
}

$mail = new PasswordMail();
$mail->to = Request::$email;
$mail->from = Config::$config->passwordmail_from;
$mail->subject = Config::$config->passwordmail_subject;
$mail->content = Config::$config->passwordmail_content;
if (Config::$config->passwordmail_bcc !== null) {
	$mail->bcc = Config::$config->passwordmail_bcc;
}

$success = $mail->send();

if (!$success) {
	Response::$error = 'mailing_failed';
}

Response::send();