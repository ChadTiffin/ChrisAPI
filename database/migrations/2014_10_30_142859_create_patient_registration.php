<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientRegistration extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('patient_registration', function($table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();

			$table->integer('patient_id')->unsigned()->nullable();
			$table->foreign('patient_id')->references('id')->on('patients');

			$table->integer('clinic_id')->unsigned()->nullable();
			$table->foreign('clinic_id')->references('id')->on('clinics');

			$table->date('start')->nullable();
			$table->date('end')->nullable();

			$table->text('description')->nullable();


			$table->integer('created_by')->unsigned()->nullable();
			$table->foreign('created_by')->references('id')->on('users');
			$table->integer('modified_by')->unsigned()->nullable();
			$table->foreign('modified_by')->unsigned()->references('id')->on('users');
			$table->timestamps();
			$table->timestamp('deleted_at')->nullable();
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('patient_registration');
	}

	public function get_comments() {
		return array(
			'patient_registration' => array('contains patient/subject demographic data', array())
			);
	}
}
