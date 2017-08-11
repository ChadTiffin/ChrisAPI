<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Chrismodel
{

	public $table = 'groups';

	//users removed to prevent infinite recursion, plus i don't think anything needs all a groups users atm
	public static $_relations = array("routePermissions", "modelPermissions", "clinics", "researchTrials");

	public function users() {
		return $this->belongsTo(\App\User::class, 'group_id');
	}
	public function clinics() {
		return $this->belongsToMany(\App\Clinic::class, 'group_clinics', 'group_id', 'clinic_id');
	}
	public function researchTrials() {
		return $this->belongsToMany(\App\ResearchTrial::class, 'group_research_trials', 'group_id', 'research_trial_id');
	}
	public function routePermissions() {
		return $this->hasMany(\App\GroupRoutePermission::class, 'group_id', 'id');
	}
	public function modelPermissions() {
		return $this->hasMany(\App\GroupModelPermission::class, 'group_id', 'id');
	}

}
