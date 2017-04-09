<?php

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
Route::group(['prefix' => 'profile'], function() {
	Route::get('/', 'UsersController@profile');
	Route::get('/edit', 'UsersController@edit');
	Route::put('/', 'UsersController@update');
});

Route::resource('organizations', 'OrganizationsController');

Route::group(['prefix' => 'projects'], function() {
	Route::post('/complete', 'ProjectsController@complete');
});
Route::resource('projects', 'ProjectsController');

Route::group(['prefix' => 'work_sessions'], function() {
	Route::get('/start', 'WorkSessionsController@create');
	Route::get('/active', 'WorkSessionsController@active');
	Route::post('/end', 'WorkSessionsController@end');
	Route::get('/past', 'WorkSessionsController@past');
	Route::get('/report', 'WorkSessionsController@report');
	Route::get('/summary', 'WorkSessionsController@summary');
});
Route::resource('work_sessions', 'WorkSessionsController', ['except' => [
	'create'
]]);

// admin section
Route::get('admin', 'AdminController@index');
Route::get('admin/activate/{user}', 'AdminController@activateUser');
Route::get('admin/deactivate/{user}', 'AdminController@deactivateUser');

Route::get('/unauthorized', function() {
	return view('errors.404');
});