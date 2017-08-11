<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Chrismodel
{

	public $validation_rules = [
		'name' => 'required',
	];

    public $label = "Clinics";
	public $label_single = "Community Service";
	public $table_fields = [
		["label" => "Name", "key" => "name"],
		["label" => "Room", "key" => "room"],
		["label" => "Site", "key" => "site"],
		["label" => "Address", "key" => "address"]
	];

}
