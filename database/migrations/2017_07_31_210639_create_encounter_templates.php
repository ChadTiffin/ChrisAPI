<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEncounterTemplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('encounter_templates', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();

            $table->string("name");

            $table->integer('modified_by')->unsigned()->nullable(); 
            $table->foreign('modified_by')->references('id')->on('users');
            $table->integer('created_by')->unsigned()->nullable(); 
            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
            
        });

        Schema::create('encounter_templates_forms', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();

            $table->integer('template_id')->unsigned();
            $table->foreign('template_id')->references('id')->on('encounter_templates');

            $table->integer('form_id')->unsigned();
            $table->foreign('form_id')->references('id')->on('encounter_forms');

            $table->integer('modified_by')->unsigned()->nullable();
            $table->foreign('modified_by')->references('id')->on('users');
            $table->integer('created_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on('users');

            $table->timestamps();
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
        chema::drop('encounter_templates');
    }
}
