<?php

use App\User;
use App\Project;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ValidationTest extends TestCase
{
	use DatabaseTransactions;

    /** @test */
    public function a_work_session_must_have_a_proejct()
    {
    	$user = factory(User::class)->create();
    	$project1 = factory(Project::class)->create();

    	$this->actingAs($user)
    		 ->visit('/start_session')
    		 ->press('Start Session')
    		 ->see('The project id field is required.')
    		 ->seePageIs('/start_session');
    }

    /** @test */
    public function an_organization_cannot_be_created_without_a_name()
    {
    	$user = factory(User::class)->create();

    	$this->actingAs($user)
    		 ->visit('/organizations/create')
    		 ->type('', 'name')
    		 ->press('Create')
    		 ->see('The name field is required.')
    		 ->seePageIs('/organizations/create');
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
