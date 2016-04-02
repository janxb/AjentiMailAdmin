<?php

class PasswordMail extends Mail
{
	const PASSWORD_PLACEHOLDER = '{{password}}';
	const EMAIL_PLACEHOLDER = '{{email}}';

	public function send()
	{
		MailboxIterator::forMatchingMailbox($this->to, function ($mailbox) {
			$this->content = str_replace(PasswordMail::PASSWORD_PLACEHOLDER, $mailbox->password, $this->content);
			$this->content = str_replace(PasswordMail::EMAIL_PLACEHOLDER, $this->to, $this->content);
		});

		return parent::send();
	}
}