<?php

abstract class Mail
{
	public $from;
	public $to;
	public $bcc;
	public $subject;
	public $content;

	protected $isSent = false;

	public function send()
	{
		$this->validate();

		$success = mail($this->to,
			$this->subject,
			$this->content,
			$this->createHeaders());

		$this->isSent = true;
		return $success;
	}

	protected function createHeaders()
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

	protected function validate()
	{
		if ($this->isSent) {
			throw new RuntimeException('Mail can only be sent once!');
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
	}
}