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
        $target_key = array_search($target, $mailbox->targets);
        if ($target_key !== false) {
            Response::$data = $mailbox->targets[$target_key];
            unset($mailbox->targets[$target_key]);
            $existing = true;
            $mailbox->targets = array_values($mailbox->targets);
        } else {
            Response::$error = 'forwarding_address_not_found';
        }
    }
}

if ($existing) {
    Config::save();
} else {
    Response::$error = 'address_not_found';
}
Response::send();