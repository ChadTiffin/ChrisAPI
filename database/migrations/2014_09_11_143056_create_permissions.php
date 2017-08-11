<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('groups', function($table) {
			$table->increments('id');

			$table->string('name');
			$table->string('description');
			
			$table->integer('created_by')->unsigned()->nullable();
			$table->foreign('created_by')->references('id')->on('users');
			$table->integer('modified_by')->unsigned()->nullable();
			$table->foreign('modified_by')->unsigned()->references('id')->on('users');
			$table->timestamps();
			$table->timestamp('deleted_at')->nullable();
		});

		Schema::create('group_clinics', function($table) {
			$table->integer('group_id')->unsigned();
			$table->foreign('group_id')->references('id')->on('groups');

			$table->integer('clinic_id')->unsigned();
			$table->foreign('clinic_id')->references('id')->on('clinics');

			$table->integer('created_by')->unsigned()->nullable();
			$table->foreign('created_by')->references('id')->on('users');
			$table->integer('modified_by')->unsigned()->nullable();
			$table->foreign('modified_by')->unsigned()->references('id')->on('users');
			$table->timestamps();
			$table->timestamp('deleted_at')->nullable();


		});

		Schema::create('user_clinics', function($table) {
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');

			$table->integer('clinic_id')->unsigned();
			$table->foreign('clinic_id')->references('id')->on('clinics');

			$table->integer('created_by')->unsigned()->nullable();
			$table->foreign('created_by')->references('id')->on('users');
			$table->integer('modified_by')->unsigned()->nullable();
			$table->foreign('modified_by')->unsigned()->references('id')->on('users');
			$table->timestamps();
			$table->timestamp('deleted_at')->nullable();

		});

		Schema::create('user_groups', function($table) {
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');

			$table->integer('group_id')->unsigned();
			$table->foreign('group_id')->references('id')->on('groups');

			$table->integer('created_by')->unsigned()->nullable();
			$table->foreign('created_by')->references('id')->on('users');
			$table->integer('modified_by')->unsigned()->nullable();
			$table->foreign('modified_by')->unsigned()->references('id')->on('users');
			$table->timestamps();
			$table->timestamp('deleted_at')->nullable();

		});

		Schema::create('group_route_permissions', function($table) {
			$table->increments('id');
			$table->integer('group_id')->unsigned();
			$table->foreign('group_id')->references('id')->on('groups');

			$table->string('route_path');
			$table->boolean('route_access');
			$table->integer("sort_order")->nullable();

			$table->integer('created_by')->unsigned()->nullable();
			$table->foreign('created_by')->references('id')->on('users');
			$table->integer('modified_by')->unsigned()->nullable();
			$table->foreign('modified_by')->unsigned()->references('id')->on('users');
			$table->timestamps();
			$table->timestamp('deleted_at')->nullable();

		});

		Schema::create('group_model_permissions', function($table) {
			$table->increments('id');
			$table->integer('group_id')->unsigned();
			$table->string('model_name');
			$table->boolean('read')->unsigned();
			$table->boolean('create')->unsigned();
			$table->boolean('update')->unsigned();
			$table->boolean('delete')->unsigned();
			$table->boolean('identifiable')->unsigned();
			$table->integer("sort_order")->nullable();

			$table->integer('created_by')->unsigned()->nullable();
			$table->foreign('created_by')->references('id')->on('users');
			$table->integer('modified_by')->unsigned()->nullable();
			$table->foreign('modified_by')->unsigned()->references('id')->on('users');
			$table->timestamps();
			$table->timestamp('deleted_at')->nullable();

		});

		Schema::create('group_model_variable_restrictions', function($table) {
			$table->increments('id');

			$table->integer('model_perm_id');
		});

		Schema::create('group_research_trials', function($table) {
			$table->integer('research_trial_id')->unsigned();
			$table->foreign('research_trial_id')->references('id')->on('research_trials');

			$table->integer('group_id')->unsigned();
			$table->foreign('group_id')->references('id')->on('groups');

			$table->integer('created_by')->unsigned()->nullable();
			$table->foreign('created_by')->references('id')->on('users');
			$table->integer('modified_by')->unsigned()->nullable();
			$table->foreign('modified_by')->unsigned()->references('id')->on('users');
			$table->timestamps();
			$table->timestamp('deleted_at')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('group_research_trials');
		Schema::drop('group_model_permissions');		
		Schema::drop('group_route_permissions');
		Schema::drop('user_groups');
		Schema::drop('groups');
	}

}
