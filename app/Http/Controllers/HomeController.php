<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Mail;
use App\Project;
use App\WorkSession;
use App\Organization;
use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth', ['only' => ['index']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::where(['user_id' => Auth::user()->id])->get();

        $organizations = Organization::where(['user_id' => Auth::user()->id])->get();

        $ytd_hours = DB::table('work_sessions')
                            ->select(DB::raw('sum(total_hours) as total_hours'))
                            ->where([
                                ['user_id', Auth::user()->id],
                                ['end_time', '>=', '2016-09-01 00:00:00'],
                            ])
                            ->first();

        return view('home', compact('projects', 'organizations', 'ytd_hours'));
    }

    public function contact(Request $request)
    {
        $this->validate($request, [
            'fullName' => 'required',
            'email' => 'required|email',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        $data = $request->all();

        Mail::send('emails.contact', ['data' => $data], function($message) use ($data) {
            $message->to('info@freelance-hero.com');
            $message->bcc('zackmays@gmail.com');
            $message->from($data['email']);
            $message->subject('Contact Form Completed');
        });

        return view('contact');
    }
}
