<?php

class AccidentController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	//find the address of the latitude and longitude value
	public function index()
	{
		$accidents = Report::where('type', 'Accident')->get();
		return Response::json($accidents, 200);
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
			$imageurl = "/images/report/accident_".time().".jpg";
			$base = Request::get('image');
			$binary = base64_decode($base);
	    	$ifp = fopen( $imageurl, "wb" ); 
    		fwrite( $ifp, $binary); 
    		fclose( $ifp ); 
    		$imageurl = 'http://125.62.200.54/traffic/' . $imageurl;
    	}

    	$accident = Accident::create(array(
    		'user'		=> Request::get('user'),
    		'latitude'	=> Request::get('lat'),
    		'longitude'	=> Request::get('lng'),
    		'time'		=> date('g:i A', time()),
    		'date'		=> date('M j', time()),
    		'details'	=> Request::get('details'),
    		'image_url' => $imageurl
    		));

		$report = new Report;
		$report->traffic_jam_id = $accident->id;
		$report->user = Request::get('user');
		$report->latitude = Request::get('lat');
		$report->longitude = Request::get('lng');
		$report->time = date('g:i A', time());
		$report->date = date('M j', time());
		$report->description = "There has been an accident. " . Request::get('details');
		$report->image_url = 'http://125.62.200.54/traffic/' . $imageurl;
		$report->type = 'Accident';
		$report->title = 'Test Value';//RestApi::getaddress(Request::get('lat'), Request::get('lng'));
		$report->save();

		//RestApi::sendNotification()

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
