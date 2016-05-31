<?php

use App\User;
use App\Project;
use App\WorkSession;
use App\Organization;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjectTest extends TestCase
{
	use DatabaseTransactions;

	/** @test */
    public function returns_all_projects()
    {
    	factory(Project::class, 3)->create();

    	$projects = Project::all();
        $this->assertEquals(3, $projects->count());
    }

    /** @test */
    public function a_project_has_a_name()
    {
    	$project = factory(Project::class)->create();

    	$this->assertNotEmpty($project->name);
    }

    /** @test */
    public function a_project_has_a_start_date()
    {
    	$project = factory(Project::class)->create();

    	$this->assertNotEmpty($project->start_date);
    }

    /** @test */
    public function a_project_belongs_to_a_user()
    {
        $user = factory(User::class)->create();
        $project = factory(Project::class)->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $project->user->id);
    }

    /** @test */
    public function a_project_belongs_to_an_organization()
    {
        $organization = factory(Organization::class)->create();
        $project = factory(Project::class)->create(['organization_id' => $organization->id]);

        $this->assertEquals($organization->id, $project->organization->id);
    }

    /** @test */
    public function a_project_can_exist_without_an_organization()
    {
        $project = factory(Project::class)->make(['organization_id' => null]);

        $this->assertTrue($project->save());
    }

    /** @test */
    public function a_project_may_have_work_sessions()
    {
        $project = factory(Project::class)->create();
        $work_session1 = factory(WorkSession::class)->create(['project_id' => $project->id]);
        $work_session2 = factory(WorkSession::class)->create(['project_id' => $project->id]);

        $this->assertEquals($project->id, $work_session1->project->id);
        $this->assertEquals($project->id, $work_session2->project->id);
        $this->assertEquals(count($project->work_sessions), 2);
    }
}
