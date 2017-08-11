<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
	
class LivingArrangement extends Chrismodel
{
	public $table = 'living_arrangements';

	public static $identifiable = array('address', 'dwelling_type', 'telephone', 'email', 'postal_code_last3','province', 'city', 'PostalCode');

	protected $fillable = array(
		'patient_id',
		'address',
		'city',
		'province',
		'country',
		'PostalCode',
		'dwelling_type',
		'telephone',
		'email',
		'moved_in',
		'moved_out',
		'current_arrangement'
	);

	public $appends = array('PostalCode', 'LivesWith');

	public static $_relations = array('cohabitants');

	public $validation_rules = array(
		'address' => 'required',
		'city' => 'required',
		'province' => 'required',
		'country' => 'required',
		'dwelling_type' => 'required',
		'telephone' => 'required',
		'current_arrangement' => 'required',
		'moved_in' => 'required'
	);

	protected static $import_rules = array(array(
			'address' => 'required',
			'city' => 'required',
			'province' => 'required',
			'country' => 'required',
			'postal_code_first3' => 'required',
			'telephone' => 'required',
			'current_arrangement' => 'required',

			),
	);




	public function get_rules(){
		return array();
	}

	public function getPostalCodeAttribute() {
		return $this->postal_code_first3 . $this->postal_code_last3;
	}

	public function getLivesWithAttribute() {
		$ret = $this->cohabitants;
		return $ret;
	}
	public function setLivesWithAttribute() {
		unset($this->LivesWith);
	}


	public function setAddressAttribute($value) {
		$this->attributes['address'] = ucwords($value);
	}
	public function setCityAttribute($value) {
		$this->attributes['city'] = ucwords($value);
	}
	public function setProvinceAttribute($value) {
		$this->attributes['province'] = ucwords($value);
	}
	public function setCountryAttribute($value) {
		$this->attributes['country'] = ucwords($value);
	}


	public function setPostalCodeAttribute($postal_code) {
		$this->postal_code_first3 = substr($postal_code, 0, 3);
		$this->postal_code_last3 = substr($postal_code, 3);

	}
	/********************************************
	 * ORM Relationships
	 ********************************************/

	public function patient()
	{
		return $this->belongsTo('Patient');
	}

	public function cohabitants() {
		return $this->belongsToMany('Contact', 'living_arrangements_contacts');
	}
	/**
	 *
	 * 	
	 * Return a fake instance of a patient
	 * 	 	 
	 */
	public static function fake($faker = NULL, $report = 0, $seed = 0)
	{

		if($faker == NULL)
			$faker = Faker\Factory::create();
		
		$indate = new DateTime($faker->dateTimeBetween('-10 years','now')->format('Y/m/d'));
		
		

		$fields = array(
			'address' => '123 Anywhere Street',
			'dwelling_type' => $faker->randomElement(array('Condominium','House','Duplex','Triplex')),
			'telephone' => $faker->phoneNumber,
			'city' => 'Randomtown',
			'province' => 'Ontario',
			'country' => 'Canada',
			'email' => $faker->email,
			'moved_in' => $indate,
			'current_arrangement' => '1',
					

		);

		/* ---- This is a hack to prevent creating contacts when seeding --*/
		if($seed != 1){		
			$contacts = array();
			$num = $faker->numberBetween(1, 4);
			for($i=0;$i<$num;$i++) {
				$contacts[] = Contact::fake(NULL, 1)->ToArray();
			}
			$fields['cohabitants'] = $contacts;
		}
		return new LivingArrangement($fields);

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
