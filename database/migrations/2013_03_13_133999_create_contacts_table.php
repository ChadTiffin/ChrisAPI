<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateContactsTable extends Migration {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contacts', function($table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			
			$table->integer('patient_id')->unsigned();
			$table->foreign('patient_id')->references('id')->on('patients');

			$table->string('name')->nullable();
			$table->string('gender')->nullable();
			$table->string('address')->nullable();
			$table->string('telephone')->nullable();
			$table->string('email')->nullable();
			$table->string('frequency_of_contact')->nullable();
			$table->string('relationship')->nullable();
			$table->boolean('primary_caregiver')->nullable();
			$table->boolean('deceased')->nullable();
			$table->integer('year_deceased')->nullable();

			$table->boolean('consent_to_speak')->default(0);
			$table->boolean('power_of_attorney_property')->default(0);
			$table->boolean('power_of_attorney_personal_care')->default(0);

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
		Schema::drop('contacts');
	}

	public function get_comments() {
		return array(
			'contacts' => array('Information regarding a subject\'s personal contacts including caregivers and family members', array(
					'name' => 'The full name of the contact',
					'gender' => 'The gender of the contact. 0=male,1=female,2=other',
					'telephone' => 'The telephone number of the contact',
					'email' => 'The email address of the contact',
					'address' => 'Full address for the contact',
					'frequency_of_contact' => 'The frequency in which the subject and contact interact with one another',
					'relationship' => 'The family relationship between subject and contact',
					'primary_caregiver' => 'Is the contact the subject\'s primary caregiver? 0=no, 1=yes',
					'deceased' => 'Is the contact deceased? 0=no, 1=yes',
					'year_deceased' => 'The year the contact became deceased',
					'consent_to_speak' => 'Do staff have consent to speak with this person about medical information? 0=no, 1=yes',
					'power_of_attorney_property' => 'Does the contact have Power of Attorney for the subject\'s property? 0=no, 1=yes',
					'power_of_attorney_personal_care' => 'Does the contact have Power of Attorney for the subject\'s personal care? 0=no, 1=yes'
				))
			);
	}


}
