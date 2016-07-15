<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Http\Requests;

class BaseController extends Controller
{
    public function contact(Request $request)
    {
	    $this->validate($request, [
	        'fullName' => 'required',
	        'email' => 'required|email'
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
