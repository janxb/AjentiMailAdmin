<?php
    require('../index.php');
    $owner_email = $_GET['email'];

    $targets = array();
    $response = new Response();

    foreach (Config::$mailconfig->forwarding_mailboxes as $mailbox){
        $mailbox_email = $mailbox->local . '@' . $mailbox->domain;
        if ($mailbox_email == $owner_email){
            foreach ($mailbox->targets as $target) {
                array_push($targets, $target->email);
            }
        }
    }

    if (empty($targets)){
        $response->error = "address_not_found";
    } else {
        $response->data = $targets;
    }

    $response->send();
?>