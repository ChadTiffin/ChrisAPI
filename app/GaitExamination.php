<?php
namespace App;

use Illuminate\Database\Eloquent\Model;


class GaitExamination extends EncounterView
{
	public $table = 'gait_examinations';

	protected static $completion_rules = array(
		'symmetrical'=>'required',
		'use_of_gait_aid'=>'required',
		'base'=>'required',
		'trunk_rotation'=>'required',
		'speed'=>'required',
		'velocity'=>'required',
		'stride_length'=>'required',
		'arm_swing'=>'required',
		);

	public static $_relations = array('gaitAids');

	public function get_rules()
	{
		return array();
	}
	/********************************************
	 * ORM Relationships
	 ********************************************/
	

	protected $presenter_info = array(
		'javascript' => array('gait_examination_js' => 'js/chris/patient/encounters/gait_examination.js'),
		'view' => 'patient/encounters/gait_examination'
	);


	public function gaitAids() {
		return $this->belongsToMany('GaitAid', 'gait_examination_aids', 'gait_exam_id', 'gait_aid_id');;
	}

	/**
	 *
	 * 	
	 * Return a fake instance of a contact
	 * 	 	 
	 */
	public static function fake($faker = NULL, $report = 0)
	{

		if($faker == NULL)
			$faker = Faker\Factory::create();


		$fields = array(

			'symmetrical'=>$faker->numberBetween(0,1),
			'symmetrical_description'=>$faker->realText(50,2),
			'use_of_gait_aid'=>$faker->numberBetween(0,1),
			'aid_type'=>$faker->randomElement(array('Walker','Cane','Wheelchair','None')),
			'base'=>$faker->numberBetween(0,1),
			'base_description'=>$faker->realText(50,2),
			'trunk_rotation'=>$faker->numberBetween(0,1),
			'trunk_rotation_description'=>$faker->realText(40,2),
			'speed'=>$faker->randomElement(array(0,1)),
			'speed_description'=>$faker->realText(40,2),
			'stride_length'=>$faker->randomElement(array(0,1,2)),
			'stride_length_description'=>$faker->realText(40,2),
			'arm_swing'=>$faker->numberBetween(0,1),
			'arm_swing_description'=>$faker->realText(40,2),
			'scoliosis'=>$faker->numberBetween(0,1),
			'kyphosis'=>$faker->numberBetween(0,1),
			'lordosis'=>$faker->numberBetween(0,1),
			'gait_distance'=>$faker->randomFloat(2,0,2.5),
			'gait_time'=>$faker->randomFloat(2,0,2.5),
			'gait_other'=>$faker->realText(40,2),

		);


		return new GaitExamination($fields);

	}


}
