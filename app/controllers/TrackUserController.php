<?php

class TrackUserController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $track_ids = TrackId::where('status', '=', 1)->get();
        foreach($track_ids as $track_id) {
            $users[] = TrackUser::where('track_id', '=', $track_id->track_id)->orderBy('id', 'DESC')->get();
        }
        return $users;
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
        $user = new TrackUser;
        $user->track_id = Request::get('trackid');
        $user->latitude = Request::get('lat');
        $user->longitude = Request::get('lng');
        $user->status = Request::get('status');
        $user->save();

        return Response::json(array(
            'status' => Request::get('status')),
            200
        );
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $user = TrackUser::where('track_id', '=', $id)->get();
        return Response::json(array($user), 200);
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

    }


    public function trackother($tracker_id)
    {

        $track_names = TrackAssign::where('tracker_id', '=', $tracker_id)->get(array('username'));

        $track_ids = [];

        foreach ($track_names as $track_name) {
            $track_id = TrackId::where("username", $track_name->username)->where("status", 1)->first();
            if($track_id) {
                $track_id = $track_id->track_id;
            }
            $track_ids[] = $track_id;
        }
        if(sizeof($track_ids) > 0) {
            $track_ids = "'" . implode("','", $track_ids) . "'";

            /*
                Query for selecting the last item in for each track_id in track_user table
            */

            $query = "SELECT track_id.username,  t1.* FROM track_id, track_user t1 LEFT JOIN track_user t2  ON (t1.track_id = t2.track_id AND t1.id < t2.id) WHERE t2.id IS NULL AND t1.track_id IN (" . $track_ids . ") AND t1.track_id = track_id.track_id;";

            $track_details = DB::select(DB::raw($query));

            if(!empty($track_details)) {
                return Response::json(array(
                    'status' => 'OK',
                    'details' => $track_details),
                    200
                );
            } else {
                return Response::json(array(
                    'status' => 'FAILED'),
                    200
                );
            }
        } else {
            return Response::json(array(
                'status' => 'FAILED'),
                200
            );
        }

    /*    if(sizeof($track_ids) > 0)
        {   $query = "SELECT * FROM track_user AS t1 WHERE id IN (SELECT MAX(id)  FROM track_user WHERE track_id = t1.track_id) AND track_id IN (";
            $i = 0;
            foreach ($track_ids as $id)
            {
                if ($i++ > 0)
                    $query .= ",";
                $query .= "'" . $id . "'";
            }
            $query .= ")";
            $track_details = DB::select(DB::raw($query));

            for($i = 0; $i < sizeof($track_details); $i++)
            {
                if($track_details[$i]->status == 0)
                    unset($track_details[$i]);
            }
            if(!empty($track_details))
            {
                return Response::json(array(
                'status' => 'OK',
                'details' => $track_details),
                200);
            }
            else
            {
                return Response::json(array(
                    'status' => 'FAILED'),
                    200);
            }

        }
        else
            return Response::json(array(
                'status' => 'FAILED'),
                200);*/

    }

    public function start()
    {
        $username = Request::get('username');
        $user_track_id = uniqid('TR_');
        $trackers = array_filter(explode(',', Request::get('tracker_ids')));

        /* Check if username is alredy in track_id table
        if there, update the track_id field with new one
        else, create a new row with track_id and username
        */

        $track_id = TrackId::where('username', '=', $username)->first();
        if($track_id) {
            $track_id->track_id = $user_track_id;
            $track_id->status = 1;
            $track_id->save();
        } else {
            $track_id = new TrackId;
            $track_id->track_id = $user_track_id;
            $track_id->username = $username;
            $track_id->status = 1;
            $track_id->save();
        }

        /*
            Assign the users to trackers
        */

        foreach($trackers as $tracker) {
            $tracker_name = User::where('mobile', '=', $tracker)->first();
            if ($tracker_name){
                $tracker_assign_name = TrackAssign::where('username', '=', $username)->where('tracker_id', '=', $tracker_name->username)->first();
                if(!$tracker_assign_name) {
                    $tracker_assign = new TrackAssign;
                    $tracker_assign->username = $username;
                    $tracker_assign->tracker_id = $tracker_name->username;
                    $tracker_assign->save();
                }

                /*
                    Send notification to trackers
                */


                $values = array($tracker_name->username, $user_track_id);
                RestApi::sendNotification('TR', $values);
            }
        }




        return Response::json(array(
                              'status' => 'OK',
                              'trackid' => $track_id
                              ));

    }

    public function stop() {
        $track_id = Request::get('trackid');
        $username = TrackId::where('track_id', $track_id)->first();
        $trackers = TrackAssign::where('username', $username->username)->get(array('tracker_id'));

        foreach($trackers as $tracker) {
            $values = array($tracker->tracker_id, $username->username);
            RestApi::sendNotification('ST', $values);
        }

        $username->status = 0;
        $username->save();

        $query = "INSERT INTO track_user_backup (track_id, latitude, longitude, created_at, updated_at) SELECT track_id, latitude, longitude, created_at, updated_at FROM track_user WHERE track_id = '$track_id'";

        DB::insert(DB::raw($query));

        TrackUser::where('track_id', $track_id)->delete();
    }

}
