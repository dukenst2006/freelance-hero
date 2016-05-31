<?php

use App\User;
use App\Project;
use App\WorkSession;
use App\Organization;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
	use DatabaseTransactions;

	/** @test */
    public function returns_all_users()
    {
    	factory(User::class, 3)->create();

    	$users = User::all();
        $this->assertEquals(3, $users->count());
    }

    /** @test */
    public function a_user_has_all_attributes()
    {
    	$user = factory(User::class)->create();

    	$this->assertNotEmpty($user->first_name);
    	$this->assertNotEmpty($user->last_name);
    	$this->assertNotEmpty($user->email);
    	$this->assertNotEmpty($user->password);
    }

    /** @test */
    public function a_user_has_projects()
    {
    	$user = factory(User::class)->create();
    	$project1 = factory(Project::class)->create(['user_id' => $user->id]);
    	$project2 = factory(Project::class)->create(['user_id' => $user->id]);

    	$this->assertEquals($user->id, $project1->user->id);
    	$this->assertEquals($user->id, $project2->user->id);
    	$this->assertEquals(count($user->projects), 2);
    }

    /** @test */
    public function a_user_may_have_work_sessions()
    {
        $user = factory(User::class)->create();
        $work_session1 = factory(WorkSession::class)->create(['user_id' => $user->id]);
        $work_session2 = factory(WorkSession::class)->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $work_session1->user->id);
        $this->assertEquals($user->id, $work_session2->user->id);
        $this->assertEquals(count($user->work_sessions), 2);
    }

    /** @test */
    public function a_user_has_organizations()
    {
        $user = factory(User::class)->create();
        $organization1 = factory(Organization::class)->create(['user_id' => $user->id]);
        $organization2 = factory(Organization::class)->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $organization1->user->id);
        $this->assertEquals($user->id, $organization2->user->id);
        $this->assertEquals(count($user->organizations), 2);
    }
}
