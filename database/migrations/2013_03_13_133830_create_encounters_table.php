<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateEncountersTable extends Migration {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('encounters', function($table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();

			$table->integer('patient_id')->unsigned();
			$table->foreign('patient_id')->references('id')->on('patients');

			$table->integer('referral_id')->unsigned();
			$table->foreign('referral_id')->references('id')->on('referrals');

			$table->integer('clinical_staff_id')->unsigned();
			$table->foreign('clinical_staff_id')->references('id')->on('users');

			$table->date('date')->nullable();
			
			$table->longText('notes');

			$table->integer('location_id')->unsigned();
			$table->foreign('location_id')->references('id')->on('clinics');

			$table->string('template_id');

			$table->json("data");
			
			$table->integer('modified_by')->unsigned()->nullable(); 
			$table->foreign('modified_by')->references('id')->on('users');
			$table->integer('created_by')->unsigned()->nullable(); 
			$table->foreign('created_by')->references('id')->on('users');
			$table->timestamp('deleted_at')->nullable();
			$table->timestamps();
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
		Schema::drop('encounters');
	}


	public function get_comments() {
		return array(
			'encounter_templates' => array('Name of encounter templates and whether it belongs to an encounter', array(
					'name' => 'name of the template',
					'patient_encounter' => 'is the template used in an encounter? 0=no, 1=yes'

				)),
			'encounter_viewsets' => array('viewset is a grouping of forms within a template', array(
				'name' => 'the name of the viewset',
				'sort' => 'order in which the viewset appears in the template',
				'date' => 'date object. indicates when encounter takes place',
				'patient_viewset' => 'indicates whether or not the viewset is a template or is in use in a patient\'s encounter. 0=no, 1=yes',

				)),
			'encounter_template_viewsets' => array('joining table to attach viewsets to templates', array(
				'template_id' => 'FK of encounter_templates table',
				'viewset_id' => 'FK of encounter_viewsets tables'	
				)),
			'encounter_viewset_forms' => array('the forms stored within a viewset', array(
				'viewset_id' => 'FK to encounter_viewsets table',
				'sort' => 'the order in which views are displayed in a viewset',
				'form_name' => 'the actual name of the form. This variable is taken from the file name of the form\'s Laravel view'
				)),
			'encounters' => array('details on the type of encounter', array(
				'referral_id' => 'unique id (int) and FK relating encounter to a referral in the referrals tables',
				'clinical_staff_id' => 'unique id (int) of attending staff member. FK tousers table',
				'date' => 'date object. indicates when encounter takes place',
				'location_id' => 'unique id (int) of the location where the ecnounter takes place. FK to the clinics table',
				'template_id' => 'unique id (int) of the clinic template used to capture data in the encounter. FK to encounter_templates table',
				'locked' => 'boolean that indicated whether the encounter is locked to changes. 0=no, 1=yes',


				))
			);





		
	}



}
