<?php
require('_bootstrap.inc.php');
Authentication::check();

Request::need_parameters('email');

$existing = false;

MailboxIterator::forMatchingMailbox(Request::$email, function($mailbox){
	global $existing;
	$existing = true;
});

if (!$existing) {
    Response::$error = "address_not_found";
}

Response::send();