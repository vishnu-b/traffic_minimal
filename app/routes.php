<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::post('api/login', function() {
	$username = Input::get('username');
	$password = Input::get('password');
	
	$field = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
	
	$user = array(
		$field => $username,
		'password' => $password
		);

	if(Auth::attempt($user)) {
		return Response::json(array(
			"status" => 'OK'),
			200
			);
	}

	return Response::json(array(
			"status" => 'FAILED'),
			200);
});

Route::group(array('prefix' => 'api'), function()
{
    Route::resource('report', 'ReportController');
    Route::resource('accident', 'AccidentController');
    Route::resource('trafficjam', 'TrafficJamController');
    Route::resource('registerdevice', 'DeviceRegisterController');
    Route::resource('trackuser', 'TrackUserController');
    Route::resource('trackid', 'TrackIdController');
    Route::resource('trackassign', 'TrackAssignController');
    Route::resource('register', 'UserRegisterController');
    Route::resource('panicregister', 'PanicRegisterController');
});

Route::get('trackother/{userid}', 'TrackUserController@trackuser');

Route::get('track', function()
{
	return View::make('pages.track');
});

Route::get('accident', function()
{
	return View::make('pages.accident');
});