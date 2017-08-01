<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class EncounterClinicians extends Migration {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('encounter_clinicians', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();

			$table->integer('user_id')->references('id')->on('users');

			$table->integer('encounter_id')->references('id')->on('encounters');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('encounter_clinicians');
	}

}