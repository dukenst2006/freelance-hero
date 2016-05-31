<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\WorkSession;
use App\Http\Requests;
use App\Http\Requests\WorkSessionRequest;
use Auth;

class WorkSessionsController extends Controller
{
	public function __construct()
	{
        $this->middleware('auth');
	}

    public function create()
    {
        $projects = Project::all();
        $project_list = array();
        foreach ( $projects as $project ) {
            $project_list[ $project['id'] ] = $project['name'];
        }
    	return view('work_sessions.create', compact('project_list'));
    }

    public function store(WorkSessionRequest $request)
    {
    	$data = $request->all();
    	$data['user_id'] = Auth::user()->id;
    	$data['start_time'] = date("Y-m-d H:i:s");
    	WorkSession::create($data);

        return redirect()->action('HomeController@index');
    }
}
