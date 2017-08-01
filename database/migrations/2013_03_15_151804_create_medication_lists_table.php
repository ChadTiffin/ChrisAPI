<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateMedicationListsTable extends Migration {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
	
		Schema::create('drug_product', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();

			$table->string('brand_name');
			$table->integer('modified_by')->unsigned()->nullable();
			$table->foreign('modified_by')->references('id')->on('users');
			$table->integer('created_by')->unsigned()->nullable();
			$table->foreign('created_by')->references('id')->on('users');
			$table->timestamps();

		});

		Schema::create('medication_lists', function($table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();

			$table->integer('patient_id')->unsigned();
			$table->foreign('patient_id')->references('id')->on('patients');

			$table->date('initial_list_obtained')->nullable();
			$table->string('initial_list_obtained_by')->nullable();

			$table->boolean('consent')->nullable();
			$table->string('pharmacy')->nullable();
			$table->string('phone_number')->nullable();

			$table->string('medication_allergies')->nullable();
			$table->string('environmental_allergies')->nullable();
			$table->string('food_allergies')->nullable();

			$table->integer('modified_by')->unsigned()->nullable(); 
			$table->foreign('modified_by')->references('id')->on('users');
			$table->integer('created_by')->unsigned()->nullable(); 
			$table->foreign('created_by')->references('id')->on('users');
			$table->timestamp('deleted_at')->nullable();
			$table->timestamps();
		});
		
		Schema::create('patient_medications', function($table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();

			$table->integer('drug_id')->unsigned();
			$table->foreign('drug_id')->references('id')->on('drug_product');

			$table->integer('patient_id')->unsigned();
			$table->foreign('patient_id')->references('id')->on('patients');

			$table->text('med_description')->nullable();
			$table->string('dosage');
			$table->string('frequency');
			
			$table->date('start_date')->nullable();			
			$table->date('end_date')->nullable();
			
			$table->string('start_reason')->nullable();
			$table->string('end_reason')->nullable();

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
		Schema::drop('drug_product');
		Schema::drop('medication_lists');
		Schema::drop('patient_medications');
	}

}
