<?php

use App\User;
use App\Project;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateWorkSessionsTest extends TestCase
{
	use DatabaseTransactions;

    /** @test */
    public function a_logged_in_user_can_create_a_work_session()
    {
    	$user = factory(User::class)->create();
    	$project1 = factory(Project::class)->create();

    	$this->actingAs($user)
    		 ->visit('/start_session')
    		 ->select($project1->id, 'project_id')
    		 ->press('Start Session');

		$this->seeInDatabase('work_sessions', ['user_id' => $user->id, 'project_id' => $project1->id, 'start_time' => date("Y-m-d H:i:s")]);
    }
}
