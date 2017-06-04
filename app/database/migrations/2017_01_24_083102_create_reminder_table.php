<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReminderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reminder', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('userID')->unsigned();
            $table->integer('emerID')->unsigned();
            $table->dateTime('reminderDT')->default(date("Y-m-d H:i:s"));
			
            $table->timestamps();

            $table->foreign('userID')->references('id')->on('users');
            $table->foreign('emerID')->references('id')->on('emergency');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('reminder');
	}

}
