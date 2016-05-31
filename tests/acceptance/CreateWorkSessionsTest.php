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

    /** @test */
    public function a_logged_in_user_can_create_a_work_session()
    {
    	$user = factory(App\User::class)->create();
    	$project1 = factory(App\Project::class)->create();

    	$this->actingAs($user)
    		 ->visit('/start_session')
    		 ->select($project1->id, 'project_id')
    		 ->press('Start Session');

		$this->seeInDatabase('work_sessions', ['user_id' => $user->id, 'project_id' => $project1->id, 'start_time' => date("Y-m-d H:i:s")]);
    }

    /** @test */
    public function a_work_session_must_have_a_proejct()
    {
    	$user = factory(App\User::class)->create();
    	$project1 = factory(App\Project::class)->create();

    	$this->actingAs($user)
    		 ->visit('/start_session')
    		 ->press('Start Session')
    		 ->see('The project id field is required.')
    		 ->seePageIs('/start_session');
    }
}
