<?php

namespace App\Http\Controllers;

use Auth;
use App\Project;
use App\Organization;
use App\Http\Requests\ProjectRequest;

class ProjectsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $projects = Project::where(['user_id' => Auth::user()->id])->get();
    	return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $organizations = Organization::all();
        $organization_list = array();
        foreach ( $organizations as $organization ) {
            $organization_list[ $organization['id'] ] = $organization['name'];
        }
    	return view('projects.create', compact('organization_list'));
    }

    public function store(ProjectRequest $request)
    {
    	$data = $request->all();
    	$data['user_id'] = Auth::user()->id;
    	Project::create($data);

        return redirect()->action('ProjectsController@index');
    }
}
