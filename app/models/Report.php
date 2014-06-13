<?php

class Report extends Eloquent {

	protected $table = 'reports' ;

	public function accident()
	{
		return $this->belongsTo('Report');
	}

	public function trafficjam()
	{
		return $this->belongsTo('Report');
	}

}