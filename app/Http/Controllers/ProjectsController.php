<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\Project;
use App\Http\Requests\ProjectRequest;

class ProjectsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	//
    }

    public function create()
    {
    	return view('projects.create');
    }

    public function store(ProjectRequest $request)
    {
    	$data = $request->all();
    	$data['user_id'] = Auth::user()->id;
    	Project::create($data);

        return redirect()->action('ProjectsController@index');
    }
}
