<?php

class TrackAssignController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$tracker_ids = Request::get('tracker_ids') ;
		$tracker_id = explode(',', $tracker_ids);
		foreach ($tracker_id as $id)
		{
			$assign = new TrackAssign;
			$assign->user_id = Request::get('user_id');
			$assign->tracker_id = $id;
			$assign->status = 1;
			$assign->save();
		}
		/*
		$assign = new TrackAssign;
		$assign->user_id = Request::get('userid');
		$assign->tracker_id = Request::get('tracker_ids');
		$assign->status = 1;*/

		return Response::json($tracker_id);
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
