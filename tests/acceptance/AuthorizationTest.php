<?php

use App\User;
use App\Project;
use App\Organization;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthorizationTest extends TestCase
{
	use DatabaseTransactions;

    /** @test */
    public function see_user_name_when_logged_in()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)->visit('/')->see($user->first_name);
    }

    /** @test */
    public function a_user_cannot_access_create_organization_page_without_logging_in()
    {
    	$this->visit('/organizations/create')->seePageIs('/login');
    }

	/** @test */
    public function a_user_cannot_access_create_project_page_without_loggin_in()
    {
    	$this->visit('/projects/create')->seePageIs('/login');
    }

    /** @test */
    public function a_user_cannot_create_a_work_session_as_a_guest()
    {
    	$this->visit('/work_sessions/start')->seePageIs('/login');
    }

    /** @test */
    public function organizations_page_shows_all_organizations_for_logged_in_user()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $organization1 = factory(Organization::class)->create(['name' => 'RGR', 'user_id' => $user1->id]);
        $organization2 = factory(Organization::class)->create(['name' => 'Other', 'user_id' => $user2->id]);

        $this->actingAs($user1)
             ->visit('/organizations')
             ->see('All Organizations')
             ->see('RGR')
             ->dontSee('Other');
    }

    /** @test */
    public function projects_page_shows_all_projects_for_logged_in_user()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $project1 = factory(Project::class)->create(['name' => 'Test 1', 'user_id' => $user1->id]);
        $project2 = factory(Project::class)->create(['name' => 'Test 2', 'user_id' => $user2->id]);

        $this->actingAs($user1)
             ->visit('/projects')
             ->see('All Projects')
             ->see('Test 1')
             ->dontSee('Test 2');

    }
}
