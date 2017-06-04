<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreventionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('prevention', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title');
			$table->string('subtitle');
			$table->string('desc', 320);
			$table->string('author');
			$table->dateTime('date')->default(date("Y-m-d"));
			$table->string('source');
			$table->string('vidURL', 320)->nullable();

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
		Schema::drop('prevention');
	}

}
