<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrafficjamsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('traffic_jams', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('user');
			$table->string('latitude');
			$table->string('longitude');
			$table->string('status');
			$table->string('image_url');
			$table->timestamp('clear_by');
			$table->string('reason');
			$table->string('date');
			$table->string('time');
			//$table->string('');
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
		Schema::drop('traffic_jams');
	}

}
