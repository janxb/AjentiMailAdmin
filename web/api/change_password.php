<?php
require_once '../config.php';

$owner_email = $_REQUEST['email'];
$password = $_REQUEST['password'];

if (!isset($owner_email, $password)) {
    Response::$error = 'missing_parameters';
    Response::send();
}

$mailfound = false;

foreach (Config::$mailconfig->mailboxes as $mailbox) {
    $mailbox_email = $mailbox->local . '@' . $mailbox->domain;
    if ($mailbox_email == $owner_email) {
        $mailfound = true;
        $mailbox->password = $password;
    }
}

if ($mailfound){
    Config::save();
} else {
    Response::$error = 'address_not_found';
}

Response::send();