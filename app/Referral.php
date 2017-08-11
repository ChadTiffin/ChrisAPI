<?php
namespace App;

use Illuminate\Database\Eloquent\Model;


class Referral extends Chrismodel
{
	public $validation_rules = array(
		'reason_for_referral' => 'required',
		'referral_date' => 'required',
		'referring_physician_id' => 'required',
		'past_mini_mental_state_examination' => 'integer|min:0|max:32',
		'past_montreal_cognitive_assessment' => 'integer|min:0|max:32'
	);

	public $table = 'referrals';
	
	protected $appends = array('DisplayName','DoctorName');

	protected static $unguarded = false;

	protected $guarded = array('DisplayName', 'referring_physician');
	
	public static $_relations = array('referringPhysician');

	/********************************************
	 * ORM Relationships
	 ********************************************/

	public function preSave()
	{
		parent::preSave();
		if (empty($this->past_mini_mental_state_examination))
		{
			$this->past_mini_mental_state_examination = null;
		}

		if (empty($this->past_montreal_cognitive_assessment))
		{
			$this->past_montreal_cognitive_assessment = null;
		}

	}

	public function referringPhysician()
	{
		if($this->fake == 0)
			return $this->belongsTo('Doctor', 'referring_physician_id');
		else {
			return Doctor::fake(NULL, 1);
		}
	}

	public function patient()
	{
		return $this->belongsTo('Patient');
	}
	
	public function documents()
	{
		return $this->hasMany('PatientFile');
	}
	
	public function getDisplayNameAttribute()
	{
		if(!$this->referral_date || !$this->reason_for_referral) return NULL;	
		if($this->referral_date instanceof DateTime)
			$date = $this->referral_date->format('d/m/Y');
		else $date = $this->referral_date;
		$hcn = $date . " - " . $this->reason_for_referral;
		return $hcn;
	}

	public function getDoctorNameAttribute()
	{
		$doctor = Doctor::find($this->referring_physician_id);
		if ($doctor) {
			return $doctor->name;
		}
		else {
			return false;
		}
		
	}


	/**
	 *
	 * 	
	 * Return a fake instance of a referral
	 * 	 	 
	 */
	public static function fake($faker = NULL, $report = 0)
	{
		if($faker == NULL)
			$faker = Faker\Factory::create();

		$date = new DateTime($faker->dateTimeBetween('-10 years','now')->format('Y/m/d'));
		$reasons = array(
			'Assessment of cognition after an episode of hypogycemia and admission to LHSC',
			'Assessment of cognitive status',
			'Short term memory decline and forgetfullness'
			);
		$fields = array(
			'referral_date' => $date,
			'past_mini_mental_state_examination' => $faker->optional()->numberBetween(27,30),
			'past_montreal_cognitive_assessment' => $faker->optional()->numberBetween(24,30),
			'reason_for_referral' => $faker->randomElement($reasons),

		);

		
		$referral = new Referral($fields);
		if($report)
			$referral['fake'] = 1;
		return $referral;
	}

}
