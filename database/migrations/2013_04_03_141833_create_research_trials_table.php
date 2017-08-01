<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateResearchTrialsTable extends Migration {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('research_trials', function($table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			
			$table->string('study_ethics_number')->nullable();
			$table->string('study_short_name')->nullable();
			$table->string('study_coordinator')->nullable();
			$table->string('study_category')->nullable();
			$table->text('study_population')->nullable();
			$table->integer('study_mmse')->nullable();
			$table->integer('study_lp')->nullable();
			$table->integer('study_pet')->nullable();
			$table->integer('study_mri')->nullable();
			$table->string('study_length')->nullable();
			$table->string('study_description')->nullable();
			$table->boolean('study_active')->nullable();
			
			$table->integer('modified_by')->unsigned()->nullable();
			$table->foreign('modified_by')->references('id')->on('users');
			$table->integer('created_by')->unsigned()->nullable();
			$table->foreign('created_by')->references('id')->on('users');
			$table->timestamp('deleted_at')->nullable();
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
		Schema::drop('research_trials');
	}

}
