<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicationList extends Chrismodel
{
	public $table = 'medication_lists';

	public static $_relations = array('medications');
	/********************************************
	 * ORM Relationships
	 ********************************************/

	public function patient()
	{
		return $this->belongsTo('Patient');
	}

	public function medications()
	{	
		if($this->fake == 0) {	
			return $this->hasMany('PatientMedication', 'list_id');
		} else return PatientMedication::fake(NULL, 1);
	} 
	

	public static function fake($faker = NULL, $report = 0)
	{

		if($faker == NULL)
			$faker = Faker\Factory::create();
	

		$fields = array(
			'initial_list_obtained'	=> '*DATE*',
			'initial_list_obtained_by'	=> 'USERID',
			'consent' => $faker->numberBetween(0, 1),
			'pharmacy' =>	'*PHARMACY NAME',
			'phone_number' =>	'555-1234',
			'medication_allergies' =>	'*I AM MEDICATION ALLERGIES*',
			'environmental_allergies' =>	'*I AM ENVIRONMENTAL ALLERGIES*',
			'food_allergies' => '*I AM FOOD ALLERGIES*'
			

		);
		$list = new MedicationList($fields);
		if($report)
			$list->fake = 1;
		
		$list->LoadTwigRelations();	
		return $list; 

	}

	public function report_composites() {
		$ret = array();
		if($this->id) {
			if($this->medications) {
				$hist = $this->medications->ToArray();
				foreach($hist as $h) {
					$ret[] = $h;
				}
			}

		} else {
			$faker = Faker\Factory::create();

			$num = $faker->numberBetween(1, 4);
			for($i=0;$i<$num;$i++) {
				$ret[] = PatientMedication::fake(NULL, 1)->ToArray();
			}
		}

		$this['medications'] = $ret;
	}

	public function LoadTwigRelations(){
		$this->report_composites();
	}


}
