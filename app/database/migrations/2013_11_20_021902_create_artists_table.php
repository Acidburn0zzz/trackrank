<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArtistsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('artists', function(Blueprint $table) {
			$table->increments('id');
			$table->string('mbid');
			$table->string('name');
			$table->string('year');
			$table->text('summary');
			$table->string('place');
			$table->string('img_small');
			$table->string('img_medium');
			$table->string('img_large');
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
		Schema::drop('artists');
	}

}
