<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEncounterFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('encounter_forms', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();

            $table->string("form_title");
            $table->string("encounter_form_keyword");
            $table->string("encounter_form_description");
            $table->boolean("encounter_form_active");
            $table->string("form_html");

            $table->integer('modified_by')->unsigned()->nullable(); 
            $table->foreign('modified_by')->references('id')->on('users');
            $table->integer('created_by')->unsigned()->nullable(); 
            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamp('deleted_at')->nullable();
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
        Schema::drop('encounter_template_forms');
    }
}
