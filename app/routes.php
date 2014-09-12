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

/*Route::post('api/logout', function() {
	$username = Request::get('username');
	$device_id = Request::get('device_id');

	$device = RegisteredDevice::where('device_id', '=', $device_id)->first();
	$device->user_id = '';
	$device->save();

	return Response::json(array(
			"status" => 'OK'),
			200
			);
});*/

Route::group(array('prefix' => 'api'), function()
{
    /*Route::resource('report', 'ReportController');
    Route::resource('accident', 'AccidentController');*/
    Route::resource('trafficjam', 'TrafficJamController');
    Route::resource('registerdevice', 'DeviceRegisterController');
   /* Route::resource('trackuser', 'TrackUserController');
    Route::resource('trackid', 'TrackIdController');
    Route::resource('trackassign', 'TrackAssignController');
    Route::resource('register', 'UserController');
    Route::resource('panicregister', 'PanicRegisterController');
    Route::resource('roadblock', 'RoadBlockController');*/
    Route::resource('users', 'UserController');
    Route::get('users/verify/{confirmation_code}', 'UserController@verify');
    Route::post('users/login', 'UserController@login');
    Route::resource('track', 'TrackUserController');
    Route::post('track/start', 'TrackUserController@start');
    Route::post('track/stop', 'TrackUserController@stop');
    Route::get('trackother/{tracker_id}', 'TrackUserController@trackother');
});

/*Route::get('api/trackother/{userid}', 'TrackUserController@trackuser');

Route::post('api/user/changepassword', 'UserController@changePassword');

Route::post('api/user/changemobilenumber', 'UserController@changeMobileNumber');

Route::post('api/user/forgotpassword', 'UserController@forgotPassword');

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

Route::get('roadblock', function()
{
	return View::make('pages.roadblock');
});*/
