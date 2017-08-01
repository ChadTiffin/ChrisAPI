<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateSessionTable extends Migration {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(Config::get('session.table'), function($table)
		{
			// The session table consists simply of an ID, a UNIX timestamp to
			// indicate the expiration time, and a blob field which will hold
			// the serialized form of the session payload.
			$table->string('id')->length(40)->primary('session_primary');

			$table->integer('last_activity');

			$table->text('payload');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop(Config::get('session.table'));
	}

	public function get_comments() {
		return array(
			'sessions' => array('<strong><em>System Table</em></strong> - Stores the Laravel session data', array(
					
				))
			);
	}
}
