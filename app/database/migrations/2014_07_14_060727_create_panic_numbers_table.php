<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePanicNumbersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('panic_numbers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('username', 70)->unique();
			$table->string('panic_number_1', 10);
			$table->string('panic_number_2', 10);
			$table->string('panic_number_3', 10);
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
		Schema::drop('panic_numbers');
	}

}
