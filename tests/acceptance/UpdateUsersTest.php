<?php

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateUsersTest extends TestCase
{
	use DatabaseTransactions;

    protected $user;

    protected function setUp()
    {
        parent::setUp();
    	$this->user = factory(User::class)->create([
    											'first_name' => 'Zack',
    											'last_name' => 'Peter',
    											'email' => 'test@test.com'
    										]);
    }


	/** @test */
    public function a_user_can_visit_profile_page_and_view_their_information()
    {
    	$this->actingAs($this->user)
    		 ->visit('/profile')
    		 ->see('Zack')
    		 ->see('Peter')
    		 ->see('test@test.com');
    }

    /** @test */
    public function a_user_can_edit_their_profile()
    {
    	$this->actingAs($this->user)
    		 ->visit('/profile')
    		 ->click('Edit Profile')
    		 ->see('Edit Profile')
    		 ->seePageIs('/profile/edit');
    }

    /** @test */
    public function a_user_can_update_their_profile()
    {
    	$this->actingAs($this->user)
    		 ->visit('profile/edit')
    		 ->type('Steve', 'first_name')
    		 ->type('Johnson', 'last_name')
    		 ->type('test2@test.com', 'email')
    		 ->press('Update Profile')
    		 ->seePageIs('/profile');

		$this->seeInDatabase('users', [
										'id' => $this->user->id,
										'first_name' => 'Steve',
										'last_name' => 'Johnson',
										'email' => 'test2@test.com'
									  ]);
    }

    /** @test */
    public function a_profile_edit_form_cannot_be_submitted_without_a_first_name()
    {
    	$this->actingAs($this->user)
    		 ->visit('profile/edit')
    		 ->type('', 'first_name')
    		 ->press('Update Profile')
    		 ->see('The first name field is required.')
    		 ->seePageIs('/profile/edit');
    }

    /** @test */
    public function a_profile_edit_form_cannot_be_submitted_without_a_last_name()
    {
    	$this->actingAs($this->user)
    		 ->visit('profile/edit')
    		 ->type('', 'last_name')
    		 ->press('Update Profile')
    		 ->see('The last name field is required.')
    		 ->seePageIs('/profile/edit');
    }

    /** @test */
    public function a_profile_edit_form_cannot_be_submitted_without_an_email()
    {
    	$this->actingAs($this->user)
    		 ->visit('profile/edit')
    		 ->type('', 'email')
    		 ->press('Update Profile')
    		 ->see('The email field is required.')
    		 ->seePageIs('/profile/edit');
    }
}
