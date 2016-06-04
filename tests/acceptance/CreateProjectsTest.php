<?php

use App\User;
use App\Organization;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateProjectsTest extends TestCase
{
	use DatabaseTransactions;

    protected $user;

    protected function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

	/** @test */
    public function a_project_can_be_created_with_valid_fields()
    {
        $this->actingAs($this->user)
	    	 ->visit('/projects/create')
	         ->type('Sigma', 'name')
	         ->type('2016-05-30', 'start_date')
	         ->type('2016-06-30', 'target_end_date')
	         ->press('Create')
	         ->seePageIs('/projects');

		$this->seeInDatabase('projects', [
                                            'name' => 'Sigma',
                                            'user_id' => $this->user->id,
                                            'status' => 'Active',
                                            'start_date' => '2016-05-30',
                                            'target_end_date' => '2016-06-30',
                                            'end_date' => null,
                                            'organization_id' => 0
                                        ]);
    }

    /** @test */
    public function a_project_can_be_created_with_an_organization()
    {
        $organization = factory(Organization::class)->create(['name' => 'Org 1', 'user_id' => $this->user->id]);
        $org2 = factory(Organization::class)->create(['name' => 'Org 2']);

        $this->actingAs($this->user)
             ->visit('/projects/create')
             ->type('Sigma', 'name')
             ->type('2016-05-30', 'start_date')
             ->type('2016-06-30', 'target_end_date')
             ->see('Org 1')
             ->dontSee('Org 2')
             ->select($organization->id, 'organization_id')
             ->press('Create')
             ->seePageIs('/projects');

        $this->seeInDatabase('projects', ['name' => 'Sigma', 'organization_id' => $organization->id]);
    }

    /** @test */
    public function a_project_can_be_created_without_a_target_end_date()
    {
        $this->actingAs($this->user)
             ->visit('/projects/create')
             ->type('Sigma', 'name')
             ->type('2016-05-30', 'start_date')
             ->type('', 'target_end_date')
             ->press('Create')
             ->seePageIs('/projects');

        $this->seeInDatabase('projects', ['name' => 'Sigma', 'user_id' => $this->user->id]);
    }

    /** @test */
    public function a_project_must_have_a_name()
    {
        $this->actingAs($this->user)
             ->visit('/projects/create')
             ->type('', 'name')
             ->type('2016-05-30', 'start_date')
             ->type('2016-06-30', 'target_end_date')
             ->press('Create')
             ->see('The name field is required.')
             ->seePageIs('/projects/create');
    }

    /** @test */
    public function a_project_must_have_a_start_date()
    {
        $this->actingAs($this->user)
             ->visit('/projects/create')
             ->type('Test', 'name')
             ->type('', 'start_date')
             ->type('2016-06-30', 'target_end_date')
             ->press('Create')
             ->see('The start date field is required.')
             ->seePageIs('/projects/create');
    }

    /** @test */
    public function a_project_cannot_be_created_with_a_target_end_date_after_start_date()
    {
        $this->actingAs($this->user)
             ->visit('/projects/create')
             ->type('Test', 'name')
             ->type('2016-05-30', 'start_date')
             ->type('2016-04-30', 'target_end_date')
             ->press('Create')
             ->see('The target end date must be a date after start date.')
             ->seePageIs('/projects/create');
    }

    /** @test */
    public function a_porject_start_date_must_be_properly_formatted()
    {
        $this->actingAs($this->user)
             ->visit('/projects/create')
             ->type('Test', 'name')
             ->type('asdf', 'start_date')
             ->type('2016-04-30', 'target_end_date')
             ->press('Create')
             ->see('The start date does not match the format Y-m-d.')
             ->seePageIs('/projects/create');        
    }

    /** @test */
    public function a_project_target_end_date_must_be_properly_formatted()
    {
        $this->actingAs($this->user)
             ->visit('/projects/create')
             ->type('Test', 'name')
             ->type('2016-05-30', 'start_date')
             ->type('asdf', 'target_end_date')
             ->press('Create')
             ->see('The target end date does not match the format Y-m-d.')
             ->seePageIs('/projects/create');        
    }
}