<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Encounter extends Chrismodel
{
	public $table = 'encounters';

	public $validation_rules = array(
			'patient_id' => 'required|integer',
			'referral_id' => 'required|integer',
			'date' => 'required',
			'location_id' => 'required',
			'clinical_staff_id' => 'required',
			'template_id' => 'required',
	);


	protected static $unguarded = false;

	protected $fillable = array(
		'id',
		'patient_id',
		'referral_id',
		'clinical_staff_id',
		'template_id',
		'date',
		'notes',
		'location_id',
		'locked',
	);

	public static $_relations = array('accompanyingContacts', 'referral', 'clinicalStaff', 'additionalStaff', 'location' ,'template');
	
    protected $with = array('attending');

    protected $appends = array('DisplayName', 'EncounterData', 'CascadeDeleteRelatedModels');

	/**
	 * Override type so $this->type returns a nice string instead of the_type 
	 */
	public function getType()
	{
		return ucwords(str_replace('_', ' ', $this->get_attribute('type')));
	}

	/********************************************
	 * ORM Relationships
	 ********************************************/

	public function patient()
	{
		if($this->fake == 0) {
			return $this->belongsTo('Patient');
		} else return Patient::fake();
	}

	public function location()
	{
		if($this->fake == 0) {
			return $this->belongsTo('Clinic');
		} else {
			$input = array('name' => 'Aging Brain and Memory Clinic',
						   'address' => 'address',
						   'room' => 'A123',
						   'site' => 'Parkwood');
			return new Clinic($input);
		}
	}

	public function accompanyingContacts()
	{

		if($this->fake == 0) {
			return $this->belongsToMany('Contact', 'encounter_contacts');
		} else {
			$faker = Faker\Factory::create();
			$num_users = $faker->numberBetween(0,2);
			$users = array();
			for($i=0;$i<$num_users;$i++) {
				$users[] = Contact::fake(NULL, 1)->ToArray();
			}
		 	return $users;
		}
	}

	public function referral()
	{
		if($this->fake == 0) {
			return $this->belongsTo('Referral');
		} else return Referral::fake(NULL, 1);
	}

	public function reports()
	{
		return $this->hasMany('Report');
	}

	public function familyOrFriends()
	{
		return $this->hasMany('ImmediateFamilyOrFriend');
	}

	public function clinician()
	{
		return $this->hasOne('Clinician');
	}

	public function attending()
	{
		return $this->hasOne('User','id', 'clinical_staff_id');
	}


	public function files()
	{
		return $this->belongsToMany('PatientFile', 'encounter_documents');
	}

	public function clinicalStaff()
	{
		if($this->fake == 0) {
			return $this->belongsTo('User');
		} else {
			$users = User::all();
			$users = $users->ToArray();

			$faker = Faker\Factory::create();
			return $faker->randomElement($users);
		}
	}


	public function template() {
		if($this->fake == 0) {
			return $this->hasOne('EncounterTemplate');
		} else return EncounterTemplate::find($this->template_id);
		
	}

	public function additionalStaff() {
		if($this->fake == 0) {
			return $this->belongsToMany('User', 'encounter_clinicians');
		} else {
			$faker = Faker\Factory::create();

			$num_users = $faker->numberBetween(0,2);

			$users = User::all();
			return $faker->randomElements($users->ToArray(), $num_users);

		}
	}

	public function getCascadeDeleteRelatedModelsAttribute()
	{
		return array(
			"collection" => array("encounter_templates","encounter_data"),
			"table" => array("encounter_contacts","encounter_clinicians")
		);
	}

	public function getDisplayNameAttribute()
	{
		if($this->fake){
			$name = "Fake Encounter";
			return $name;
		}

		$template = EncounterTemplate::find($this->template_id);

		$name = 'N/A';
		if($template && isset($template['name']))
			$name = $template['name'];

		return $name;

	}

	public function getAttendingPhysicianAttribute()
	{
		return $this->attending();
	}

	public function getEncounterDataAttribute()
	{
		if($this->fake == 0) {
			$returnData = EncounterData::find((string)$this->id);
			return $returnData;
		} else return EncounterData::fake(NULL, 1);
	}

	/**
	 *
	 * 	
	 * Return a fake encounter for a patient
	 * 	 	 
	 */
	public static function fake($faker = NULL, $report = 0)
	{
		if($faker == NULL)
			$faker = Faker\Factory::create();

		$templates = EncounterTemplate::all();

		$template_ids = array();
		foreach($templates as $template) {
			$template_ids[] = $template->_id;
		}

		$template = $faker->randomElement($template_ids);
		$template_name = EncounterTemplate::find($template);

		$location_ids = array();
		$locations = Clinic::all();

		foreach($locations as $location) {
			$location_ids[] = $location->id;
		}


		$doe = $faker->dateTimeBetween('-4 months','now')->format('Y/m/d');

		$fields = array(
			'date' => $doe,
			'location_id' => $faker->randomElement($location_ids),
			'template_id' => $template,
		);

		$encounter = NULL;

		if($report) {
				$fields['template_id'] = 0;
				$fields['type'] = "fake encounter";
				$encounter = new Encounter($fields);
				$encounter->fake = 1;
			}
		 else {
			$encounter = new Encounter($fields);
		}
		return $encounter;

	}

	public function seedViews($save = 1) {

	$template = EncounterTemplate::find($this->template_id);
	if($template->name != "Reporting"){
		foreach($template->viewsets as $viewset) {
				foreach($viewset->forms as $view) {
					$relation_class_name = make_model_name($view->form_name)[0];
					if(method_exists((string)$relation_class_name, 'fake')) {			

						$model = $relation_class_name::fake();
						$model->form_id = $view->id;
					
					
						if($save) {
							$model->save();
							
							if(strtolower($relation_class_name) == 'differentialdiagnosis' || strtolower($relation_class_name) == 'generalphysicalexamination') {
								$model->seed();
							}
						}
						else {
							$model->LoadTwigRelations();
							$this->{$view->form_name} = $model->ToArray();
						}
					}

				}
			}
		}
		else{
			$views = array();
			foreach(glob("../app/views/patient/encounters/*.php") as $file)
			{
				$file = pathinfo($file, PATHINFO_FILENAME);
				$file = str_replace(".blade", "", $file);
				$views[] = $file;
			}
			$i=0;
			foreach($views as $view) {
					$relation_class_name = make_model_name($view)[0];

					if(method_exists((string)$relation_class_name, 'fake')) {			
						$model = $relation_class_name::fake();
						
						$model->form_id = $i++;
					
					
							$model->LoadTwigRelations();
							$this->{$view} = $model->ToArray();
					}

				}
		}
	}

	


}
