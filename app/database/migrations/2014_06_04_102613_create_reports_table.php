<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reports', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('traffic_jam_id');
			$table->string('user');
			$table->string('latitude');
			$table->string('longitude');
			$table->string('date');
			$table->string('time');
			$table->timestamp('clear_by');
			$table->string('type');
			$table->string('title');
			$table->string('description');
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
		Schema::drop('reports');
	}

}
