<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateDoctorsTable extends Migration {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('doctors', function($table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();

			$table->string('name')->unique();
			$table->string('telephone')->nullable();
			$table->string('cell_phone')->nullable();
			$table->string('address')->nullable();
			$table->string('type')->nullable();

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
		Schema::drop('doctors');
	}

	public function get_comments() {
		return array(
			'doctors' => array('Information related to external physicians. (ie family docs, referring physicians)', array(
					'name' => 'The full name of the doctor',
					'telephone' => 'The telephone number of the doctor',
					'cell_phone' => 'The doctor\'s cellphone number',
					'address' => 'Full address for the doctor',
					'type' => 'The specialty of the doctor'

				))
			);
	}


}
