<?php

class ForwardingMail extends Mail
{
	const TARGET_PLACEHOLDER = '{{target}}';
	const SOURCE_PLACEHOLDER = '{{source}}';

	public $sourceMailbox;

	public function send()
	{
		MailboxIterator::forMatchingMailbox($this->sourceMailbox, function ($mailbox) {
			$this->content = str_replace(ForwardingMail::TARGET_PLACEHOLDER, $this->to, $this->content);
			$this->content = str_replace(ForwardingMail::SOURCE_PLACEHOLDER, $this->sourceMailbox, $this->content);
			$this->subject = str_replace(ForwardingMail::TARGET_PLACEHOLDER, $this->to, $this->subject);
			$this->subject = str_replace(ForwardingMail::SOURCE_PLACEHOLDER, $this->sourceMailbox, $this->subject);
		});

		return parent::send();
	}

	protected function validate()
	{
		parent::validate();

		if (!isset($this->sourceMailbox)) {
			throw new RuntimeException('Source Mailbox must be set!');
		}
	}
}