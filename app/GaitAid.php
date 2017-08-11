<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class GaitAid extends Chrismodel
{
	public $table = 'gait_aids';

	public $label = "Gait Aids";
	public $label_single = "Gaid Aid";
	public $table_fields = [
		["label" => "Name", "key" => "name"],
	];

}
