<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Chrismodel
{
	public $table = 'diagnoses';

	public $label = "Diagnoses";
	public $label_single = "Diagnosis";
	public $table_fields = [
		["label" => "Diagnosis", "key" => "diagnosis"],
		["label" => "Description", "key" => "diagnosis_description"],
	];

	/********************************************
	 * ORM Relationships
	 ********************************************/

	public function differentialdiagnosis()
	{
		return $this->belongsTo('DifferentialDiagnosis');
	}

}
