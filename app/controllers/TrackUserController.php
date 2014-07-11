<?php

class TrackUserController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		/* select all users in track_user table who wants to be tracked
			user who wants to be tracked will have status set as 1
			select by the max(id
		*/
		/*$track_id = TrackUser:: orderBy('created_at', 'DESC')
								->select(DB::raw('*, max(id) as id'))
								->orderBy('id', 'desc')
								->groupBy('track_id')
								->get();

			for($i = 0; $i < sizeof($track_id); $i++)
			{
				if( $track_id[$i]['status'] == 0 )
					unset($track_id[$i]);
			}
		*/
		
		$track_id = DB::select(DB::raw("SELECT t.* FROM track_user t 
										JOIN 
										( SELECT track_id, latitude, longitude, MAX(id) maxId
										  FROM track_user GROUP BY track_id
										) t2
										ON t.id = t2.maxId AND t.track_id = t2.track_id"));
		
		for($i = 0; $i < sizeof($track_id); $i++)
		{
			if($track_id[$i]->status == 0)
				unset($track_id[$i]);

		}
		//print_r($track_id);
		return $track_id;
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
		$user = new TrackUser;
		$user->track_id = Request::get('trackid');
		$user->latitude = Request::get('lat');
		$user->longitude = Request::get('lng');
		$user->status = Request::get('status');
		$user->save();

		return Response::json(array(
			'status' => Request::get('status')),
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
		$user = TrackUser::where('track_id', '=', $id)->get();
		return Response::json(array($user), 200);
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
		
	}


	public function trackuser($user_id)
	{
		$track_ids = TrackAssign::where('tracker_id', '=', $user_id)->get(array('user_id'));

		//$query = "SELECT MAX(id) FROM track_user WHERE track_id IN ('12', 'vishnu')";
		$query = "SELECT * FROM track_user AS t1 WHERE id IN (SELECT MAX(id)  FROM track_user WHERE track_id = t1.track_id) AND track_id IN ('vishnu', 'raj') ";//AND t1.track_id = t2.track_id) GROUP BY t1.id";

		//$query = "SELECT * FROM track_user as t1 WHERE "

		//$query = "SELECT track_id, latitude, longitude, MAX(id), id FROM track_user WHERE ";
		/*$i = 0;
		foreach ($track_ids as $id)
		{
			if ($i++ > 0)
				$query .= " OR ";
			$query .= "t1.track_id = '" . $id['user_id'] . "'";
		}

		//$query .= " GROUP BY id DESC LIMIT ". $i;*/

		$track_details = DB::select(DB::raw($query));
/*
		for($i =0; $i<sizeof($track_details); $i++)
		{
			foreach ($track_ids as $id)
			{
				echo $track_details[$i]->id, $id['user_id'];
				if($track_details[$i]->id == $id['user_id'])
					unset($track_details[$i]);
			}
		}
*/
	//	return Response::json($tracker_ids);
	    return $track_details;
	//	return $query;
	}


}
