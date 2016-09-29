<?php

namespace App\Http\Controllers;

use Auth;
use App\Project;
use App\WorkSession;
use App\Http\Requests\WorkSessionRequest;
use Session;
use Carbon\Carbon;

class WorkSessionsController extends Controller
{
	public function __construct()
	{
        $this->middleware('auth');
	}

    public function index()
    {
        return view('work_sessions.index');
    }

    public function active()
    {
        $work_session = WorkSession::active();
        return view('work_sessions.active', compact('work_session'));
    }

    public function past()
    {
        $work_sessions = WorkSession::completed();
        return view('work_sessions.past', compact('work_sessions'));
    }

    public function report()
    {
        $session_summaries = WorkSession::summary();
        return view('work_sessions.report', compact('session_summaries'));
    }

    public function create()
    {
        $project_list = Project::where(['user_id' => Auth::user()->id])->lists('name', 'id');
    	return view('work_sessions.create', compact('project_list'));
    }

    public function store(WorkSessionRequest $request)
    {
        //if an active session already exists for this user, don't create a new one
        if ( WorkSession::active() ) {
            Session::flash('flash_error_message', 'An active session already exists. Please end that session before starting a new one.');
            return redirect()->action('WorkSessionsController@create');
        }

        $data = $request->all();
        $data['start_time'] = new Carbon();

        Auth::user()->work_sessions()->create($data);
        Session::put('active_work_session', true);
        Session::put('work_session_start_time', date('Y-m-d h:i:s'));

        return redirect()->action('HomeController@index');
    }

    public function end()
    {
        $work_session = WorkSession::active();

        $work_session->end_time = new Carbon();
        $start_time_formatted = new Carbon($work_session->start_time);
        $interval = $work_session->end_time->diff($start_time_formatted);
        $work_session->total_hours = $interval->h;

        if ( $interval->i > 45 ) {
            $work_session->total_hours += 1;
        } else {
            if ( $interval->i % 15 != 0 ) {
                $nearest_quarter = $interval->i - ($interval->i % 15) + 15;
            } else {
                $nearest_quarter = $interval->i;
            }
            $work_session->total_hours += $nearest_quarter / 60;
        }

        $work_session->save();

        Session::forget('active_work_session');

        return redirect()->action('WorkSessionsController@past');        
    }
}
