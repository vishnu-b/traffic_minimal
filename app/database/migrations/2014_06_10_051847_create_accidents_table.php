<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccidentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('accidents', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('user');
			$table->string('latitude');
			$table->string('longitude');
			$table->string('time');
			$table->string('date');
			$table->string('details');
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
		Schema::drop('accidents');
	}

}
