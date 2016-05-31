<?php

use App\User;
use App\Organization;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateProjectsTest extends TestCase
{
	use DatabaseTransactions;

	/** @test */
    public function completing_new_project_form_creates_valid_project()
    {
        $user = factory(User::class)->create();

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
    public function a_project_can_be_created_with_an_organization()
    {
        $user = factory(User::class)->create();
        $organization = factory(Organization::class)->create();

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