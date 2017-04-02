<?php

namespace App\Http\Controllers;

use Auth;
use Mail;
use App\Project;
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
        return view('home', compact('projects'));
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
