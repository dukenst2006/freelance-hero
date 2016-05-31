<?php

use App\User;
use App\Project;
use App\Organization;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrganizationTest extends TestCase
{
	use DatabaseTransactions;

	/** @test */
    public function returns_all_organizations()
    {
    	factory(Organization::class, 3)->create();

    	$organizations = Organization::all();
        $this->assertEquals(3, $organizations->count());
    }

    /** @test */
    public function can_create_organization_with_all_attributes()
    {
    	$organization = factory(Organization::class)->create();

    	$this->assertNotEmpty($organization->name);
    }

    /** @test */
    public function an_organization_belongs_to_a_user()
    {
    	$user = factory(User::class)->create();
    	$organization = factory(Organization::class)->create(['user_id' => $user->id]);

    	$this->assertEquals($user->id, $organization->user->id);
    }

    /** @test */
    public function an_organization_has_projects()
    {
    	$organization = factory(Organization::class)->create();
    	$project1 = factory(Project::class)->create(['organization_id' => $organization->id]);
    	$project2 = factory(Project::class)->create(['organization_id' => $organization->id]);

    	$this->assertEquals($organization->id, $project1->organization->id);
    	$this->assertEquals($organization->id, $project2->organization->id);
    	$this->assertEquals(count($organization->projects), 2);
    }
}
