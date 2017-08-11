<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
class Contact extends Chrismodel
{
	public $validation_rules = array(
		'name' => 'required',
		'gender' => 'required',
		'relationship' => 'required',
		'frequency_of_contact' => 'required',
		'consent_to_speak' => 'required',
		'primary_caregiver' => 'required',
		'power_of_attorney_personal_care' => 'required',
		'power_of_attorney_property' => 'required',
		'deceased' => 'required'
	);

	public function setNameAttribute($value) {
		$this->attributes['name'] = ucwords($value);
	}
	public function setAddressAttribute($value) {
		$this->attributes['address'] = ucwords($value);
	}



	/**
	 *
	 * 	
	 * Return a fake instance of a contact
	 * 	 	 
	 */
	public static function fake($faker = NULL, $report = 0)
	{
		$contacts = array('Daily', 'Weekly', 'Monthly', 'Yearly', 'Rarely');
		$relationships = array('Spouse', 'Child','Parent','Grandparent','Family','Friend','Neigbor','Acquaintance');

		if($faker == NULL)
			$faker = Faker\Factory::create();
		$gender = $faker->randomElement(array('Male', 'Female'));


		$dod = $faker->optional()->dateTimeBetween('-5 years', 'now');
		if($dod) {
			$dod = new DateTime($dod->format('Y'));
		}
		$fields = array(
			'gender' => $gender,
			'name' => $faker->name($gender),
			'deceased' => $faker->randomElement(array('0','0','0','0','1')),
			'year_deceased' => $dod,
			'address' => $faker->address,
			'telephone' => $faker->optional()->phoneNumber,
			'email' => $faker->email,
			'frequency_of_contact' => $faker->randomElement($contacts),
			'relationship' => $faker->randomElement($relationships),
			'primary_caregiver' => $faker->numberBetween(0,1),
			'consent_to_speak' => $faker->numberBetween(0,1),
			'power_of_attorney_property' => $faker->numberBetween(0,1), 	
			'power_of_attorney_personal_care' => $faker->numberBetween(0,1),
		);

		if($dod) {
			$fields['deceased'] = 1;
		} else $fields['deceased'] = 0;

		return new Contact($fields);

	}
}
