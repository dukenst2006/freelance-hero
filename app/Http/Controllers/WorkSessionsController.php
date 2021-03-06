<?php

namespace App\Http\Controllers;

use Auth;
use App\Project;
use App\WorkSession;
use App\Http\Requests\WorkSessionRequest;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

class WorkSessionsController extends Controller
{
	public function __construct()
	{
        parent::__construct();
        $this->middleware('auth');
	}

    public function index()
    {
        return view('work_sessions.index');
    }

    public function show(WorkSession $work_session)
    {
        return view('work_sessions.show', compact('work_session'));
    }

    public function edit(WorkSession $work_session)
    {
        return view('work_sessions.edit', compact('work_session'));
    }

    public function update(WorkSession $work_session, Request $request)
    {
        $work_session->update($request->all());

        return redirect()->action('WorkSessionsController@show', $work_session->id);
    }

    public function active()
    {
        $work_session = WorkSession::active();
        return view('work_sessions.active', compact('work_session'));
    }

    public function past()
    {
        $work_sessions = WorkSession::completed(5);
        return view('work_sessions.past', compact('work_sessions'));
    }

    public function report()
    {
        return view('work_sessions.report', compact('session_summaries'));
    }

    public function summary(Request $request)
    {
        $start = $request->all()['date_start'] ? $request->all()['date_start'] . ' 00:00:00' : null;
        $end = $request->all()['date_end'] ? $request->all()['date_end'] . ' 23:59:59' : null;
        $timeframe = $request->all()['timeframe'];

        $now = new Carbon();

        if ( !$start ) {
            switch($timeframe) {
                case "Weekly":
                    $start = $now->startOfWeek();
                    break;
                case "Monthly":
                    $start = $now->startOfMonth();
                    break;
                case "Bimonthly":
                    $start = WorkSession::getBiMonthlyDate();
                    break;
            }
        }

        $session_summaries = WorkSession::summary(null, $start, $end);
        return response()->json($session_summaries);
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
        $work_session->end();

        Session::forget('active_work_session');
        Session::flash('status', 'Work Session Complete!');

        return redirect()->action('ProjectsController@show', $work_session->project_id);
    }

    public function destroy(WorkSession $work_session)
    {
        $work_session->delete();

        return response()->json(['status' => 'success']);
    }
}
