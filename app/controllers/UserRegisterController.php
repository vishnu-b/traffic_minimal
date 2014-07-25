<?php

class UserRegisterController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::all();
		return Response::json(array($users), 200);
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
		$username = Input::get('username');
		$password = Hash::make(Input::get('password'));
		$email = Input::get('email');
		$mobile = Input::get('mobile');

		$validation = Validator::make(Input::all(), User::$rules, User::$messages);

		if($validation->passes()){
			$user = new User;
			$user->username = $username;
			$user->password = $password;
			$user->email = $email;
			$user->mobile = $mobile;
			$user->save();

			return Response::json(array(
				'status' => 'OK',
				'user' => $user
			), 200);
		}	
		return Response::json(array(
				'status' => 'FAILED',
				'errors' =>array(
					'username' => $validation->messages()->first('username'),
					'email' => $validation->messages()->first('email'),
					'mobile' => $validation->messages()->first('mobile'))

				));
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
