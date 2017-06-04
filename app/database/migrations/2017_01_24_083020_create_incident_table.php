<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncidentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('incident', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('userID')->unsigned();
            $table->dateTime('incidentDT')->default(date("Y-m-d H:i:s"));
            $table->string('state', 100);
            $table->string('city', 100);
            $table->integer('postcode')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('desc', 255)->nullable();
            $table->string('type', 100);
            $table->string('img', 255)->nullable();
			
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
		Schema::drop('incident');
	}

}
