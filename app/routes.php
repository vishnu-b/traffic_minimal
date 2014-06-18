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

Route::group(array('prefix' => 'api'), function()
{
    Route::resource('report', 'ReportController');
    Route::resource('accident', 'AccidentController');
    Route::resource('trafficjam', 'TrafficJamController');
    Route::resource('registerdevice', 'DeviceRegisterController');
    Route::resource('trackuser', 'TrackUserController');
    Route::resource('trackid', 'TrackIdController');
});

Route::get('track', function()
{
	return View::make('pages.track');
});

Route::get('accident', function()
{
	return View::make('pages.accident');
});