<?php

namespace App\Http\Controllers;

use Auth;
use App\Project;
use App\Organization;
use App\Http\Requests\ProjectRequest;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $organizations = Organization::where(['user_id' => Auth::user()->id])->get();
        $personal_projects = Project::where(['user_id' => Auth::user()->id, 'organization_id' => 0])->get();
    	return view('projects.index', compact('personal_projects'), compact('organizations'));
    }

    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Project $project, ProjectRequest $request)
    {
        $data = $request->all();
        $data['end_date'] = $request->all()['end_date'] ?: null;
        $data['target_end_date'] = $request->all()['target_end_date'] ?: null;
        $project->update($data);
        return redirect()->action('ProjectsController@show', $project->id);
    }

    public function create()
    {
        $organization_list = Organization::where(['user_id' => Auth::user()->id])->lists('name', 'id');
    	return view('projects.create', compact('organization_list'));
    }

    public function store(ProjectRequest $request)
    {
        $project = new Project($request->all());
        $project->target_end_date = $request->all()['target_end_date'] ?: null;
        Auth::user()->projects()->save($project);

        return redirect()->action('ProjectsController@index');
    }

    public function complete(Request $request)
    {
        $project = Project::find( $request->all()['project_id'] );
        $project->complete();

        return redirect()->action('ProjectsController@show', $project->id);
    }

    public function sessions(Project $project)
    {
        return view('projects.sessions', compact('project'));
    }
}
