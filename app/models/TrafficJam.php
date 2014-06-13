<?php

class TrafficJam extends Eloquent {
	
	protected $fillable = array('user', 'latitude', 'longitude', 'status', 'image_url', 'reason', 'date', 'time', 'clear_by');

	protected $table = 'trafficjams';

	public function report()
	{
		return $this->hasOne('Report');
	}
}