<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Redis;

class AdminController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
    	$users = User::all();

        // get each users last_seen date/time from redis
        $last_seen_times = array();
        foreach ($users as $user) {
            $last_seen = Redis::get('users.' . $user->id . '.last_seen');
            $last_seen_times[$user->id] = $last_seen;
        }

        return view('admin.index', compact('users', 'last_seen_times'));
    }

    public function activateUser(User $user)
    {
        $user->activate();
        return redirect()->action('AdminController@index');
    }

    public function deactivateUser(User $user)
    {
        $user->deactivate();
        return redirect()->action('AdminController@index');
    }
}
