<?php

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegistrationTest extends TestCase
{
    use DatabaseTransactions;
    use MailTracking;

    /** @test */
    public function can_complete_registration_form()
    {
	    $this->visit('/register')
	         ->type('Zack', 'first_name')
	         ->type('Mays', 'last_name')
	         ->type('test@test.com', 'email')
	         ->type('testing', 'password')
	         ->type('testing', 'password_confirmation')
	         ->press('Register')
	         ->seePageIs('/home');

		$this->seeInDatabase('users', ['email' => 'test@test.com', 'first_name' => 'Zack', 'last_name' => 'Mays']);
    }
    /** @test */
    public function a_user_cannot_register_without_a_first_name()
    {
        $this->visit('/register')
             ->type('', 'first_name')
             ->type('Mays', 'last_name')
             ->type('test@test.com', 'email')
             ->type('testing', 'password')
             ->type('testing', 'password_confirmation')
             ->press('Register')
             ->see('The first name field is required.')
             ->seePageIs('/register');
    }

    /** @test */
    public function a_user_cannot_register_without_a_last_name()
    {
        $this->visit('/register')
             ->type('Zack', 'first_name')
             ->type('', 'last_name')
             ->type('test@test.com', 'email')
             ->type('testing', 'password')
             ->type('testing', 'password_confirmation')
             ->press('Register')
             ->see('The last name field is required.')
             ->seePageIs('/register');
    }

    /** @test */
    public function a_user_cannot_register_without_an_email()
    {
        $this->visit('/register')
             ->type('Zack', 'first_name')
             ->type('Mays', 'last_name')
             ->type('', 'email')
             ->type('testing', 'password')
             ->type('testing', 'password_confirmation')
             ->press('Register')
             ->see('The email field is required.')
             ->seePageIs('/register');
    }

    /** @test */
    public function a_user_cannot_register_without_a_password()
    {
        $this->visit('/register')
             ->type('Zack', 'first_name')
             ->type('Mays', 'last_name')
             ->type('test@test.com', 'email')
             ->type('', 'password')
             ->type('testing', 'password_confirmation')
             ->press('Register')
             ->see('The password field is required.')
             ->seePageIs('/register');
    }

    /** @test */
    public function a_user_cannot_register_wihout_the_confirmation_password_matching()
    {
        $this->visit('/register')
             ->type('Zack', 'first_name')
             ->type('Mays', 'last_name')
             ->type('test@test.com', 'email')
             ->type('testing', 'password')
             ->type('asdf', 'password_confirmation')
             ->press('Register')
             ->see('The password confirmation does not match.')
             ->seePageIs('/register');
    }
}
