<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('patients', function($table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();

			$table->integer('family_doctor_id')->unsigned()->nullable();

			$table->string('pin')->nullable()->unique();
			$table->string('last_name')->nullable();
			$table->string('first_name')->nullable();
			$table->string('middle_name')->nullable();
			$table->string('prefix')->nullable();
			$table->date('date_of_birth')->nullable();
			$table->boolean('is_deceased')->nullable();
			$table->date('date_of_death')->nullable();
			$table->string('sex')->nullable();
			$table->string('health_card_number')->nullable()->unique();
			$table->string('health_card_version')->nullable();
			$table->integer('number_of_years_of_education')->nullable();
			$table->string('highest_education_level_completed')->nullable();
			$table->string('marital_status')->nullable();
			$table->string('first_language')->nullable();
			$table->text('additional_language_information')->nullable();
			$table->string('handedness')->nullable();
			$table->boolean('veteran')->nullable();
			$table->string('photo')->nullable();
			$table->string('research_registry_consent')->default('Consent yet to be obtained');

			$table->integer('created_by')->unsigned()->nullable();
			$table->foreign('created_by')->references('id')->on('users');
			$table->integer('modified_by')->unsigned()->nullable();
			$table->foreign('modified_by')->unsigned()->references('id')->on('users');
			$table->timestamps();
			$table->timestamp('deleted_at')->nullable();
			$table->boolean('locked')->nullable();

			//hashed search fields
			$table->string('hash_pin')->nullable();
			$table->string('hash_last_name')->nullable();
			$table->string('hash_first_name')->nullable();
			$table->string('hash_health_card_number')->nullable();

		});
		DB::update("ALTER TABLE patients AUTO_INCREMENT = 655800100;");
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('patients');
	}

	public function get_comments() {
		return array(
			'patients' => array('contains patient/subject demographic data', array(
					'pin' => 'The patient\'s MRN or P-Number. Must be 8 digit number.' ,
					'middle_name' => 'Patient/Subject\'s middle name.',
					'first_name' => 'Patient/Subjects\'s first name',
					'last_name' => 'Patient/Subject\'s last name',
					'prefix' => 'Patient/Subject\'s prefix. ',
					'date_of_birth' => 'Date object',
					'is_deceased' => 'boolean - 0=no, 1=yes',
					'date_of_death' => 'Date object',
					'sex' => '0=Male, 1=Female, 2=Other',
					'health_card_number' => '10 digits',
					'health_card_version'=> '2 leters',
					'number_of_years_of_education' => 'integer in years',
					'highest_education_level_completed' => '0=Primary, 1=Secondary, 2=Post-Secondary, 3=Doctorate',
					'first_language' => 'String indicating first language',
					'handedness' => '0=Right handed, 1=Left handed, 2=Ambidextrous',
					'veteran' => '0=No, 1=Yes',
					'photo' => 'Currently not used',
					'research_registry_consent' => '0=no, 1=yes, 2=consent not yet obtained',
					'marital_status' => '0=single, 1=married, 2=divorced, 3=separated, 4=widowed, 5=common-law',
					'family_doctor_id' => 'unique id (integer) linking subject to family doctor'
				))
			);
	}
}
