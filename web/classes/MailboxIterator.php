<?php

class MailboxIterator
{
	public static function forMatchingMailbox($email, $callback)
	{
		foreach (Config::$mailconfig->mailboxes as $mailbox) {
			$mailbox_email = $mailbox->local . '@' . $mailbox->domain;
			if ($mailbox_email == $email) {
				$callback($mailbox);
				break;
			}
		}
	}

	public static function forMatchingForwarder($email, $callback)
	{
		foreach (Config::$mailconfig->forwarding_mailboxes as $mailbox) {
			$mailbox_email = $mailbox->local . '@' . $mailbox->domain;
			if ($mailbox_email == $email) {
				$callback($mailbox);
				break;
			}
		}
	}
}