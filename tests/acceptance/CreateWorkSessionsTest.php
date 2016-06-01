<?php

use App\User;
use App\Project;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateWorkSessionsTest extends TestCase
{
	use DatabaseTransactions;

    protected $user;

    protected function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function a_logged_in_user_can_create_a_work_session()
    {
    	$project1 = factory(Project::class)->create();

    	$this->actingAs($this->user)
    		 ->visit('/start_session')
    		 ->select($project1->id, 'project_id')
    		 ->press('Start Session');

		$this->seeInDatabase('work_sessions', ['user_id' => $this->user->id, 'project_id' => $project1->id, 'start_time' => date("Y-m-d H:i:s")]);
    }

    /** @test */
    public function a_work_session_must_have_a_proejct()
    {
        $project1 = factory(Project::class)->create();

        $this->actingAs($this->user)
             ->visit('/start_session')
             ->press('Start Session')
             ->see('Please select a project.')
             ->seePageIs('/start_session');
    }
}
