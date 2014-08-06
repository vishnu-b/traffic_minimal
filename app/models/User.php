<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public static $rules = array('username' => 'required|unique:users',
								 'email' => 'required|unique:users',
								 'mobile' => 'required|unique:users'
								 );

	public static $messages = array('username.unique' => 'Username already exists. Try another one.',
								    'email.unique' => 'Email already registered. Try with different one.',
								    'mobile.unique' => 'A user has already registered with this number.');

	// change password rules

	public static $changePasswordRules = array('username' => 'required',
								 'password' => 'required',
								 'new_password' => 'required|min:6'
								 );

	public static $changePasswordMessages = array('username.required' => 'Username field is missing',
												  'password.required' => 'Password field is required',
												  'new_password.required' => 'New password field is required',
												  'new_password.min' => 'Minimum 6 characters required for new password'
												   );
	public static $changeMobileRules = array('username' => 'required',
								 'password' => 'required',
								 'mobile' => 'required|min:10',
								 'new_mobile' => 'required|min:10'
								 );

	public static $changeMobileMessages = array('username.required' => 'Username field is missing',
												  'password.required' => 'Password field is required',
												  'mobile.required' => 'Old mobile number is required',
												  'new_mobile.required' => 'New mobile number is required',
												  'new_mobile.min' => 'Enter valid mobile number'
												   );

	public function device()
	{
		return $this->belongsToMany('RegisteredDevice');
	}

}
