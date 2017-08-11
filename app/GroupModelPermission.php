<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupModelPermission extends Chrismodel
{

	public static $booleans = array('read', 'write', 'identifiable', 'delete');

	public $table = 'group_model_permissions';

	public function group() {
		return $this->belongsTo('PermissionGroup');
	}


}
