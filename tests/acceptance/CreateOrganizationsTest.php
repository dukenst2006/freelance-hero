<?php

use App\User;
use App\Organization;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateOrganizationsTest extends TestCase
{
	use DatabaseTransactions;

    protected $user;

    protected function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

	/** @test */
    public function completing_new_organization_form_creates_valid_organization()
    {
        $this->actingAs($this->user)
	    	 ->visit('/organizations/create')
	         ->type('RGR', 'name')
	         ->press('Create')
	         ->seePageIs('/organizations');

		$this->seeInDatabase('organizations', ['name' => 'RGR', 'user_id' => $this->user->id]);
    }

    /** @test */
    public function an_organization_cannot_be_created_without_a_name()
    {
    	$this->actingAs($this->user)
    		 ->visit('/organizations/create')
    		 ->type('', 'name')
    		 ->press('Create')
    		 ->see('The name field is required.')
    		 ->seePageIs('/organizations/create');
    }
}
