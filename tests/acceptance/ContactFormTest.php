<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ContactFormTest extends TestCase
{
    use DatabaseTransactions;
    use MailTracking;

    /** @test */
    public function a_user_can_send_a_contact_email()
    {
	    $this->visit('/')
	         ->type('Zack Mays', 'fullName')
	         ->type('test@test.com', 'email')
	         ->type('This is an interesting site.', 'comments')
	         ->press('Submit')
	         ->seePageIs('/contact')
             ->see('Thank you for contacting us!')
             ->seeEmailWasSent()
             ->seeEmailTo('info@freelance-hero.com')
             ->seeEmailSubjectLine('Contact Form Completed')
             ->seeEmailContains('Zack Mays filled out the contact form. Here\'s what he said: This is an interesting site.');
    }

    /** @test */
    public function a_user_cannot_submit_a_contact_form_without_an_email()
    {
        $this->visit('/')
             ->type('Zack Mays', 'fullName')
             ->type('', 'email')
             ->type('This is an interesting site.', 'comments')
             ->press('Submit')
             ->seePageIs('/')
             ->seeEmailWasNotSent();
    }
}
