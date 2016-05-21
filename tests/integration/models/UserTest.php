<?php

use App\User;
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
}
