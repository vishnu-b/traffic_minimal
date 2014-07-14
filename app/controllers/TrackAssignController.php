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
		$usernameArray = [];

		foreach ($tracker_id as $id)
		{
			if(trim($id) != 'null')
			{
				$username = null;
				if(is_numeric($id)){
					$user = User::where('mobile','=', $id)->get(array('username'));
					foreach ($user as $name)
					{
						$username = $name->username;
						array_push($usernameArray, $username);
					}
				}
				
				$validate = TrackAssign::where('user_id', '=', Request::get('user_id'))->where('tracker_id', '=', $username)->first();
				if($username != null)
				{
					if($validate == null)
					{	$assign = new TrackAssign;
						$assign->user_id = Request::get('user_id');
						$assign->tracker_id = $username;
						$assign->status = 1;
						$assign->save();
					}
					else
					{
						$validate->status = 1;
						$validate->save();
					}
				}	
			}	
		}
		return Response::json(array(
				"status" => "OK",
				"users" => $usernameArray),
				200);
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
