<?php

require('_bootstrap.inc.php');
$owner_email = $_REQUEST['email'];

if (!isset($owner_email)) {
    Response::$error = 'missing_parameters';
    Response::send();
}

$mailfound = false;

foreach (Config::$mailconfig->mailboxes as $mailbox) {
    $mailbox_email = $mailbox->local . '@' . $mailbox->domain;
    if ($mailbox_email == $owner_email) {
		$mailfound = true;
    }
}

if (!$mailfound) {
    Response::$error = "address_not_found";
}

Response::send();