<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateUsersTable extends Migration {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();

			$table->string('username')->unique();
			$table->text('password');

			$table->text('role');

			$table->text('email');
			$table->text('first_name');
			$table->text('last_name');
			$table->text('phone_number');
			$table->text('pager_number');
			$table->text('title');
			$table->text('actions');
			$table->text('position');
			$table->boolean('privacy_confirmation');
         	$table->integer('group_id')->unsigned()->nullable();
			
			$table->text('remember_token');
			$table->string("api_key");

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
		Schema::drop('users');
	}

	public function get_comments() {
		return array(
			'users' => array('Table consisting of all users', array(
					'username' => 'Users login name',
					'role' => 'User Role(Developer, Doctor, etc)',
					'first_name' => 'User\'s first name',
					'last_name' => 'User\'s last name',
					'email' => 'User\'s email address',
					'phone_number' => 'User\'s phone extension',
					'pager_number' => 'User\'s pager extension',
					'title' => 'User\'s title - Mr., Mrs., Dr., etc.',
					'actions' => 'User\'s  actions - Geriatrician, psychologist, student etc.',
					'position' => 'User\'s position - Doctor, Nurse, Resident, Med Student, Research Coordinator, etc.',
					'password' => 'This is the user\'s password. This feild is only used when the CHRIS auth is active in the system. When using alternative auth (such as LHSC/SJHC SSO), no data is saved.',
					'privacy_confirmation' => 'boolean that indicates whether or not the user has agreed to the initial privacy statement',
					'remember_token' => ''

				))
			);
	}

}
