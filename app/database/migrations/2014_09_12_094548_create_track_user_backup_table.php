<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackUserBackupTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('track_user_backup', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('track_id', 20);
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
		Schema::drop('track_user_backup');
	}

}
