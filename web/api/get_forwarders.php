<?php

require('_bootstrap.inc.php');
$owner_email = $_REQUEST['email'];

$targets = array();

if (!isset($owner_email)) {
    Response::$error = 'missing_parameters';
    Response::send();
}

$mailfound = false;

foreach (Config::$mailconfig->forwarding_mailboxes as $mailbox) {
    $mailbox_email = $mailbox->local . '@' . $mailbox->domain;
    if ($mailbox_email == $owner_email) {
		$mailfound = true;
        foreach ($mailbox->targets as $target) {
            array_push($targets, $target->email);
        }
    }
}

if (!$mailfound) {
    Response::$error = "address_not_found";
} else {
    Response::$data = $targets;
}

Response::send();