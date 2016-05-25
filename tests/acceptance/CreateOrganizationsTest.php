<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateOrganizationsTest extends TestCase
{
	use DatabaseTransactions;

    /** @test */
    public function a_user_cannot_access_organizations_page_without_logging_in()
    {
    	$this->visit('/organizations/create')->seePageIs('/login');
    }

	/** @test */
	public function organizations_page_shows_all_organizations_for_logged_in_user()
	{
        $user1 = factory(App\User::class)->create();
        $user2 = factory(App\User::class)->create();

		$organization1 = factory(App\Organization::class)->create(['name' => 'RGR', 'user_id' => $user1->id]);
		$organization2 = factory(App\Organization::class)->create(['name' => 'Other', 'user_id' => $user2->id]);

        $this->actingAs($user1)
	    	 ->visit('/organizations')
	    	 ->see('All Organizations')
	    	 ->see('RGR')
	    	 ->dontSee('Other');
	}

	/** @test */
    public function completing_new_organization_form_creates_valid_organization()
    {
        $user = factory(App\User::class)->create();

        $this->actingAs($user)
	    	 ->visit('/organizations/create')
	         ->type('RGR', 'name')
	         ->press('Create')
	         ->seePageIs('/organizations');

		$this->seeInDatabase('organizations', ['name' => 'RGR']);
    }

    /** @test */
    public function an_organization_cannot_be_created_without_a_name()
    {
    	$user = factory(App\User::class)->create();

    	$this->actingAs($user)
    		 ->visit('/organizations/create')
    		 ->type('', 'name')
    		 ->press('Create')
    		 ->see('The name field is required.')
    		 ->seePageIs('/organizations/create');
    }
}
