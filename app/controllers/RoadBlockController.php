<?php

class RoadBlockController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$roadblocks = RoadBlock::all();
		return Response::json($roadblocks, 200);
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
		$imageurl = '';
		if(Request::get('image')!='')
		{
			$imageurl = "public/images/report/trafficjam_".time().".jpg";
			$base = Request::get('image');
			$binary = base64_decode($base);
	    	$ifp = fopen( $imageurl, "wb" ); 
    		fwrite( $ifp, $binary); 
    		fclose( $ifp ); 
    		$imageurl = 'http://125.62.200.54/traffic/' . $imageurl;
    	}

		$roadblock = RoadBlock::create(array(
			'user'		=> Request::get('user'),
			'latitude' 	=> Request::get('lat'),
			'longitude'	=> Request::get('lng'),
			'time'		=> date('g:iA', time()),
			'date'		=> date('M j', time()),
			'status'	=> Request::get('status'),
			'reason'	=> Request::get('reason'),
			'image_url'	=> $imageurl
			));

		$report = new Report;
		$report->user = Request::get('user');
		$report->latitude = Request::get('lat');
		$report->longitude = Request::get('lng');
		$report->time = date('g:i A', time());
		$report->date = date('M j', time());
		$report->description = "The road is blocked at " . RestApi::getaddress(Request::get('lat'), Request::get('lng')) . " due to " . Request::get('reason');
		$report->image_url = $imageurl;
		$report->type = 'Road Block';
		$report->title = RestApi::getaddress(Request::get('lat'), Request::get('lng'));
		$report->save();

		return RestApi::sendNotification('RB', Request::get('lat'), Request::get('lng'), RestApi::getaddress(Request::get('lat'), Request::get('lng')), '12');
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
