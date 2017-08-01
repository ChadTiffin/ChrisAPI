<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateLogEntries extends Migration {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('log_entries', function($table) {
			$table->increments('id');
			
			$table->text('message')->nullable(); //extra data, mdl id, route function, etc

			$table->text('extra')->nullable(); //mdl id, route parameters, any form of extra data..
			
			$table->text('differences')->nullable();

			$table->integer('log_type')->unsigned();

			$table->text('ip_address');

			$table->integer('user_id')->unsigned()->nullable();
			$table->foreign('user_id')->references('id')->on('users');

			$table->integer('patient_id')->unsigned()->nullable();

			$table->timestamps();
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('log_entries');
	}

}