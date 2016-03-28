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
        if (!in_array($target, $mailbox->targets)) {
            array_push($mailbox->targets, $target);
            $mailfound = true;
        } else {
            $response->error = 'duplicated_forwarding_address';
        }
    }
}

if ($mailfound) {
    Config::save();
} else {
    $response->error = 'address_not_found';
}
$response->send();