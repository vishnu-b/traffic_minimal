<?php

class DeviceRegisterController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$regDevices= RegisteredDevice::all();
		return Response::json($regDevices, 200);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{	
		$device_id = Request::get('device_id');
		$device = RegisteredDevice::where('device_id', '=', $device_id)->first();
		if($device)
		{
			$device->reg_id = Request::get('reg_id');;
		}
		else
		{
			$device = new RegisteredDevice;
			$device->device_id = $device_id;
			$device->reg_id = Request::get('reg_id');
		}
		
		$device->save();

		return Response::json(array(
			'error' => false),
			200
		);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
