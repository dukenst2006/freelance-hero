<?php

use App\User;
use App\Project;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateProjectsTest extends TestCase
{
	use DatabaseTransactions;

	protected $user;
	protected $project;

	protected function setUp()
	{
		parent::setUp();
		$this->user = factory(User::class)->create();
    	$this->project = factory(Project::class)->create([
    											'name' => 'Test Project',
    											'status' => 'Active',
    											'start_date' => '2016-06-01',
    											'target_end_date' => '2016-07-01',
    											'end_date' => null,
    											'user_id' => $this->user->id
    										]);		
	}

	/** @test */
    public function a_user_can_view_project_page_for_one_of_their_projects()
    {
    	$this->actingAs($this->user)
    		 ->visit('projects/' . $this->project->id)
    		 ->see('Test Project')
    		 ->see('2016-06-01')
    		 ->see('2016-07-01');
    }

    /** @test */
    public function a_user_can_edit_a_project()
    {
    	$this->actingAs($this->user)
    		 ->visit('projects/' . $this->project->id)
    		 ->click('Edit Project')
    		 ->see('Edit Project')
    		 ->seePageIs('projects/' . $this->project->id . '/edit');
    }

    /** @test */
    public function a_user_can_update_a_project()
    {
    	$this->actingAs($this->user)
    		 ->visit('projects/' . $this->project->id . '/edit')
    		 ->type('Test Project Updated', 'name')
    		 ->select('Inactive', 'status')
    		 ->type('2016-06-02', 'start_date')
    		 ->type('2016-07-02', 'target_end_date')
    		 ->type('2016-06-03', 'end_date')
    		 ->press('Update Project')
    		 ->seePageIs('projects/' . $this->project->id);

		$this->seeInDatabase('projects', [
										'id' => $this->project->id,
										'name' => 'Test Project Updated',
										'status' => 'Inactive',
										'start_date' => '2016-06-02',
										'target_end_date' => '2016-07-02',
										'end_date' => '2016-06-03'
									  ]);
    }

    /** @test */
    public function a_project_edit_form_cannot_be_submitted_without_a_name()
    {
    	$this->actingAs($this->user)
    		 ->visit('projects/' . $this->project->id . '/edit')
    		 ->type('', 'name')
    		 ->press('Update Project')
    		 ->see('The name field is required.')
    		 ->seePageIs('projects/' . $this->project->id . '/edit');
    }
}