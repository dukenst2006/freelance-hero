<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// basic home routes
Route::get('/', function () {
	if ( Auth::guest() ) {
	    return view('welcome');
	} else {
		return redirect('/home');
	}
});
Route::get('/home', 'HomeController@index');
Route::post('/contact', 'HomeController@contact');

// login and registration routes
Route::auth();

// user profile section
Route::get('/profile', 'UsersController@profile');
Route::get('/profile/edit', 'UsersController@edit');
Route::put('/profile', 'UsersController@update');

// organizations section
Route::resource('organizations', 'OrganizationsController');

// projects section
Route::resource('projects', 'ProjectsController');
Route::post('projects/complete', 'ProjectsController@complete');

// work sessions routes. not using a resource
Route::get('work_sessions', 'WorkSessionsController@index');
Route::post('work_sessions', 'WorkSessionsController@store');
Route::get('work_sessions/start', 'WorkSessionsController@create');
Route::get('work_sessions/active', 'WorkSessionsController@active');
Route::post('work_sessions/end', 'WorkSessionsController@end');
Route::get('work_sessions/past', 'WorkSessionsController@past');
Route::get('work_sessions/report', 'WorkSessionsController@report');
Route::get('work_sessions/summary', 'WorkSessionsController@summary');
Route::get('work_sessions/{work_session}', 'WorkSessionsController@show');
Route::put('work_session/{work_session}', 'WorkSessionsController@update');
Route::get('work_sessions/{work_session}/edit', 'WorkSessionsController@edit');
Route::delete('work_sessions/{work_session}', 'WorkSessionsController@destroy');

// admin section
Route::get('admin', 'AdminController@index');
Route::get('admin/activate/{user}', 'AdminController@activateUser');
Route::get('admin/deactivate/{user}', 'AdminController@deactivateUser');

Route::get('/unauthorized', function() {
	return view('errors.404');
});