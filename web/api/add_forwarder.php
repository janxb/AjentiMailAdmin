<?php
    require('../index.php');
    $owner_email = $_GET['email'];
    $target = new stdClass;
    $target->email = $_GET['target'];

    $response = new Response();

    foreach (Config::$mailconfig->forwarding_mailboxes as $mailbox){
        $mailbox_email = $mailbox->local . '@' . $mailbox->domain;
        if ($mailbox_email == $owner_email){
            if (!in_array($target, $mailbox->targets)) {
                array_push($mailbox->targets, $target);
            } else {
                $response->error = 'duplicated_forwarding_address';
            }
        }
    }

    Config::save();
    $response->send();
?>