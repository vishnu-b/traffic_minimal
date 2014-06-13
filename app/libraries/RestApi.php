<?php 

class RestApi {

	public static function sendNotification($flag, $lat, $lng, $address, $ctime, $registrationIDs) {
		$api_key = "AIzaSyBH2OD9dUrh9yoYSowf_Fi5b2619AnJsbs";
       	$message = array("flag" => $flag, "lat" => $lat, "lng" => $lng, "address" => $address, "ctime" => $ctime);
		$url = 'https://android.googleapis.com/gcm/send';
		$fields = array(
                	'registration_ids'  => $registrationIDs,
               	 	'data'              => array( "message" => $message ),
                );

		$headers = array(
					'Authorization: key=' . $api_key,
					'Content-Type: application/json');
					
					
					
		$ch = curl_init();
		//echo $ch;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch);
		//echo $result;
		curl_close($ch);
	}

	public static function getaddress($lat, $lng)
	{
		$url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($lng).'&sensor=false';
		$json = @file_get_contents($url);
		$data=json_decode($json);
		$status = $data->status;
		$address ='';
		if($status=="OK")
		{
			$result = $data->results[0]->address_components;
			//print_r($result);
			foreach( $result as $value){
				if($value->types[0] == 'route')
					$address .= $value->long_name . ', ';
				else if($value->types[0] == 'locality')
					$address .= $value->long_name . ', ';
				else if($value->types[0] == 'administrative_area_level_2')
					$address .= $value->long_name;
			}	
			return $address;
		}
		else
			return false;
	}	

	public static function clearBy($status)
	{
		switch($status)
		{
			case 'heavy' : 
				return date('Y-m-d H:i:s', time()+1200);
				break;
			case 'moderate' :
				return date('Y-m-d H:i:s', time()+600);
				break;
			case 'low': 
				return date('Y-m-d H:i:s', time()+3);
				break;
			case 'default':
				return date('Y-m-d H:i:s', time());
		}
	}
}