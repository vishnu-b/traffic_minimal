<?php

class PanicRegisterController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$panicNumbers = PanicNumber::all();

		return Response::json($panicNumbers, 200);
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
		$panicNumbers = new PanicNumber;
		$username = Input::get('username');
		$numbers = explode(',', Input::get('numbers'));

		$panicNumbers->username = $username;
		
		for ($i=0; $i < sizeof($numbers) ; $i++) { 
			$fieldName = 'panic_number_'.($i+1);
			echo $fieldName;
			$panicNumbers->$fieldName = $numbers[$i];
		}

		$panicNumbers->save();

		return Response::json(array(
			'status' => 'success'
			)
			, 200);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$panicNumbers = PanicNumber::where('username', '=', $id)->get();

		return Response::json($panicNumbers, 200);
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
