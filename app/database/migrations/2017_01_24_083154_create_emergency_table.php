<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmergencyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('emergency', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('userID')->unsigned();
            $table->string('name', 255);
			$table->string('email', 100);
			$table->integer('hpnum');
			
            $table->timestamps();

            $table->foreign('userID')->references('id')->on('users');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('emergency');
	}

}
