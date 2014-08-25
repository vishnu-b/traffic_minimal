<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoadblocksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('road_blocks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('user');
			$table->string('latitude');
			$table->string('longitude');
			$table->string('time');
			$table->string('date');
			$table->string('status');
			$table->string('reason');
			$table->string('image_url');
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
		Schema::drop('road_blocks');
	}

}
