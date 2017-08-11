<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Occupation extends Chrismodel
{
	protected static $unguarded = true;
	public $table = 'occupations';
	public $timestamps = false;
}
