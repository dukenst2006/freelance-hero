<?php

trait MailTracking
{
    protected $emails = [];

    /** @before */
    public function setUpMailTracking()
    {
        Mail::getSwiftMailer()->registerPlugin(new TestingMailEventListener($this));
    }

    protected function seeEmailWasSent()
    {
        $this->assertNotEmpty($this->emails, 'No emails have been sent.');

        return $this;
    }

    protected function seeEmailsSent($count)
    {
    	$emailsSent = count($this->emails);

    	$this->assertCount($count, $this->emails, "Expected $count emails, but found $emailsSent.");

    	return $this;
    }

    protected function seeEmailTo($recipient, Swift_Message $message = null)
    {
    	$email = $message ?: end($this->emails);
    	$this->assertArrayHasKey($recipient, $this->getEmail($message)->getTo());
    }

    protected function seeEmailFrom($sender, Swift_Message $message = null)
    {
    	$email = $message ?: end($this->emails);
    	$this->assertArrayHasKey($sender, $this->getEmail($message)->getFrom());
    }

    public function addEmail(Swift_Message $email)
    {
        $this->emails[] = $email;
    }

    protected function getEmail(Swift_Message $message = null)
    {
    	$this->seeEmailWasSent();
    	return $message ?: $this->lastEmail();
    }

    protected function lastEmail()
    {
    	return end($this->emails);
    }
}

class TestingMailEventListener implements Swift_Events_EventListener
{
    protected $test;

    public function __construct($test)
    {
        $this->test = $test;
    }

    public function beforeSendPerformed($event)
    {
        $message = $event->getMessage();

        $this->test->addEmail($event->getMessage());
    }
}
