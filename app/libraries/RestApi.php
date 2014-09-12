<?php

class RestApi {

    public static function sendNotification($flag, $valueArray){
        $api_key = "AIzaSyBH2OD9dUrh9yoYSowf_Fi5b2619AnJsbs";
        $regIdArray = [];
        $message = [];

        $url = "https://android.googleapis.com/gcm/send";

        switch($flag) {
            case 'TR':
                $tracker_name = $valueArray[0];
                $track_id = $valueArray[1];

                $username = TrackId::where('track_id', '=', $track_id)->first();

                $registrationIDs = RegisteredDevice::where('username', '=', $tracker_name)->get();
                $message = array("flag" => "TR", "user" => $username->username);

                foreach ($registrationIDs as $regId) {
                    array_push($regIdArray, $regId->reg_id);
                }

                break;

            case 'TJ':
                $lat = $valueArray[0];
                $lng = $valueArray[1];
                $address = self::getaddress($lat, $lng);
                $ctime = $valueArray[2];

                $registrationIDs = RegisteredDevice::all(array('reg_id'));
                $message = array("flag" => 'TJ', "lat" => $lat, "lng" => $lng, "address" => $address, "ctime" => $ctime);

                foreach ($registrationIDs as $regId) {
                    array_push($regIdArray, $regId->reg_id);
                }

                break;
            case 'ST':
                $tracker_name = $valueArray[0];
                $track_id = $valueArray[1];

                $registrationIDs = RegisteredDevice::where('username', '=', $tracker_name)->get();
                $message = array("flag" => "ST", "user" => $track_id);

                foreach ($registrationIDs as $regId) {
                    array_push($regIdArray, $regId->reg_id);
                }

                break;
        }
        print_r($regIdArray);
        print_r($message);

        $fields = array(
                    'registration_ids'  => $regIdArray,
                    'data'              => array( "message" => $message ),
                );

        $headers = array(
                    'Authorization: key=' . $api_key,
                    'Content-Type: application/json');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch);
        return $result;
        curl_close($ch);
    }
/*
    public static function sendNotification($flag, $lat, $lng, $address, $ctime) {
        $api_key = "AIzaSyBH2OD9dUrh9yoYSowf_Fi5b2619AnJsbs";
        $regIdArray = [];

        $url = 'https://android.googleapis.com/gcm/send';
        $registrationIDs = RegisteredDevice::all(array('reg_id'));
        $message = array("flag" => $flag, "lat" => $lat, "lng" => $lng, "address" => $address, "ctime" => $ctime);

        foreach ($registrationIDs as $regId) {
            array_push($regIdArray, $regId->reg_id);
        }
        $fields = array(
                    'registration_ids'  => $regIdArray,
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
        return $result;
        curl_close($ch);
    }
*/
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
