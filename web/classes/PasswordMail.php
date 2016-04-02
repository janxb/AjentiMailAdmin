<?php

class PasswordMail
{
	const PASSWORD_PLACEHOLDER = '{{password}}';
	const EMAIL_PLACEHOLDER = '{{email}}';
	public $from;
	public $to;
	public $bcc;
	public $subject;
	public $content;

	private $isSent = false;

	public function send()
	{
		$this->validate();

		MailboxIterator::forMatchingMailbox($this->to, function ($mailbox) {
			$this->content = str_replace(PasswordMail::PASSWORD_PLACEHOLDER, $mailbox->password, $this->content);
			$this->content = str_replace(PasswordMail::EMAIL_PLACEHOLDER, $this->to, $this->content);
		});

		$success = mail($this->to,
			$this->subject,
			$this->content,
			$this->createHeaders());

		$this->isSent = true;
		return $success;
	}

	private function createHeaders()
	{
		$headers = '';
		$headers .= 'From: ' . $this->from . "\r\n";
		$headers .= 'Reply-To: ' . $this->from . "\r\n";
		$headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";

		if (isset($this->bcc)) {
			$headers .= 'Bcc: ' . $this->bcc . "\r\n";
		}

		return $headers;
	}

	private function validate()
	{
		if ($this->isSent) {
			throw new RuntimeException('Password Mail can only be sent once!');
		}

		if (!isset(
			$this->from,
			$this->to,
			$this->subject,
			$this->content)
			//Note: BCC is optional
		) {
			throw new RuntimeException('Missing Parameters');
		}
		if (isset($this->to) && !filter_var($this->to, FILTER_VALIDATE_EMAIL) ||
			isset($this->bcc) && !filter_var($this->bcc, FILTER_VALIDATE_EMAIL)
		) {
			throw new RuntimeException('Bad Email Parameters');
		}

		if (strpos($this->content, self::PASSWORD_PLACEHOLDER) === false) {
			throw new RuntimeException('No Password contained in Mail Content');
		}
	}
}