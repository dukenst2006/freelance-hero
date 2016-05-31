<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateWorkSessionsTest extends TestCase
{
	use DatabaseTransactions;

    /** @test */
    public function a_user_cannot_create_a_work_session_as_a_guest()
    {
    	$this->visit('/work_sessions/create')->seePageIs('/login');
    }

    // not passing - need to work on
    public function a_logged_in_user_can_create_a_work_session()
    {
    	$user = factory(App\User::class)->create();
    	$project1 = factory(App\Project::class)->create();

    	$this->actingAs($user)
    		 ->visit('/start_session')
    		 ->select($project1->id, 'project')
    		 ->press('start');

		$this->seeInDatabase('work_sessions', ['user_id' => $user->id, 'project_id' => $project->id, 'start_time' => date()]);
    }
}
