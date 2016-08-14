<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
    	$users = User::all();
    	return view('admin.index', compact('users'));
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
