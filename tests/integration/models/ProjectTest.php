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
        $this->assertEquals(3, $projects->count());
    }

    /** @test */
    public function a_project_has_a_name()
    {
    	$project = factory(Project::class)->create();

    	$this->assertNotEmpty($project->name);
    }

    /** @test */
    public function a_project_must_have_a_start_date()
    {
    	$project = factory(Project::class)->create();

    	$this->assertNotEmpty($project->start_date);
    }
}
