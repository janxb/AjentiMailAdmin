<?php
require('_bootstrap.inc.php');
Authentication::check();

Request::need_parameters('email', 'forward');

$target = new stdClass;
$target->email = Request::$data['forward'];

$existing = false;

foreach (Config::$mailconfig->forwarding_mailboxes as $mailbox) {
    $mailbox_email = $mailbox->local . '@' . $mailbox->domain;
    if ($mailbox_email == Request::$email) {
        $existing = true;
        if (!in_array($target, $mailbox->targets)) {
            array_push($mailbox->targets, $target);
        } else {
            Response::$error = 'duplicated_forwarding_address';
        }
    }
}

if ($existing) {
    Config::save();
} else {
    Response::$error = 'address_not_found';
}
Response::send();