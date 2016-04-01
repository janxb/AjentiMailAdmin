<?php
require('_bootstrap.inc.php');
Authentication::check();

Request::need_parameters('email');

$existing = false;

foreach (Config::$mailconfig->mailboxes as $mailbox) {
    $mailbox_email = $mailbox->local . '@' . $mailbox->domain;
    if ($mailbox_email == Request::$email) {
		$existing = true;
    }
}

if (!$existing) {
    Response::$error = "address_not_found";
}

Response::send();