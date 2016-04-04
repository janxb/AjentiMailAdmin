<?php
require('_bootstrap.inc.php');

Request::need_parameters('email');

$mailboxExisting = false;
$forwarderExisting = false;
$passwordMailPostmasterEnabled = Config::$config->forgotpassword_admin_feature_enabled;

$mailDomain = '';

MailboxIterator::forMatchingMailbox(Request::$email, function ($mailbox) {
	global $mailboxExisting, $mailDomain;
	$mailboxExisting = true;
	$mailDomain = $mailbox->domain;
	MailboxIterator::forMatchingForwarder(Request::$email, function ($forwarder) {
		global $forwarderExisting;
		$forwarderExisting = true;
	});
});

if (!$mailboxExisting) {
	Response::$error = 'address_not_found';
	Response::send();
} else if (!$forwarderExisting && !$passwordMailPostmasterEnabled) {
	Response::$error = 'forwarding_not_enabled';
	Response::send();
};

$mail = new PasswordMail();
$mail->affectedEmail = Request::$email;
$mail->from = Config::$config->accountmails_from;
$mail->subject = Config::$config->passwordmail_subject;
$mail->content = Config::$config->passwordmail_content;
if (Config::$config->accountmails_bcc !== null) {
	$mail->bcc = Config::$config->accountmails_bcc;
}
if ($forwarderExisting) {
	$mail->to = Request::$email;
	Response::$data = 'mail_sent_to_forwarders';
} else {
	$mail->to = Config::$config->accountmails_from;
	Response::$data = 'mail_sent_to_postmaster';
}

$success = $mail->send();

if (!$success) {
	Response::$error = 'mailing_failed';
}

Response::send();