<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Chrismodel
{

	protected static $unguarded = false;

	protected $fillable = array(
		'family_doctor_id',
		'pin',
		'last_name',
		'first_name',
		'middle_name',
		'prefix',
		'date_of_birth',
		'is_deceased',
		'date_of_death',
		'sex',
		'health_card_number',
		'health_card_version',
		'number_of_years_of_education',
		'highest_education_level_completed',
		'first_language',
		'handedness',
		'veteran',
		'photo',
		'research_registry_consent',
		'marital_status',
		'additional_language_information',
		'hash_first_name',
		'hash_last_name',
		'hash_pin',
		'hash_health_card_number'
	);
	protected $appends = array('fullhcn', 'telephone', 'name', 'age', 'he', 'him','his','helpers');

	public static $_relations = array("familyDoctor", 'contacts',
		'livingArrangements', 'medicationList');

    protected $with = array('encounters', 'contacts', 'referrals', 'registrations');

	public $validation_rules = array(
		'pin' => 'sometimes|numeric|digits_between:6,10',
		'last_name' => 'sometimes|required',
		'first_name' => 'sometimes|required',
		'health_card_number' => 'sometimes|numeric|digits:10',
		'date_of_birth' => 'sometimes|required|date',
		'sex' => 'sometimes|required',
		'research_registry_consent' => 'sometimes|required'
	);
	protected static $import_rules = array(array(
			'last_name' => 'required',
			'first_name' => 'required',
			'date_of_birth' => 'required|date',
			'sex' => 'required',
			),
	);

	public static $identifiable = array(
		'last_name', 
		'first_name', 
		'middle_name', 
		'date_of_birth', 
		'date_of_death', 
		'health_card_number', 
		'health_card_version',
		'pin',
		'prefix'
	);

	/**
	 * Pre save hook to clear out dates properly
	 */
	public function preSave()
	{
		parent::preSave();
		$this->date_of_death = empty($this->date_of_death) ? NULL : $this->date_of_death;
		$this->date_of_birth = empty($this->date_of_birth) ? NULL : $this->date_of_birth;
	}

	/**
	 * Provides a String representation of the object.
	 * This is used by the AuditLog class.
	 * Should return something that the users of the website could use
	 * to differentiate between the different patients, ie: HCN
	 */
	public function __toString()
	{
		$class = get_called_class();
		$identifier = $this->FullHCN ?: '(new)';
		return "{$class} HCN: {$identifier}";
	}

	public function getFullHCNAttribute()
	{
		if(!$this->health_card_number) return NULL;	
		$hcn = $this->health_card_number . " " . $this->health_card_version;
		return $hcn;
	}

	public function getEncountersAttribute(){
		if($this->fake == 0) {
			return $this->encounters();
		} else return Encounter::fake(NULL, 1);
	}

	public function getTelephoneAttribute()
	{
		$currentLivingArrangement = $this->getCurrentLivingArrangement();
		$telephone = 'N/A';
		if($currentLivingArrangement)
		{
			$telephone = $currentLivingArrangement->telephone;
		}

		return $telephone;
	}
	

	/*******
	*
	*  ENCRYPTION OF PATIENT VARIABLES
	*
	********/
	public function getFirstNameAttribute($value)
	{
	    if($value == null)
	    	return;

	    return Crypt::decrypt($value);
	}
	public function setFirstNameAttribute($value)
	{
		if($value == null)
	    	return;
	    
	    $this->attributes['first_name'] = Crypt::encrypt(ucwords($value));
	}
	public function getLastNameAttribute($value)
	{
	    if($value == null)
	    	return;

	    return Crypt::decrypt($value);
	}
	public function setLastNameAttribute($value)
	{
	    if($value == null)
	    	return;

	    $this->attributes['last_name'] = Crypt::encrypt(ucwords($value));
	}

	public function getMiddleNameAttribute($value)
	{
	    if($value == null)
	    	return;

	    return Crypt::decrypt($value);
	}
	public function setMiddleNameAttribute($value)
	{
	    if($value == null)
	    	return;

	    $this->attributes['middle_name'] = Crypt::encrypt(ucwords($value));
	}
	public function getHealthCardNumberAttribute($value)
	{
	    if($value == null)
	    	return;

	    return Crypt::decrypt($value);
	}
	public function setHealthCardNumberAttribute($value)
	{
	    if($value == null)
	    	return;

	    $this->attributes['health_card_number'] = Crypt::encrypt($value);
	}
	public function getHealthCardVersionAttribute($value)
	{
	    if($value == null)
	    	return;

	    return Crypt::decrypt($value);
	}
	public function setHealthCardVersionAttribute($value)
	{
	    if($value == null)
	    	return;

	    $this->attributes['health_card_version'] = Crypt::encrypt($value);
	}
	public function getPinAttribute($value)
	{
	    if($value == null)
	    	return;

	    return Crypt::decrypt($value);
	}
	public function setPinAttribute($value)
	{
	    if($value == null)
	    	return ;

	    $this->attributes['pin'] = Crypt::encrypt($value);
	}

	/**
	* HASH SETTER. Hash fields are used for patient searches to prevent the need to pull the whole patient set and iterate through them
	*/

	public function setHashPinAttribute($value)
	{
		$this->attributes['hash_pin'] = hash('sha256',strtolower($this->pin));
	}

	public function setHashFirstNameAttribute($value)
	{
		$this->attributes['hash_first_name'] = hash('sha256',strtolower($this->first_name));
	}

	public function setHashLastNameAttribute($value)
	{
		$this->attributes['hash_last_name'] = hash('sha256',strtolower($this->last_name));
	}

	public function setHashHealthCardNumberAttribute($value)
	{
		$this->attributes['hash_health_card_number'] = hash('sha256',strtolower($this->health_card_number));
	}

	/**
	 * Return the most recent "current" living arrangement
	 *
	 * @return class LivingArrangment or null
	 */
	public function getCurrentLivingArrangement()
	{
		if($this->fake == 0) {	
			return $this->livingArrangements()
				->whereCurrentArrangement('1')
				->orderBy('moved_in', 'desc')
				->first();
		}
		else return LivingArrangement::fake(NULL, 1);
	}

	/********************************************
	 * ORM Relationships
	 ********************************************/
	# TODO This relationship needs to be discussed
	#
	public function familyDoctor()
	{
		if($this->fake == 0) {
			return $this->belongsTo('Doctor');
		} else return Doctor::fake(NULL, 1);
	}

	public function contacts()
	{
		if($this->fake == 0) {
			return $this->hasMany('Contact');
		} else return Contact::fake(NULL, 1);
	}

	public function referrals()
	{
		if($this->fake == 0) {
			return $this->hasMany('Referral');
		} else return Referral::fake(NULL, 1);
	}

	public function encounters()
	{
		if($this->fake == 0) {
			return $this->hasMany('Encounter');
			} else return Encounter::fake(NULL, 1);
	}

	public function registrations() {
		return $this->hasMany('PatientRegistration');
	}

	public function livingArrangements()
	{
		if($this->fake == 0) {
			return $this->hasMany('LivingArrangement');
		} else return LivingArrangement::fake(NULL, 1);
	}
	public function familyOrFriends()
	{
		return $this->hasMany('ImmediateFamilyOrFriend');
	}

	public function communityServices()
	{
		return $this->hasMany('CommunityService');
	}

	public function researchTrials()
	{
		return $this->hasMany('PatientResearchTrial');
	}

	public function medicationList()
	{
		if($this->fake == 0) {
			return $this->hasOne('MedicationList');
		} else return MedicationList::fake(NULL, 1);
	}

	public function files()
	{
		return $this->hasMany('PatientFile');
	}

	public function reports() {
		return $this->hasMany('PatientReport');
	}

	/********************************************
	 * Data Functions
	 ********************************************/
	public function getAgeAttribute()
	{
		if($this->date_of_birth)
		{
			$now = new \DateTime();
			$dob = new \DateTime($this->date_of_birth);
			$dod = new \DateTime($this->date_of_death);
			$age = $dob->diff($now)->y;
			if($this->is_deceased) {
				$death_age = $dod->diff($now)->y;
				$age -= $death_age;
			}

			return $age;
		}

		return null;
	}

	/**
	 * A custom name attribute that concatenates all parts of the name
	 */
	public function getNameAttribute()
	{
		return $this->prefix . " " . $this->first_name. " " . $this->middle_name . " " .$this->last_name;
	}

	/**
	 * A custom pronoun attribute.
	 * Male gender was used because the developer is a male
	 */
	public function getHeAttribute()
	{
		if ($this->sex == 'Male') {	
		return "he";
		}
		elseif ($this->sex == 'Female') {	
		return "she";
		}
		else {
			return "<mark>UNKNOWN PRONOUN</mark>";
		}
	}

	/**
	 * A custom pronoun attribute.
	 * Male gender was used because the developer is a male
	 */
	public function getHimAttribute()
	{
		if ($this->sex == 'Male') {	
		return "him";
		}
		elseif ($this->sex == 'Female') {	
		return "her";
		}
		else {
			return "<mark>UNKNOWN PRONOUN</mark>";
		}
	}

	/**
	 * A custom possessive 1 attribute. his/her
	 * Male gender was used because the developer is a male
	 */
	public function getHisAttribute()
	{
		if ($this->sex == 'Male') {	
		return "his";
		}
		elseif ($this->sex == 'Female') {	
		return "her";
		}
		else {
			return "<mark>UNKNOWN POSSESSIVE</mark>";
		}
	}

	public function getHelpersAttribute()
	{
		$marital_status = array(
				0 => 'single',
				1 => 'married',
				2 => 'divorced',
				3 => 'separated',
				4 => 'widowed',
				5 => 'common-law');
		
		$living = $this->getCurrentLivingArrangement();
		if($this->marital_status == NULL) 
			$status = NULL;
		else {
			$status = $marital_status[$this->marital_status];
		}
		$report = array(
			'marital_status' => $status);
		 
		if($living != null){
			$report['current_arrangement'] = $living->toArray();
			$report['current_address'] = $living->address;
			$report['current_city'] = $living->city;
			$report['current_province'] = $living->province;
			$report['current_country'] = $living->country;
			$report['current_dwelling'] = $living->dwelling_type;
			$report['current_telephone'] = $living->telephone;
			
		}
		$researchTrials = $this->researchTrials;
		$trials = array();
		$isactive = false;
		foreach($researchTrials as $trial){
			$get = $trial->researchTrial;
			if($trial->IsActive){
				$isactive = true;
			}
		}
		$report['active_in_research'] = $isactive;		
		
				return $report;
		
	}

	/**
	 * Find an encounter by date
	 */ 
	public function getEncounter($date)
	{
		return Encounter::where('patient_id', '=', $this->id)
			->where('date', '=', $date)
			->get();
	}

	/**
	 * Get the number of females and males in the database
	 * @return array
	 */
	public static function gender_data()
	{
		$males = Patient::where('sex', '=', 'male')
			->count();

		$females = Patient::where('sex', '=', 'female')
			->count();

		return array('males' => $males, 'females' => $females);
	}

	/**
	 * Get age related data for patients
	 * @return mixed
	 */
	public static function age_data()
	{
		$p = Patient::orderBy('date_of_birth', 'desc')->get(array('date_of_birth', 'date_of_death', 'is_deceased'));

		$patients = array();

		if( ! empty($p))
		{
			foreach($p as $patient)
			{
				if( $patient->date_of_birth != null ){
					// Add the number of patients for each age in eg: Number of 35yo patients = patients[35] = 20;
					if( empty($patients[$patient->get_age_years()]))
					{
						$patients[$patient->get_age_years()] = 1;
					}
					else
					{
						$patients[$patient->get_age_years()]++;
					}
				}
			}
		}
		else
		{
			// Empty class
			$patients = new StdClass();
		}

		return $patients;
	}



	/********************************************
	 * Utility Functions
	 ********************************************/

	/**
	 * Private function to prepare the age for calculation
	 * For now, if $timestamp is not null, it is assumed the patient is alive. 
	 *
	 * @param string
	 * @return array
	 */ 
	private function _prepareAge($timestamp)
	{
		if (empty($this->date_of_birth))
		{
			return null;
		}

		$dates[] = new DateTime($this->date_of_birth);
		if ($timestamp == null)
		{
			if($this->is_deceased) {
				$dates[] = new DateTime($this->date_of_death);
			} else
				$dates[] = new DateTime();
		}
		else
		{
			$dates[] = new DateTime($timestamp);
		}

		return $dates;
	}	

	/**
	 * Return the patient's age in years
	 * @param unix_timestamp | YYYY-MM-DD datestamp
	 * @return int
	 */ 
	public function get_age_years ($timestamp = null)
	{
		list($start, $end) = $this->_prepareAge($timestamp);

		if (is_null($start))
		{
			return;
		}

		//return $start->getDifferenceInYears($end);
		$diff = $start->diff($end);
		
		return $diff->y;
	}

	/**
	 *
	 * 	
	 * Return a fake instance of a patient
	 * 	 	 
	 */
	public static function fake($faker = NULL, $report = 0)
	{
		
		if($faker === NULL)
			$faker = Faker\Factory::create();
		$gender = $faker->randomElement(array('Male', 'Female'));
		$family_doctor = Doctor::all();
		$doctors = array();
		foreach($family_doctor as $doc) {
			$doctors[] = $doc->id;
		}
		$dob = $faker->dateTimeBetween('-105 years','-50 years')->format('Y-m-d');
		$dod = $faker->optional()->dateTimeBetween('-5 years', 'now');
		if($dod) {
			$dod = $dod->format('Y/m/d');
		}
		
		if ($gender == 'Male'){
			$prefix = $faker->titleMale;
			$first_name = $faker->firstNameMale;
			$middle_name = $faker->firstNameMale;
		} 
		elseif ($gender == 'Female'){
			$prefix = $faker->titleFemale;
			$first_name = $faker->firstNameFemale;
			$middle_name = $faker->firstNameFemale;
		}
		
		
		$fields = array(
			'pin' => $faker->unique()->numberBetween(10000, 999999),
			'sex' => $gender,
			'prefix' => $prefix,
			'first_name' => $first_name,
			'middle_name' => $middle_name,
			'last_name' => $faker->lastName,
			'is_deceased' => $faker->randomElement(array('0','0','0','0','1')),
			'date_of_death' => $dod,
			'health_card_number' => $faker->unique()->numberBetween(1000000000, 9999999999),
			'health_card_version' => $faker->lexify($string = '??'),
			'number_of_years_of_education' => $faker->numberBetween(0,30),
			'highest_education_level_completed' => $faker->randomElement(array('Primary', 'Secondary','Post-Secondary','Doctorate')),
			'first_language'=> $faker->randomElement(array('English', 'French')),
			'handedness'=> $faker->randomElement(array('Right', 'Left','Ambidextrous')),
			'veteran'=> $faker->randomElement(array('0', '1')),
			'marital_status'=> $faker->randomElement(array('0', '1','2','3','4','5')),
			'research_registry_consent'=> $faker->randomElement(array('Yes', 'No','Not yet obtained')),
			'date_of_birth' => $dob,
 		);

 		/*$fields['hash_pin'] = hash('sha256',strtolower($fields['pin']));
 		$fields['hash_last_name'] = hash('sha256',strtolower($fields['last_name']));
 		$fields['hash_first_name'] = hash('sha256',strtolower($first_name));
 		$fields['hash_health_card_number'] = hash('sha256',strtolower($fields['health_card_number']));*/

 		/*$fields['hash_pin'] = hash('sha256',strtolower($fields['pin']));
 		$fields['hash_last_name'] = $fields['last_name'];
 		$fields['hash_first_name'] = hash('sha256',strtolower($first_name));
 		$fields['hash_health_card_number'] = hash('sha256',strtolower($fields['health_card_number']));*/

		if($family_doctor) {
			$fields['family_doctor_id'] = $faker->randomElement($doctors);
		}

		$patient = new Patient($fields);

		if($report)
			$patient->fake = 1;
		return $patient;

	}

	public function hasVisitInClinic($clinic) {
		if(is_int($clinic)) {
			$clinic = Clinic::find($clinic);
			if(!$clinic) {
				return false;
			}
		}
		foreach($this->encounters as $e) {
			if($e->location == $clinic)
				return true;
		}
		return false;
	}

	public function getClinics() {
		$clinics = array();
		
		foreach($this->registrations as $registration) {

			if($registration->isActive && !in_array($registration->clinic_id, $clinics)) {
				$clinics[] = $registration->clinic_id;
			}
		}
		return $clinics;
	}
	
	public function is_valid()
	{
		$validator = Validator::make($this->attributes, static::$import_rules[0]);

		if( $validator->fails() )
		{
			
			$this->errors = $validator->errors()->getMessages();
			return false;
		}

		return true;
	}
 

}
