<?php

use App\User;
use App\Project;
use App\WorkSession;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WorkSessionTest extends TestCase
{
	use DatabaseTransactions;

	/** @test */
    public function returns_all_work_sessions()
    {
    	factory(WorkSession::class, 3)->create();

    	$work_sessions = WorkSession::all();
    	$this->assertEquals($work_sessions->count(), 3);
    }

    /** @test */
    public function a_work_session_is_created_with_appropriate_attributes()
    {
    	$work_session = factory(WorkSession::class)->create();
    	$saved_session = WorkSession::find($work_session->id);

    	$this->assertNotEmpty($saved_session->start_time);
    	$this->assertEmpty($saved_session->end_time);
    	$this->assertEmpty($saved_session->total_time);    	
    }

    /** @test */
    public function a_work_session_belongs_to_a_project()
    {
    	$project = factory(Project::class)->create();
    	$work_session = factory(WorkSession::class)->create(['project_id' => $project->id]);

    	$this->assertEquals($project->id, $work_session->project->id);
    }

    /** @test */
    public function a_work_session_belongs_to_a_user()
    {
    	$user = factory(User::class)->create();
    	$work_session = factory(WorkSession::class)->create(['user_id' => $user->id]);

    	$this->assertEquals($user->id, $work_session->user->id);
    }
}
