<?php

class Authentication
{

    public static function check(){

		Request::need_parameters('email', 'auth');

        $user = Request::$email;
        $password = Request::$auth;

        $authenticated = false;
        foreach (Config::$mailconfig->mailboxes as $mailbox) {
            $mailbox_email = $mailbox->local . '@' . $mailbox->domain;
            if ($mailbox_email == $user) {
                $authenticated = ($mailbox->password === $password);
            }
        }

        if (!$authenticated){
            Response::$error = 'login_failed';
            Response::send();
        }
    }
}