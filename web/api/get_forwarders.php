<?php
require('_bootstrap.inc.php');
Authentication::check();

Request::need_parameters('email');

$targets = array();

$existing = false;

foreach (Config::$mailconfig->forwarding_mailboxes as $mailbox) {
    $mailbox_email = $mailbox->local . '@' . $mailbox->domain;
    if ($mailbox_email == Request::$email) {
		$existing = true;
        foreach ($mailbox->targets as $target) {
            array_push($targets, $target->email);
        }
    }
}

if (!$existing) {
    Response::$error = "address_not_found";
} else {
    Response::$data = $targets;
}

Response::send();