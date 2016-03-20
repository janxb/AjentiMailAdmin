<?php

require('../index.php');
$owner_email = $_GET['email'];
$target = new stdClass;
$target->email = $_GET['target'];

$response = new Response();

foreach (Config::$mailconfig->forwarding_mailboxes as $mailbox){
    $mailbox_email = $mailbox->local . '@' . $mailbox->domain;
    if ($mailbox_email == $owner_email){
        if ($key = array_search($target, $mailbox->targets) !== false) {
            unset($mailbox->targets[$key]);
            $mailbox->targets = array_values($mailbox->targets);
        } else {
            $response->error = 'forwarding_address_not_found';
        }
    }
}

Config::save();
$response->send();