<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreatePatientReports extends Migration {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('patient_reports', function($table) {
			$table->increments('id');

			$table->string('name');
			$table->string('code', 4294967196);

			$table->integer('patient_id')->unsigned();
			$table->foreign('patient_id')->references('id')->on('patients');

			$table->integer('encounter_id')->unsigned()->nullable();
			//$table->foreign('encounter_id')->references('id')->on('encounters');
			

			$table->integer('created_by')->unsigned()->nullable();
			$table->foreign('created_by')->references('id')->on('users');
			$table->integer('modified_by')->unsigned()->nullable();
			$table->foreign('modified_by')->unsigned()->references('id')->on('users');
			$table->timestamps();
			$table->timestamp('deleted_at')->nullable();
			$table->boolean('locked')->nullable();
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('patient_reports');
	}

}
