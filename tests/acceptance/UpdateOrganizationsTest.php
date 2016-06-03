<?php

use App\User;
use App\Organization;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateOrganizationsTest extends TestCase
{
	use DatabaseTransactions;

	protected $user;
	protected $organization;

	protected function setUp()
	{
		parent::setUp();
		$this->user = factory(User::class)->create();
    	$this->organization = factory(Organization::class)->create([
    											'name' => 'Test Org',
    											'user_id' => $this->user->id
    										]);		
	}

	/** @test */
    public function a_user_can_view_organization_page_for_one_of_their_organizations()
    {
    	$this->actingAs($this->user)
    		 ->visit('organizations/' . $this->organization->id)
    		 ->see('Test Org');
    }

    /** @test */
    public function a_user_can_edit_an_organization()
    {
    	$this->actingAs($this->user)
    		 ->visit('organizations/' . $this->organization->id)
    		 ->click('Edit Organization')
    		 ->see('Edit Organization')
    		 ->seePageIs('organizations/' . $this->organization->id . '/edit');
    }

    /** @test */
    public function a_user_can_update_an_organization()
    {
    	$this->actingAs($this->user)
    		 ->visit('organizations/' . $this->organization->id . '/edit')
    		 ->type('Test Org Updated', 'name')
    		 ->press('Update Organization')
    		 ->seePageIs('organizations/' . $this->organization->id);

		$this->seeInDatabase('organizations', [
										'id' => $this->organization->id,
										'name' => 'Test Org Updated'
									  ]);
    }

    /** @test */
    public function an_organization_edit_form_cannot_be_submitted_without_a_name()
    {
    	$this->actingAs($this->user)
    		 ->visit('organizations/' . $this->organization->id . '/edit')
    		 ->type('', 'name')
    		 ->press('Update Organization')
    		 ->see('The name field is required.')
    		 ->seePageIs('organizations/' . $this->organization->id . '/edit');
    }
}
