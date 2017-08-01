<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreatePatientResearchTrials extends Migration {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('patient_research_trials', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();

			$table->integer('patient_id')->unsigned();
			$table->foreign('patient_id')->references('id')->on('patients');

			$table->integer('research_trial_id')->unsigned();
			$table->foreign('research_trial_id')->references('id')->on('research_trials');

			$table->integer('study_unique_id')->nullable();
			$table->date('start_date')->nullable();
			$table->date('end_date')->nullable();

			$table->integer('modified_by')->unsigned()->nullable();
			$table->foreign('modified_by')->references('id')->on('users');
			$table->integer('created_by')->unsigned()->nullable();
			$table->foreign('created_by')->references('id')->on('users');

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
		Schema::drop('patient_research_trials');
	}

}
