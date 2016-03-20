<?php
require_once '../index.php';

$owner_email = $_GET['email'];
$password = $_GET['password'];
$response = new Response;

$email_found = false;

foreach (Config::$mailconfig->mailboxes as $mailbox) {
    $mailbox_email = $mailbox->local . '@' . $mailbox->domain;
    if ($mailbox_email == $owner_email) {
        $email_found = true;
        /**TODO: Implement password change
         * (It looks like we have to implement it in two ways:
         * - change cleartext password in ajenti config file
         * - change password in courier userdb file (see test_courier_auth.sh)
         **/
    }
}

if ($email_found === false) {
    $response->error = 'email_not_found';
}

Config::save();
$response->send();