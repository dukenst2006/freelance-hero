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

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::resource('organizations', 'OrganizationsController');
Route::resource('projects', 'ProjectsController');
Route::get('work_sessions/start', 'WorkSessionsController@create');
Route::get('work_sessions/active', 'WorkSessionsController@active');
Route::post('work_sessions', 'WorkSessionsController@store');
Route::post('work_sessions/end', 'WorkSessionsController@end');