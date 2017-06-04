<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 255);
			$table->string('email', 100)->unique();
			$table->string('password', 100);
			$table->string('ic', 30)->unique();
			$table->string('gender');
			$table->string('hpnum', 30);
			$table->string('address', 255);
			$table->string('img', 255)->nullable();
			$table->string('emerText', 255);
			$table->rememberToken();

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
		Schema::drop('users');
	}

}
