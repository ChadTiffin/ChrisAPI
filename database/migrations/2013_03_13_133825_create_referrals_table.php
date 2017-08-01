<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateReferralsTable extends Migration {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('referrals', function($table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();

			$table->integer('patient_id')->unsigned();
			$table->foreign('patient_id')->references('id')->on('patients');

			$table->integer('referring_physician_id')->unsigned()->nullable();
			$table->foreign('referring_physician_id')->references('id')->on('doctors');

			$table->text('reason_for_referral')->nullable();
			$table->integer('past_mini_mental_state_examination')->nullable();
			$table->integer('past_montreal_cognitive_assessment')->nullable();
			$table->date('referral_date')->nullable(); 

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
		Schema::drop('referrals');
	}

	public function get_comments() {
	return array(
		'referrals' => array('basic referral information', array(
			'referring_physician_id' => 'FK to doctors table. Indicates the physicians that made the referral.',
			'reason_for_referral' => 'free text reason for referral',
			'referral_date' => 'date object. Idicates when the referral was received',
			'past_mini_mental_state_examination' => 'MMSE score from test conducted by referring physician',
			'past_montreal_cognitive_assessment' => 'MoCA score from test conducted by referring physician',
			))
		);
	}

}
