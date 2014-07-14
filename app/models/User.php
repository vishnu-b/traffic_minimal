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

}
