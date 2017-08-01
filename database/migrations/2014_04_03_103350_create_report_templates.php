<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateReportTemplates extends Migration {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('report_templates', function($table) {
			$table->increments('id');
			$table->boolean('is_snippet')->default(0);
			$table->boolean('is_internal')->default(0);

			$table->string('filename');

			$table->string('code',999999); //twig unevaluated code
			$table->string('description');

			$table->integer('created_by')->unsigned()->nullable();
			$table->foreign('created_by')->references('id')->on('users');
			$table->integer('modified_by')->unsigned()->unsigned()->nullable();
			$table->foreign('modified_by')->unsigned()->references('id')->on('users');
			$table->timestamps();
			$table->timestamp('deleted_at')->nullable();
		});

		Schema::create('report_template_variables', function($table) {
			$table->increments('id');

			$table->string('variable_name'); //twig variable name

			$table->string('variable_pretty_name'); //name presented to user "Last Encounter", "Last MoCA"

			$table->string('model'); //Only encounter is supported right now, later on any hasOne(or hasMany?) relationship should be possible

			$table->integer('report_template')->unsigned();
			$table->foreign('report_template')->unsigned()->references('id')->on('report_templates');


			$table->integer('created_by')->unsigned()->nullable();
			$table->foreign('created_by')->references('id')->on('users');
			$table->integer('modified_by')->unsigned()->unsigned()->nullable();
			$table->foreign('modified_by')->unsigned()->references('id')->on('users');
			$table->timestamps();
			$table->timestamp('deleted_at')->nullable();
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('report_templates');
		Schema::drop('report_template_variables');
	}

}
