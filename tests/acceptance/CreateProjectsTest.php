<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateProjectsTest extends TestCase
{
	use DatabaseTransactions;

	/** @test */
    public function a_user_cannot_access_create_project_page_without_loggin_in()
    {
    	$this->visit('/projects/create')->seePageIs('/login');
    }

	/** @test */
    public function completing_new_project_form_creates_valid_project()
    {
        $user = factory(App\User::class)->create();

        $this->actingAs($user)
	    	 ->visit('/projects/create')
	         ->type('Sigma', 'name')
	         ->type('2016-05-30', 'start_date')
	         ->type('2016-06-30', 'target_end_date')
	         ->press('Create')
	         ->seePageIs('/projects');

		$this->seeInDatabase('projects', ['name' => 'Sigma', 'user_id' => $user->id]);
    }

    /** @test */
    public function a_project_cannot_be_created_without_a_name()
    {
    	$user = factory(App\User::class)->create();

    	$this->actingAs($user)
	    	 ->visit('/projects/create')
	         ->type('', 'name')
	         ->type('2016-05-30', 'start_date')
	         ->type('2016-06-30', 'target_end_date')
	         ->press('Create')
    		 ->see('The name field is required.')
    		 ->seePageIs('/projects/create');
    }

    /** @test */
    public function a_project_can_be_created_with_an_organization()
    {
        $user = factory(App\User::class)->create();
        $organization = factory(App\Organization::class)->create();

        $this->actingAs($user)
             ->visit('/projects/create')
             ->type('Sigma', 'name')
             ->type('2016-05-30', 'start_date')
             ->type('2016-06-30', 'target_end_date')
             ->select($organization->id, 'organization_id')
             ->press('Create')
             ->seePageIs('/projects');

        $this->seeInDatabase('projects', ['name' => 'Sigma', 'organization_id' => $organization->id]);
    }
}