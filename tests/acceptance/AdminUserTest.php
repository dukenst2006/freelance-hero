<?php

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminUserTest extends TestCase
{
	use DatabaseTransactions;

    protected $user;

    protected function setUp()
    {
        parent::setUp();
    	$this->user = factory(User::class)->create(['role' => 'Admin']);
    }

    /** @test */
    public function an_admin_can_visit_admin_page()
    {
    	$this->actingAs($this->user)
    		 ->visit('/admin')
    		 ->see('Admin Portal');
    }

    /** @test */
    public function a_user_cannot_view_admin_portal_if_not_admin()
    {
    	$user_two = factory(User::class)->create();

    	$this->actingAs($user_two)
    		 ->visit('/admin')
    		 ->see('Oops - you seen to have lost your way!');
    }
}
