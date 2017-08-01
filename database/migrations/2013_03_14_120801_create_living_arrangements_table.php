<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateLivingArrangementsTable extends Migration {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('living_arrangements', function($table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();

			$table->integer('patient_id')->unsigned();
			$table->foreign('patient_id')->references('id')->on('patients');

			$table->string('address')->nullable();
			$table->string('city')->nullable();
			$table->string('province')->nullable();
			$table->string('country')->nullable();
			$table->string('postal_code_first3')->nullable();
			$table->string('postal_code_last3')->nullable();
			$table->string('dwelling_type')->nullable();
			$table->string('telephone')->nullable();
			$table->string('email')->nullable();
			$table->date('moved_in')->nullable();
			$table->date('moved_out')->nullable();
						
			$table->boolean('current_arrangement')->default('0');
			$table->boolean('interior_stairs');
			$table->boolean('exterior_stairs');
			
			$table->integer('modified_by')->unsigned()->nullable();
			$table->foreign('modified_by')->references('id')->on('users');
			$table->integer('created_by')->unsigned()->nullable(); 
			$table->foreign('created_by')->references('id')->on('users');
			$table->timestamp('deleted_at')->nullable();
			$table->timestamps();
			
		});

		Schema::create('living_arrangements_contacts', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();

			$table->integer('contact_id')->unsigned();
			$table->foreign('contact_id')->references('id')->on('contacts');

			$table->integer('living_arrangement_id')->unsigned();
			$table->foreign('living_arrangement_id')->references('id')->on('living_arrangements');

			
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
		Schema::drop('living_arrangements');
		Schema::drop('living_arrangements_contacts');
	}
	public function get_comments() {
		return array(
			'living_arrangements' => array('Details on where the subject patient lives or has lived in the past', array(
					'address' => 'The address of the dwelling in which the subject lived',
					'city' => 'The city in which the subject lived',
					'province' => 'The province in which the subject lived',
					'country' => 'The country in which the subject lived',
					'postal_code_first3' => 'The first three characters of the subject\'s postal code',
					'postal_code_last3' => 'The last three characters of the subject\'s postal code',
					'dwelling_type' => 'The type of dwelling in which the subject lived',
					'telephone' => 'Telephone number of the subject when living at this dwelling',
					'email' => 'Email address of the subject',
					'moved_in' => 'Date in which the subject moved into the dwelling',
					'moved_out' => 'Date in which the subject moved out of the dwelling',
					'current_arrangement' => 'Indicates whether or not the subject currently lives at the dwelling'

				))
			);
	}
}
