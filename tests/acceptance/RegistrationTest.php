<?php

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegistrationTest extends TestCase
{
	use DatabaseTransactions;

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
	         ->seePageIs('/');

		$this->seeInDatabase('users', ['email' => 'test@test.com', 'first_name' => 'Zack', 'last_name' => 'Mays']);
    }
}
