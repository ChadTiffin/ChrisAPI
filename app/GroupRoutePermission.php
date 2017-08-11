<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupRoutePermission extends Chrismodel
{
	public $table = 'group_route_permissions';

	public $hidden = ['created_at','deleted_at','updated_at','modified_by','created_by'];

	public function group() {
		return $this->belongsTo('PermissionGroup');
	}
}
