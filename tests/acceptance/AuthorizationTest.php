<?php

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthorizationTest extends TestCase
{
	use DatabaseTransactions;

    /** @test */
    public function see_user_name_when_logged_in()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)->visit('/')->see($user->first_name);
    }

    /** @test */
    public function a_user_cannot_access_create_organization_page_without_logging_in()
    {
    	$this->visit('/organizations/create')->seePageIs('/login');
    }

	/** @test */
    public function a_user_cannot_access_create_project_page_without_loggin_in()
    {
    	$this->visit('/projects/create')->seePageIs('/login');
    }

    /** @test */
    public function a_user_cannot_create_a_work_session_as_a_guest()
    {
    	$this->visit('/work_sessions/create')->seePageIs('/login');
    }
}
