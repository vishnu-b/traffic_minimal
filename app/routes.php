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
	$username = Request::get('username');
	$password = Request::get('password');
	$device_id = Request::get('device_id');
	
	$field = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
	
	$user = array(
		$field => $username,
		'password' => $password
		);

	if(Auth::attempt($user)) {
		$device = RegisteredDevice::where('device_id', '=', $device_id)->first();
		$device->user_id = $username;
		$device->save();

		return Response::json(array(
			"status" => 'OK'),
			200
			);
	}

	return Response::json(array(
			"status" => 'FAILED'),
			200);
});

Route::post('api/logout', function() {
	$username = Request::get('username');
	$device_id = Request::get('device_id');

	$device = RegisteredDevice::where('device_id', '=', $device_id)->first();
	$device->user_id = '';
	$device->save();

	return Response::json(array(
			"status" => 'OK'),
			200
			);
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
    Route::resource('register', 'UserController');
    Route::resource('panicregister', 'PanicRegisterController');
});

Route::get('api/trackother/{userid}', 'TrackUserController@trackuser');

Route::post('api/user/changePassword', 'UserController@changePassword');

Route::post('api/user/changeMobileNumber', 'UserController@changeMobileNumber');

Route::post('api/user/forgotPassword', 'UserController@forgotPassword');

Route::get('track', function()
{
	return View::make('pages.track');
});

Route::get('accident', function()
{
	return View::make('pages.accident');
});

Route::get('trafficjam', function()
{
	return View::make('pages.trafficjam');
});

Route::get('restrictedroute', function()
{
	return View::make('pages.restrictedroute');
});