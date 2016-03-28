<?php

require('../index.php');
$owner_email = $_GET['email'];
$target = new stdClass;
$target->email = $_GET['target'];

if (!isset($owner_email, $target->email)) {
    die("missing_parameters");
}

$response = new Response();
$mailfound = false;

foreach (Config::$mailconfig->forwarding_mailboxes as $mailbox) {
    $mailbox_email = $mailbox->local . '@' . $mailbox->domain;
    if ($mailbox_email == $owner_email) {
        $target_key = array_search($target, $mailbox->targets);
        if ($target_key !== false) {
            $response->data = $mailbox->targets[$target_key];
            unset($mailbox->targets[$target_key]);
            $mailfound = true;

            $mailbox->targets = array_values($mailbox->targets);
        } else {
            $response->error = 'forwarding_address_not_found';
        }
    }
}

if ($mailfound) {
    Config::save();
} else {
    $response->error = 'address_not_found';
}
$response->send();