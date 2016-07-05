<?php
require('_bootstrap.inc.php');
Authentication::check();

Request::need_parameters('email');

$existing = false;

MailboxIterator::forMatchingMailbox(Request::$email, function($mailbox){
	global $existing;
	$existing = true;
	Response::$data['fail2ban_enabled'] = Config::$config->fail2ban_enabled;
});

if (!$existing) {
    Response::$error = "address_not_found";
}

Response::send();