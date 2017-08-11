<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Chrismodel
{

	public $label = "External Doctors";
	public $label_single = "Doctor";
	public $table_fields = [
		["label" => "Name", "key" => "name"],
		["label" => "Address", "key" => "address"],
		["label" => "Telephone", "key" => "telephone"],
		["label" => "Type", "key" => "type"]
	];

	public $validation_rules = array(
		'name' => 'required',
	);
	public static function findOrCreateByName($name)
	{
		$doctor = Doctor::whereName($name)->first();

		if(empty($doctor))
		{
			$doctor = new Doctor(array('name' => $name));
			$doctor->save();
		}

		return $doctor;
	}

	public function setNameAttribute($value) {
		$this->attributes['name'] = ucwords($value);
	}
	public function setAddressAttribute($value) {
		$this->attributes['address'] = ucwords($value);
	}
	public function setTypeAttribute($value) {
		$this->attributes['type'] = ucwords($value);
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
		$gender = $faker->randomElement(array('male', 'female'));
		$name = $faker->unique()->firstName($gender) . " " . $faker->unique()->lastName($gender);
		$type = $faker->randomElement(array('Family Doctor', 'Surgeon', 'Geriatrician'));
		$fields = array(
			'name' => $name,
			'telephone' => $faker->phoneNumber,
			'cell_phone' => $faker->optional()->phoneNumber,
			'address' => $faker->address,
			'type' => $type

		);

		return new Doctor($fields);

	}
}
