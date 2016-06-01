<?php

use App\User;
use App\Project;
use App\WorkSession;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ManageWorkSessionsTest extends TestCase
{
	use DatabaseTransactions;

    protected $user;

    protected function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function a_user_can_start_a_work_session()
    {
    	$project1 = factory(Project::class)->create();

    	$this->actingAs($this->user)
    		 ->visit('/work_sessions/start')
    		 ->select($project1->id, 'project_id')
    		 ->press('Start Session');

		$this->seeInDatabase('work_sessions', ['user_id' => $this->user->id, 'project_id' => $project1->id, 'start_time' => date("Y-m-d H:i:s")]);
    }

    /** @test */
    public function a_work_session_must_have_a_proejct()
    {
        $project1 = factory(Project::class)->create();

        $this->actingAs($this->user)
             ->visit('/work_sessions/start')
             ->press('Start Session')
             ->see('Please select a project.')
             ->seePageIs('/work_sessions/start');
    }

    /** @test */
    public function a_user_can_view_their_active_sessions()
    {
        $project1 = factory(Project::class)->create(['name' => 'Test 1']);
        $project2 = factory(Project::class)->create(['name' => 'Test 2']);
        $work_session1 = factory(WorkSession::class)->create(['end_time' => null, 'project_id' => $project1->id, 'user_id' => $this->user->id]);
        $work_session2 = factory(WorkSession::class)->create(['project_id' => $project2->id, 'user_id' => $this->user->id]);

        $this->actingAs($this->user)
             ->visit('/work_sessions/active')
             ->see('Test 1')
             ->dontSee('Test 2');
    }

    /** @test */
    public function a_user_cannot_see_active_sessions_for_other_users()
    {
        $project1 = factory(Project::class)->create(['name' => 'Test 1']);
        $project2 = factory(Project::class)->create(['name' => 'Test 2']);
        $user2 = factory(User::class)->create();
        $work_session1 = factory(WorkSession::class)->create(['end_time' => null, 'project_id' => $project1->id, 'user_id' => $this->user->id]);
        $work_session2 = factory(WorkSession::class)->create(['end_time' => null, 'project_id' => $project2->id, 'user_id' => $user2->id]);

        $this->actingAs($this->user)
             ->visit('/work_sessions/active')
             ->see('Test 1')
             ->dontSee('Test 2');
    }

    public function a_user_can_end_an_active_work_session()
    {
        $work_session = factory(WorkSession::class)->create(['start_time' => '2016-06-01 00:00:00']);
    }
}
