<?php

class Authentication
{

	public static function check()
	{

		Request::need_parameters('email', 'auth');

		$user = Request::$email;
		$remote_password_hash = Request::$auth;

		$authenticated = false;
		foreach (Config::$mailconfig->mailboxes as $mailbox) {
			$mailbox_email = $mailbox->local . '@' . $mailbox->domain;
			if ($mailbox_email == $user) {
				$local_password_hash = md5($mailbox->password);
				$authenticated = ($local_password_hash === $remote_password_hash);
			}
		}

		if (!$authenticated) {
			Response::$error = 'login_failed';
			Response::send();
		}
	}
}