<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvailableSuggestion extends Chrismodel {
	public $label = "Recommendations";
	public $label_single = "Recommendation";
	public $table_fields = [
		["label" => "Recommendation", "key" => "suggestion"],
	];
}
