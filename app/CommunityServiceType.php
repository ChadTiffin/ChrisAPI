<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommunityServiceType extends Chrismodel
{
	public $table = "community_service_types";

	public $label = "Community Service Types";
	public $label_single = "Community Service Type";
	public $table_fields = [
		["label" => "Service Type", "key" => "service_type"],
	];


}
