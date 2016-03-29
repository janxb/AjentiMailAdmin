<?php

require('../config.php');
$owner_email = $_REQUEST['email'];
$target = new stdClass;
$target->email = $_REQUEST['forward'];

$mailfound = false;

if (!isset($owner_email, $target->email)) {
    Response::$error = 'missing_parameters';
    Response::send();
}

foreach (Config::$mailconfig->forwarding_mailboxes as $mailbox) {
    $mailbox_email = $mailbox->local . '@' . $mailbox->domain;
    if ($mailbox_email == $owner_email) {
        $mailfound = true;
        if (!in_array($target, $mailbox->targets)) {
            array_push($mailbox->targets, $target);
        } else {
            Response::$error = 'duplicated_forwarding_address';
        }
    }
}

if ($mailfound) {
    Config::save();
} else {
    Response::$error = 'address_not_found';
}
Response::send();