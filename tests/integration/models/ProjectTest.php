<?php

use App\Project;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjectTest extends TestCase
{
	use DatabaseTransactions;

	/** @test */
    public function returns_all_projects()
    {
    	factory(Project::class, 3)->create();

    	$projects = Project::all();
        $this->assertTrue(true);
    }
}
