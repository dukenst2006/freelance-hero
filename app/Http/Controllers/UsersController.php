<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Http\Requests;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile()
    {
    	$user = Auth::user();
    	return view('users.profile', compact('user'));
    }

    public function edit()
    {
    	$user = Auth::user();
    	return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request)
    {
    	$user = User::find(Auth::user()->id);
    	$user->update($request->all());

        return redirect()->action('UsersController@profile');
    }
}
