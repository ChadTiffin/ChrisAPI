<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateClinicsTable extends Migration {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clinics', function($table){
			$table->increments('id');
			
			$table->string('name');
			$table->string('address');
			$table->string('room');
			$table->string('site');

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
		Schema::drop('clinics');
	}


	public function get_comments() {
		return array(
			'clinics' => array('data on the clinic in which patients are seen', array(
				'name' => 'the name of the clinic where encounters take place',
				'address' => 'address of the clinic. Useful for reporting',
				'room' => 'room where encounter took place if applicable. useful for reporting',
				'site' => 'name of site where encounter took place. Useful for reporting'	

				))
			);
	}

}