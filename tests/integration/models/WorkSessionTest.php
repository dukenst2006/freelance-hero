<?php

use App\User;
use App\Project;
use App\WorkSession;
use Carbon\Carbon;
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

    /** @test */
    public function can_fetch_current_work_session()
    {
        $user = factory(User::class)->create();
        $work_session = factory(WorkSession::class)->create(['user_id' => $user->id]);
        $active_session = WorkSession::active($user->id);

        $this->assertEquals($active_session->id, $work_session->id);
    }

    /** @test */
    public function active_session_function_throws_exception_if_no_active_session()
    {
        $user = factory(User::class)->create();
        $work_session = factory(WorkSession::class)->create(['user_id' => $user->id, 'end_time' => '2016-06-01 12:00:00']);

        $active_session = WorkSession::active($user->id);

        $this->assertEmpty($active_session);
    }

    /** @test */
    public function can_return_summary_of_this_weeks_sessions()
    {
        $user = factory(User::class)->create();
        Auth::loginUsingId($user->id);
        $project = factory(Project::class)->create();
        $now = new Carbon();

        $work_session1 = factory(WorkSession::class)->create([
            'user_id' => $user->id,
            'project_id' => $project->id,
            'start_time' => $now->hour(0)->minute(1)->second(0)->toDateTimeString(),
            'end_time' => $now->hour(1)->minute(1)->second(0)->toDateTimeString(),
            'total_hours' => '1.00'
        ]);

        $work_session2 = factory(WorkSession::class)->create([
            'user_id' => $user->id,
            'project_id' => $project->id,
            'start_time' => $now->hour(1)->minute(2)->second(0)->toDateTimeString(),
            'end_time' => $now->hour(1)->minute(32)->second(0)->toDateTimeString(),
            'total_hours' => '0.50'
        ]);

        $summary = WorkSession::summary($project);
        $this->assertEquals( $summary->total_time, '1.5' );
    }

    /** @test */
    public function can_end_session()
    {
        $user = factory(User::class)->create();
        $now = new Carbon();

        $work_session = factory(WorkSession::class)->create([
            'user_id' => $user->id,
            'start_time' => $now->subMinutes(10),
            'end_time' => null
        ]);

        $work_session->end();

        $this->assertEquals( $work_session->total_hours, '.25' );
        $this->seeInDatabase('work_sessions', ['id' => $work_session->id, 'total_hours' => '.25']);
    }

    /** @test */
    public function can_round_session_time_up_to_next_quarter_when_more_than_five_minutes_past_last_quarter()
    {
        $user = factory(User::class)->create();
        $now = new Carbon();

        $work_session = factory(WorkSession::class)->create([
            'user_id' => $user->id,
            'start_time' => $now->subMinutes(21),
            'end_time' => null
        ]);

        $work_session->end();

        $this->assertEquals( '.50', $work_session->total_hours );
    }

    /** @test */
    public function can_round_session_time_down_to_last_quarter_when_less_than_five_minutes_past_last_quarter()
    {
        $user = factory(User::class)->create();
        $now = new Carbon();

        $work_session = factory(WorkSession::class)->create([
            'user_id' => $user->id,
            'start_time' => $now->subMinutes(17),
            'end_time' => null
        ]);

        $work_session->end();

        $this->assertEquals( '.25', $work_session->total_hours );
    }

    /** @test */
    public function a_work_session_can_be_soft_deleted()
    {
        $work_session = factory(WorkSession::class)->create();
        $work_session->delete();

        $this->seeInDatabase('work_sessions', ['id' => $work_session->id]);
        $this->assertNotNull($work_session->deleted_at);
    }

    /** @test */
    public function work_session_summary_excludes_sessions_that_have_been_soft_deleted()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $remaining_session = factory(WorkSession::class)->create([
            'user_id' => $user->id,
            'start_time' => '2016-12-02 13:00:00',
            'end_time' => '2016-12-02 15:00:00',
            'total_hours' => '2'
        ]);
        $deleted_session = factory(WorkSession::class)->create([
            'user_id' => $user->id,
            'start_time' => '2016-12-02 16:00:00',
            'end_time' => '2016-12-02 18:00:00',
            'total_hours' => '2'
        ]);

        $deleted_session->delete();

        $summaries = WorkSession::summary(null, '2016-12-01', '2016-12-03');

        $summary_total = 0;
        foreach ($summaries as $summary) {
            $summary_total += (int) $summary->total_time;
        }

        $this->assertEquals(2, $summary_total);
    }
}
