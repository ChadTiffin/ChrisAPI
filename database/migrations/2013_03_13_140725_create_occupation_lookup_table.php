<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateOccupationLookupTable extends Migration {

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('occupations');
	}

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('occupations', function($table){
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('name');
		});
	}
	public function get_comments() {
		return array(
			'occupations' => array('A managed list of occupations for use in CHRIS', array(
					'name' => 'The name of the occupation (ie. Pilot)',
				))
			);
	}
}
