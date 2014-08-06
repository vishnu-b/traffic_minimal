<?php

class UserController extends \BaseController {

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

	//Change user password

	public function changePassword()
	{
		$username = Request::get('username');
		$password = Request::get('password');
		$new_password = Request::get('new_password');

		$validation = Validator::make(Input::all(), User::$changePasswordRules, User::$changePasswordMessages);
		if($validation->fails())
		{
			return Response::json(array(
				'status' => 'FAILED',
				'errors' =>array(
					'username' => $validation->messages()->first('username'),
					'password' => $validation->messages()->first('password'),
					'new_password' => $validation->messages()->first('new_password'))

				));
		}
		else
		{	
			$field = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
			$user = array(
				$field => $username,
				'password' => $password
				);

			if(Auth::attempt($user)) {
				$user_id = User::where('username', '=', $username)->first();
				$user_id->password = Hash::make($new_password);
				$user_id->save();

				return Response::json(array(
					"status" => 'OK'),
					200
					);	
			}
			else 
			{
				return Response::json(array(
				'status' => 'FAILED',
				'errors' =>array(
					'password' => 'No match found for username and password. Try again.')

				));
			}
		}
	}

	//Change mobile number

	public function changeMobileNUmber()
	{
		$username = Request::get('username');
		$password = Request::get('password');
		$mobile = Request::get('mobile');
		$new_mobile = Request::get('new_mobile');

		$validation = Validator::make(Input::all(), User::$changeMobileRules, User::$changeMobileMessages);
		if($validation->fails())
		{
			return Response::json(array(
				'status' => 'FAILED',
				'errors' =>array(
					'username' => $validation->messages()->first('username'),
					'password' => $validation->messages()->first('password'),
					'mobile' => $validation->messages()->first('mobile'),
					'new_mobile' => $validation->messages()->first('new_mobile'),
					)

				));
		}
		else
		{	
			$field = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
			$user = array(
				$field => $username,
				'password' => $password
				);

			if(Auth::attempt($user)) {
				$user_id = User::where('username', '=', $username)->first();
				$user_id->mobile = $new_mobile;
				$user_id->save();

				return Response::json(array(
					"status" => 'OK'),
					200
					);	
			}
			else 
			{
				return Response::json(array(
				'status' => 'FAILED',
				'errors' =>array(
					'password' => 'No match found for username and password. Try again.')

				));
			}
		}
	}

	//Reset password

	public function forgotPassword()
	{
		$email = 'vishnu.nxg@gmail.com';

		$email_data = array(
        'recipient' => $email,
        'subject' => 'Test Message'
	    );
	    $view_data = array(
	        'new_password' => 'GZ12018',
	    );

	    Mail::send('emails.auth.reminder', $view_data, function($message) use ($email_data) {
	        $message->to( $email_data['recipient'] )
	                ->subject( $email_data['subject'] );
	    });
	}
}
