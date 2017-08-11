<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataDictionarySqlTable extends Eloquent
{
	public $table = "dictionary_tables";

	public function fields()
	{
		return $this->hasMany('DataDictionarySqlField','table_id');
	}
}
