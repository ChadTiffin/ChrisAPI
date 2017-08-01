<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateFilesTable extends Migration {

	/*
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('files', function($table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();

			$table->integer('patient_id')->unsigned();
			$table->foreign('patient_id')->references('id')->on('patients');
			
			$table->integer('referral_id')->unsigned()->nullable();
			$table->foreign('referral_id')->references('id')->on('referrals');
			
			$table->integer('encounter_id')->unsigned()->nullable();
			$table->foreign('encounter_id')->references('id')->on('encounters');
			$table->integer("viewset_id")->nullable();

			$table->string('name');
			$table->string('display_name');
			$table->string('type')->nullable();
			$table->text('description')->nullable();

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
		Schema::drop('files');
	}

}
