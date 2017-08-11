<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class FamilyHistory extends EncounterView
{
	public $table = 'family_histories';
	public static $_relations = array('familyMemberHistories');

	protected $presenter_info = array(
		'javascript' => array(),
		'view' => 'patient/encounters/family_history'
	);
	/********************************************
	 * ORM Relationships
	 ********************************************/
	public function familyMemberHistories()
	{
		if($this->fake == 0) {	
			return $this->hasMany('FamilyMemberHistory', 'family_history_id');		
		} else return FamilyMemberHistory::fake(null, 1);
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
			'number_of_siblings'=>$faker->numberBetween(0,5),
			'family_history_of_downs_syndrome'=>$faker->numberBetween(0,1),
			'family_history_of_dementia'=>$faker->numberBetween(0,1),


		);
		$family_history = new FamilyHistory($fields);

		return $family_history;
	}


	public function report_composites() {
		$ret = array();
		if($this->id) {
			if($this->familyMemberHistories) {
				$hist = $this->familyMemberHistories->ToArray();
				foreach($hist as $h) {
					$ret[] = $h;
				}
			}

		} else {
			$faker = Faker\Factory::create();

			$num = $faker->numberBetween(1, 4);
			for($i=0;$i<$num;$i++) {
				$ret[] = FamilyMemberHistory::fake(NULL, 1)->ToArray();
			}
		}

		$this['family_member_history'] = $ret;
	}

	public function LoadTwigRelations(){
		$this->report_composites();
	}

}
