<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateEncounterContacts extends Migration {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('encounter_contacts', function($table) {
			$table->engine = 'InnoDB';

			$table->integer('encounter_id')->unsigned();
			$table->foreign('encounter_id')->references('id')->on('encounters');

			$table->integer('contact_id')->unsigned();
			$table->foreign('contact_id')->references('id')->on('contacts');
			
			

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
		Schema::drop('encounter_contacts');
	}

}
