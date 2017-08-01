<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateEncounterDocumentsTable extends Migration {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('encounter_documents', function($table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();

			$table->integer('encounter_id')->unsigned();
			$table->foreign('encounter_id')->references('id')->on('encounters');
			$table->integer("viewset_id")->nullable();

			$table->integer('patient_file_id')->unsigned();
			$table->foreign('patient_file_id')->references('id')->on('files');

			$table->string('document_type')->nullable();
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('encounter_documents');
	}

}
