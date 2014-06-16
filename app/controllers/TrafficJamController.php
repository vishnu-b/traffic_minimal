<?php

class TrafficJamController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$trafficjams = TrafficJam::where('clear_by', '>=', date('Y-m-d H:i:s', time()))->get();
		return Response::json($trafficjams, 200);
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
		$imageurl = "public/images/report/trafficjam_".time().".jpg";
		$base = Request::get('image');
		$binary = base64_decode($base);
	    $ifp = fopen( $imageurl, "wb" ); 
    	fwrite( $ifp, $binary); 
    	fclose( $ifp ); 

		$trafficJam = TrafficJam::create(array(
			'user'		=> Request::get('user'),
			'latitude' 	=> Request::get('lat'),
			'longitude'	=> Request::get('lng'),
			'clear_by'	=> RestApi::clearBy(Request::get('status')),
			'time'		=> date('g:iA', time()),
			'date'		=> date('M j', time()),
			'status'	=> Request::get('status'),
			'reason'	=> Request::get('reason'),
			'image_url'	=> 'http://1.22.136.51/traffic/' . $imageurl
			));

		$report = new Report;
		$report->traffic_jam_id = $trafficJam->id;
		$report->user = Request::get('user');
		$report->latitude = Request::get('lat');
		$report->longitude = Request::get('lng');
		$report->time = date('g:i A', time());
		$report->date = date('M j', time());
		$report->description = 'Test Value';//"There is a " . Request::get('status') . " traffic jam at " . RestApi::getaddress(Request::get('lat'), Request::get('lng')) . " due to " . Request::get('reason');
		$report->image_url = 'http://1.22.136.51/traffic/' . $imageurl;
		$report->type = 'Traffic Jam';
		$report->title = 'Test Value';//RestApi::getaddress(Request::get('lat'), Request::get('lng'));
		$report->save();

		return RestApi::sendNotification('TJ', Request::get('lat'), Request::get('lng'), RestApi::getaddress(Request::get('lat'), Request::get('lng')), '12', array('APA91bGonBsBR3pwpwCxAa8dFHcHnU2jFIqjXaFkiEHkayRSFdxwXVSJJl7L9aZA2bdJH7WkspDMzPeBTMd4hQtFuJs5KOxFPg0mBzHddJQfp_tLFacmPcimObnYT66GVzojIb6rfCUeknwTup99XHEDtHbmA-QOFLxVWs3Q_p1hAAaPSSKApgri2U1OvIFmpijUdXS6OgwA') );

		/*return Response::json(array(
			'error' => false),
			200
		);
*/
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
