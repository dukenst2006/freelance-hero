<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganizationRequest;
use App\Http\Requests;
use App\Organization;
use Auth;

class OrganizationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$organizations = Organization::where(['user_id' => Auth::user()->id])->get();
    	return view('organizations.index', compact('organizations'));
    }

    public function create()
    {
    	return view('organizations.create');
    }

    public function store(OrganizationRequest $request)
    {
    	$data = $request->all();
    	$data['user_id'] = Auth::user()->id;
    	Organization::create($data);

        return redirect()->action('OrganizationsController@index');
    }
}
