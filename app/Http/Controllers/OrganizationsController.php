<?php

namespace App\Http\Controllers;

use Auth;
use App\Organization;
use App\Http\Requests\OrganizationRequest;

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

    public function show(Organization $organization)
    {
        return view('organizations.show', compact('organization'));
    }

    public function edit(Organization $organization)
    {
        return view('organizations.edit', compact('organization'));
    }

    public function update(Organization $organization, OrganizationRequest $request)
    {
        $organization->update($request->all());

        return redirect()->action('OrganizationsController@show', $organization->id);
    }

    public function create()
    {
    	return view('organizations.create');
    }

    public function store(OrganizationRequest $request)
    {
        Auth::user()->organizations()->create($request->all());

        return redirect()->action('OrganizationsController@index');
    }
}
