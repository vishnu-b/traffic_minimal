<?php

class TrackIdController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$track_id = TrackId::orderBy('created_at', 'DESC')->get(array('track_id'));
		foreach ($track_id as $key) {
			if(is_numeric($key->track_id))
			{
				$key->track_id+= 1;
				$track = new TrackId;
				$track->track_id = $key->track_id;
				$track->save();
				return $key;
			}

		}

		

		//return $track_id;
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
		$track = new TrackId;

		$track->track_id = Request::get('track_id');

		$track->save();
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
