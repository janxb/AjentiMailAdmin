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
        $target_key = array_search($target, $mailbox->targets);
        if ($target_key !== false) {
            Response::$data = $mailbox->targets[$target_key];
            unset($mailbox->targets[$target_key]);
            $mailfound = true;

            $mailbox->targets = array_values($mailbox->targets);
        } else {
            Response::$error = 'forwarding_address_not_found';
        }
    }
}

if ($mailfound) {
    Config::save();
} else {
    Response::$error = 'address_not_found';
}
Response::send();