<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class DrugName extends Chrismodel
{
	public $table = 'drug_product';

	public $label = "Drugs";
	public $label_single = "Drug";
	public $table_fields = [
		["label" => "Generic (Trade) Name", "key" => "brand_name"],
	];

	public function setBrandNameAttribute($value) {
		$this->attributes['brand_name'] = ucwords($value);
	}


}
