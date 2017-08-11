<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Chrismodel {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password' ,'remember_token');

	/*
	*	Defines what items are assignable with fill or the model constructor
	*
	*	@var array
	*/
	protected $fillable = array('email', 'username', 'role', 'first_name', 'last_name', 'phone_number', 'pager_number', 'title', 'actions', 'position');
	protected static $unguarded = false;

	protected $appends = array('DisplayName','GroupName','clinicName');

	public static $_relations = array("group",'clinic');
	
	public function scopeClinicalStaff($query)
	{
		return $query->where('role', '!=', 'root');
	}

	public function scopeDoctors($query)
	{
		return $query->clinicalStaff()->wherePosition('doctor');
	}

	public function group() {
		return $this->belongsTo(\App\PermissionGroup::class,'group_id');
	}

	public function clinic()
	{
		return $this->belongsToMany("Clinic",'user_clinics');
	}

	public function canAccessRoute($path) {
		$group = $this->group;

		$route_perms = $group->routePermissions;

		$allowed = false;

		//search for partial match of disallowed
		/*
		EX.
		if route == '/patient/patients/summary/6550' and a router_perm entry of
		'/patient/patients/summary' exists with access=0,
		then route is denied
		
		*/

		//look for blanket wildcard routes first
		foreach ($route_perms as $perm) {
			if ($perm['route_path'] == "*") {
				$allowed = true;
				break;
			}
		}

		foreach($route_perms as $perm) {
			if ($perm['route_path'] && strpos($path, $perm['route_path']) && $perm['route_access'] == 1) //partial positive match found, allow
				$allowed = true;
		}

		//check for exact matching routes with positive access, which over-ride partial matches
		foreach($route_perms as $perm) {

			if ($perm['route_path']) {
			
				if ($path == $perm['route_path'] && $perm['route_access'] == 1) { //exact positive match found, this supercedes all, so break out of loop
					$allowed = true;
					break;
				}
				elseif ($path == $perm['route_path'] && $perm['route_access'] == 0) {//exact negative match found, not allowed
					$allowed = false;
				}
			}
		}
		
		return $allowed;
	}

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

 	public function setPasswordAttribute($password)
 	{
   		$this->attributes['password'] = Hash::make($password);
  	}

	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return 'remember_token';
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	public function memberOfClinic($clinic) {
		if(is_int($clinic)) {
			$clinic = Clinic::find($clinic);
			if(!$clinic) {
				return false;
			}
		}
		$group = $this->group;
		foreach($group->clinics as $c) {
			if($c === $clinic) {
				return true;
			}
		}
		
		return false;
	}

	public function getClinics() {
		$clinics = array();
		$group = $this->group;
		foreach($group->clinics as $c) {
			if(!in_array($c->id, $clinics))
				$clinics[] = $c->id;
		
		}
		foreach($this->clinic as $c) {
			if(!in_array($c->id, $clinics))
				$clinics[] = $c->id;
		}
	
		return $clinics;
	}

	public function getResearchTrials() {
		$trials = array();
		$group = $this->group;
		foreach($group->researchTrials as $c) {
			if(!in_array($c->id, $trials))
				$trials[] = $c->id;
		}

		return $trials;
	}

	public function getDisplayNameAttribute() {
		$ret = $this->first_name . " " . $this->last_name;
		if(strlen(trim($ret)) == 0) {
			$ret = $this->username;
		}
		return $ret;
	}

	public function getGroupNameAttribute() {
		if($this->group_id > 0){
			$group = PermissionGroup::find($this->group_id);
			if(isset($group->name))
				return $group->name;
		}
		else
			return "No Group Assigned";
	}

	public function getclinicNameAttribute()
	{
		if($this->clinic_id > 0){
			$clinic = Clinic::find($this->clinic_id);
			if(isset($clinic->id))
				return $clinic->id;
		}
		else
			return "No Clinic Assigned";
	}

}
