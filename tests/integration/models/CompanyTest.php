<?php

use App\Company;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CompanyTest extends TestCase
{
	use DatabaseTransactions;

	/** @test */
    public function returns_all_companies()
    {
    	factory(Company::class, 3)->create();

    	$companies = Company::all();
        $this->assertEquals(3, $companies->count());
    }
}
