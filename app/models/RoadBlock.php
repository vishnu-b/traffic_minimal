<?php

class RoadBlock extends Eloquent {
	protected $fillable = array('user', 'latitude', 'longitude', 'image_url', 'reason', 'date', 'time');
	protected $table = 'road_blocks';

	public function report() {
		$this->hasOne('Report');
	}
}