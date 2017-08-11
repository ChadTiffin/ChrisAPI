<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class ResearchTrial extends Chrismodel
{
	public $table = 'research_trials';

	public $label = "Research Trials";
	public $label_single = "Research Trial";
	public $table_fields = [
		["label" => "Ethics #", "key" => "study_ethics_number"],
		["label" => "Short Name", "key" => "study_short_name"],
		["label" => "Coordinator", "key" => "study_coordinator"],
		["label" => "Category", "key" => "study_category"],
		["label" => "Population", "key" => "study_population"],
		["label" => "MMSE Range", "key" => "study_mmse"],
		["label" => "MRI Required", "key" => "study_mri", "type" => "boolean"],
		["label" => "LP Required", "key" => "study_lp", "type" => "boolean"],
		["label" => "PET Required", "key" => "study_p", "type" => "boolean"],
		["label" => "Study Length", "key" => "study_length"],
		["label" => "Study Description", "key" => "study_description"],
		["label" => "Currently Active?", "key" => "study_active", "type" => "boolean"]
	];

	public function groups() {
		return $this->belongsToMany('PermissionGroup', 'group_research_trials', 'research_trial_id', 'group_id');
	}

	/**
	 *
	 * 	
	 * Return a fake instance of a patient
	 * 	 	 
	 */
	public static function fake($faker = NULL, $report = 0)
	{

		if($faker == NULL)
			$faker = Faker\Factory::create();
		
		$fields = array(
			'study_ethics_number'=>$faker->numberBetween(10000,99999),
			'study_short_name'=>'Short Name of Study',
			'study_description'=>$faker->paragraph(3),
		);

		return new ResearchTrial($fields);

	}

}


