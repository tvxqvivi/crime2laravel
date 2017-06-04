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
            $table->dateTime('reminderDT')->default(date("Y-m-d H:i:s"));
            $table->string('receiver');
            $table->string('message', 255);
            $table->boolean('now');
            $table->boolean('schedule');
            $table->timestamps();
            $table->foreign('userID')->references('id')->on('users')->onDelete('cascade');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
