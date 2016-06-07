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
    	$project1 = factory(Project::class)->create(['name' => 'Test 1', 'user_id' => $this->user->id]);
        $project2 = factory(Project::class)->create(['name' => 'Test 2']);

    	$this->actingAs($this->user)
    		 ->visit('/work_sessions/start')
             ->see('Test 1')
             ->dontSee('Test 2')
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
    public function a_user_cannot_have_two_active_sessions()
    {
        $project = factory(Project::class)->create(['name' => 'Test 1', 'user_id' => $this->user->id]);
        $work_session1 = factory(WorkSession::class)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user)
             ->visit('/work_sessions/start')
             ->select($project->id, 'project_id')
             ->press('Start Session')
             ->see('An active session already exists. Please end that session before starting a new one.')
             ->seePageIs('/work_sessions/start');
    }

    /** @test */
    public function a_user_can_view_their_active_sessions()
    {
        $project1 = factory(Project::class)->create(['name' => 'Test 1']);
        $project2 = factory(Project::class)->create(['name' => 'Test 2']);
        $work_session1 = factory(WorkSession::class)->create(['project_id' => $project1->id, 'user_id' => $this->user->id]);
        $work_session2 = factory(WorkSession::class)->create(['end_time' => '2016-06-01 12:00:00', 'project_id' => $project2->id, 'user_id' => $this->user->id]);

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
        $work_session1 = factory(WorkSession::class)->create(['project_id' => $project1->id, 'user_id' => $this->user->id]);
        $work_session2 = factory(WorkSession::class)->create(['project_id' => $project2->id, 'user_id' => $user2->id]);

        $this->actingAs($this->user)
             ->visit('/work_sessions/active')
             ->see('Test 1')
             ->dontSee('Test 2');
    }

    /** @test */
    public function a_user_can_end_an_active_work_session()
    {
        $start_time = new DateTime();
        $start_time->sub(new DateInterval('PT1H'));
        $work_session_init = factory(WorkSession::class)->create(['start_time' => $start_time, 'user_id' => $this->user->id]);
        $this->session(['active_work_session' => 'true']);

        $this->actingAs($this->user)
             ->visit('/home')
             ->see('End Session')
             ->press('End Session');

        $work_session_update = WorkSession::find($work_session_init->id);

        $this->assertEquals($work_session_update->end_time, date("Y-m-d H:i:s"));
        $this->assertEquals($work_session_update->total_time, '01:00:00');
    }

    /** @test */
    public function a_user_can_view_past_work_sessions()
    {
        $project = factory(Project::class)->create(['name' => 'Test Project', 'user_id' => $this->user->id]);
        $project2 = factory(Project::class)->create(['name' => 'Test Project 2', 'user_id' => $this->user->id]);
        $work_session1 = factory(WorkSession::class)->create([
            'user_id' => $this->user->id,
            'project_id' => $project->id,
            'start_time' => '2016-06-03 10:00:00',
            'end_time' => '2016-06-03 11:00:00',
            'total_time' => '01:00:00'
        ]);

        $work_session2 = factory(WorkSession::class)->create([
            'user_id' => $this->user->id,
            'project_id' => $project->id,
            'start_time' => '2016-06-03 12:00:00',
            'end_time' => '2016-06-03 12:30:00',
            'total_time' => '00:30:00'
        ]);

        $work_session2 = factory(WorkSession::class)->create([
            'user_id' => $this->user->id,
            'project_id' => $project2->id,
            'start_time' => '2016-06-03 13:00:00'
        ]);

        $this->actingAs($this->user)
             ->visit('/work_sessions/past')
             ->see('Test Project')
             ->see('01:00:00')
             ->see('00:30:00')
             ->dontSee('Test Project 2');
    }

    /** @test */
    public function a_user_will_only_see_their_past_sessions()
    {
        $project = factory(Project::class)->create(['name' => 'Test Project', 'user_id' => $this->user->id]);
        $project2 = factory(Project::class)->create(['name' => 'Test Project 2', 'user_id' => $this->user->id]);
        $user2 = factory(User::class)->create();
        $work_session1 = factory(WorkSession::class)->create([
            'user_id' => $this->user->id,
            'project_id' => $project->id,
            'start_time' => '2016-06-03 10:00:00',
            'end_time' => '2016-06-03 11:00:00',
            'total_time' => '01:00:00'
        ]);

        $work_session2 = factory(WorkSession::class)->create([
            'user_id' => $user2->id,
            'project_id' => $project2->id,
            'start_time' => '2016-06-03 12:00:00',
            'end_time' => '2016-06-03 12:30:00',
            'total_time' => '00:30:00'
        ]);

        $this->actingAs($this->user)
             ->visit('/work_sessions/past')
             ->see('Test Project')
             ->dontSee('Test Project 2');
    }
}
