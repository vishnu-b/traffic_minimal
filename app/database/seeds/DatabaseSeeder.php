<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		$this->call('ReportsTableSeeder');
	}

}

class ReportsTableSeeder extends Seeder {
 
    public function run()
    {
        DB::table('reports')->delete();
 
        Report::create(array(
            'user' => 'police',
            'date' => 'May 24',
            'time' => '11:58 AM',
            'type' => 'Accident',
            'title' => 'Heavy Traffic Jam at Paradise',
            'description' => 'A heavy traffic jam has been created at paradise circle due to some accident.',
            'image_url' =>'lerablog.org/wp-content/uploads/2013/08/lorry-accident-1024x680.jpg'
        ));
 
        Report::create(array(
            'user' => 'user',
            'date' => 'May 28',
            'time' => '12:54 PM',
            'type' => 'Road Block',
            'title' => 'Ecil Bus Depot',
            'description' => 'Near ECIL Bus depot minor delays are possible due to roadwork. Expect frequent roadblocks till 6 PM',
            'image_url' =>'http://frylake.com/wp-content/uploads/2008/07/road-work-july-2008-008.jpg'
        ));
 		
 		Report::create(array(
            'user' => 'user',
            'date' => 'May 29',
            'time' => '1:40 PM',
            'type' => 'Traffic Jam',
            'title' => 'Safilguda Gate',
            'description' => 'Near Safilguda railway gate there is a heavy traffic jam. Expect slow moving traffic till 2:10 PM',
            'image_url' =>'http://frylake.com/wp-content/uploads/2008/07/road-work-july-2008-008.jpg'
        ));
 
    }
 
}
