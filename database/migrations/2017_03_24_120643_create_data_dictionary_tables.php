<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataDictionaryTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('dictionary_tables', function($table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();

			$table->string('table_name')->unique();
			$table->string('description');
			$table->timestamp('created_at');

		});

		Schema::create('dictionary_fields',function($table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();

			$table->integer('table_id')->unsigned();
			$table->foreign('table_id')->references('id')->on('dictionary_tables');
			$table->string('field_name');
			$table->string('type');
			$table->string('description');
			$table->string('fk_table');
			$table->string('fk_column');
			$table->string('nullable');

			$table->timestamp('created_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
