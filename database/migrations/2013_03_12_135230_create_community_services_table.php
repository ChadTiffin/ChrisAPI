<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateCommunityServicesTable extends Migration {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('community_services', function($table){
			$table->increments('id');
			
			$table->integer('patient_id')->unsigned();
			$table->integer('community_service_type_id')->unsigned();
			$table->date('start_date')->nullable();
			$table->date('end_date')->nullable();
			$table->integer('hours_per_visit')->nullable();
			$table->integer('visits_per_week')->nullable();

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
		Schema::drop('community_services');
	}
	public function get_comments() {
		return array(
			'community_services' => array('details on patient\'s use of community service', array(
				'community_service_type_id' => 'FK to community_service_types table. This is the actual service being used.',
				'clinical_staff_id' => 'unique id (int) of attending staff member. FK tousers table',
				'start_date' => 'date object. indicates when subject started using the community service',
				'end_date' => 'date object. indicates when subject staopped using the community service',
				'hours_per_visit' => 'The number of hours a subjects utilizeds a community service per week',
				'visits_per_week' => 'The number of visits a subject visits a community service per week',

				))
			);
	}
}
