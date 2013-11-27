<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAlbumsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('albums', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title');
      $table->string('mbid');
      $table->string('artist');
      $table->string('date')->nullable();
      $table->string('type')->nullable();
      $table->string('img_small')->nullable();
      $table->string('img_large')->nullable();
      $table->boolean('img_cached');
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
		Schema::drop('albums');
	}

}
