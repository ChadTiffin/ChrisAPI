<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateGaitExaminationsTable extends Migration {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gait_aids', function($table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();

			$table->text('name')->nullable();
			
			$table->integer('modified_by')->unsigned()->nullable(); 
			$table->foreign('modified_by')->references('id')->on('users');
			$table->integer('created_by')->unsigned()->nullable(); 
			$table->foreign('created_by')->references('id')->on('users');
			$table->timestamp('deleted_at')->nullable();
			$table->timestamps();
			
		});

/*
		Schema::create('gait_examinations', function($table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();

			$table->integer('form_id')->unsigned();
			$table->foreign('form_id')->references('id')->on('encounter_viewset_forms');
			

			$table->integer('symmetrical')->nullable();
			$table->text('symmetrical_description')->nullable();
			$table->boolean('use_of_gait_aid')->nullable();
			$table->string('aid_type')->nullable();
			$table->integer('base')->nullable();
			$table->text('base_description')->nullable();
			$table->integer('trunk_rotation')->nullable();
			$table->text('trunk_rotation_description')->nullable();
			$table->integer('speed')->nullable();
			$table->text('speed_description')->nullable();

			$table->float('gait_distance')->nullable();
			$table->float('gait_time')->nullable();

			$table->integer('stride_length')->nullable();
			$table->text('stride_length_description')->nullable();
			$table->string('arm_swing')->nullable();
			$table->text('arm_swing_description')->nullable();
			$table->boolean('scoliosis')->nullable();
			$table->boolean('kyphosis')->nullable();
			$table->boolean('lordosis')->nullable();

			$table->text('gait_other')->nullable();
			
			$table->integer('modified_by')->unsigned()->nullable(); 
			$table->foreign('modified_by')->references('id')->on('users');
			$table->integer('created_by')->unsigned()->nullable(); 
			$table->foreign('created_by')->references('id')->on('users');
			$table->timestamp('deleted_at')->nullable();
			$table->timestamps();
			
		});

		Schema::create('gait_examination_aids', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();

			$table->integer('gait_exam_id')->unsigned();
			$table->foreign('gait_exam_id')->references('id')->on('gait_examinations');

			$table->integer('gait_aid_id')->unsigned();
			$table->foreign('gait_aid_id')->references('id')->on('gait_aids');
		});*/
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
//		Schema::drop('gait_examinations');
//		Schema::drop('gait_examination_aids');
		Schema::drop('gait_aids');
	}

}
