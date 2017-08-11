<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmploymentHistory extends EncounterView
{
	public $table = 'employment_histories';

	protected $presenter_info = array(
		'javascript' => array(),
		'view' => 'patient/encounters/employment_history'
	);
	/**
	 *
	 * 	
	 * Return a fake instance of a patient
	 * 	 	 
	 */
	public static function fake($faker = NULL, $report = 0)
	{

		/*
		if($faker == NULL)
			$faker = Faker\Factory::create();
		*/


		return new EmploymentHistory;

	}
}
