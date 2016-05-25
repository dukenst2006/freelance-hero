<?php

use App\User;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegistrationTest extends TestCase
{
	use DatabaseTransactions;

    /** @test */
    public function see_user_name_when_logged_in()
    {
        $user = factory(App\User::class)->create();

        $this->actingAs($user)->visit('/')->see($user->first_name);
    }

    /** @test */
    public function can_complete_registration_form()
    {
	    $this->visit('/register')
	         ->type('Zack', 'first_name')
	         ->type('Mays', 'last_name')
	         ->type('zackmays@gmail.com', 'email')
	         ->type('gorham44', 'password')
	         ->type('gorham44', 'password_confirmation')
	         ->press('Register')
	         ->seePageIs('/');

		$this->seeInDatabase('users', ['email' => 'zackmays@gmail.com']);	    

		$user = User::where(['email' => 'zackmays@gmail.com'])->get()->first();

		$this->assertEquals('Zack', $user->first_name);
		$this->assertEquals('Mays', $user->last_name);
    }
}
