<?php

class PasswordMail extends Mail
{
	const PASSWORD_PLACEHOLDER = '{{password}}';
	const EMAIL_PLACEHOLDER = '{{email}}';

	public $affectedEmail;

	public function send()
	{
		MailboxIterator::forMatchingMailbox($this->affectedEmail, function ($mailbox) {
			$this->content = str_replace(PasswordMail::PASSWORD_PLACEHOLDER, $mailbox->password, $this->content);
			$this->content = str_replace(PasswordMail::EMAIL_PLACEHOLDER, $this->affectedEmail, $this->content);
		});

		return parent::send();
	}

	public function validate()
	{
		parent::validate();

		if (!isset($this->affectedEmail) && !filter_var($this->affectedEmail, FILTER_VALIDATE_EMAIL)) {
			throw new RuntimeException('Bad affectedEmail Parameter');
		}
	}
}