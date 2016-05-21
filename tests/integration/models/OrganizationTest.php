<?php

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
}
