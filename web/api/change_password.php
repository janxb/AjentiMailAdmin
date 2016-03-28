<?php
require_once '../index.php';

$owner_email = $_GET['email'];
$password = $_GET['password'];
$response = new Response;

if (!isset($owner_email, $password)){
    die("missing_parameters");
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
    $response->error = 'address_not_found';
}

$response->send();