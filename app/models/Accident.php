<?php

class Accident extends Eloquent {

	protected $fillable = array('user', 'latitude', 'longitude', 'date', 'time', 'details', 'image_url');
	protected $table = 'accidents';

	public function report()
	{
		return $this->hasOne('Report');
	}
}