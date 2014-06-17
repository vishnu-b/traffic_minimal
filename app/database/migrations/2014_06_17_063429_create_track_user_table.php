<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('track_user', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('app_id', 20);
			$table->string('latitude', 20);
			$table->string('longitude', 20);
			$table->string('status', 2);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('track_user');
	}

}
