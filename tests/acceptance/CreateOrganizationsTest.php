<?php

use App\User;
use App\Organization;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateOrganizationsTest extends TestCase
{
	use DatabaseTransactions;

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
    public function completing_new_organization_form_creates_valid_organization()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
	    	 ->visit('/organizations/create')
	         ->type('RGR', 'name')
	         ->press('Create')
	         ->seePageIs('/organizations');

		$this->seeInDatabase('organizations', ['name' => 'RGR', 'user_id' => $user->id]);
    }
}
