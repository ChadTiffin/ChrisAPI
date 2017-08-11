<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataDictionary extends MongoModel
{
	protected $collection = 'data_dictionary';

	public $permissions_skipped = true;

	public $validation_rules = [
		"encounter_variable" => "required"
	];
	
	public function save(array $options = array())
	{

		if( Auth::user() && get_called_class() !== 'User' )
		{
			if( ! $this->exists )
			{
				$this->created_by = Auth::user()->id;
			}

			$this->modified_by = Auth::user()->id;
		}

		/**
		 * Fire the pre save hook
		 */

		return parent::save($options);
	}

	public static function getPermissions($user = null) {

/* This needs to be created - see chrisModel */

//		if(App::runningInConsole()) {
			return array('read' => true, 'update' => true, 'create' => true, 'delete' => true, 'identifiable' => true);
	//	}
		$permissions = array('read' => false, 'update' => false, 'create' => false, 'delete' => false, 'identifiable' => false);
		$class = get_called_class();

		if($user === null) {
			$user = Auth::user();
		}
		if($user && Auth::check() && isset($user['attributes']['id'])) {

			//stupid work around from Chrismodel::__get overriden can't use any model accessors, etc
			$groups = DB::table('user_groups')->where('user_id','=',$user['attributes']['id'])->get();
			$group_ids = array();
			foreach($groups as $group) {
				$group_ids[] = $group->group_id;
			}
			
			$match = 0;
			foreach($group_ids as $group_id) {
				$mperms = DB::table('group_model_permissions')->where('group_id','=',$group_id)->get();
				foreach($mperms as $perm) {
					// This allows for * to be use as a wildcard if there is no entry.
					if($perm->model_name == '*'){
						$permissions['read'] = $perm->read == '1' ? true : false;
						$permissions['create'] = $perm->create == '1'? true : false;
						$permissions['update'] = $perm->update == '1'? true : false;
						$permissions['delete'] = $perm->delete == '1'? true : false;
						$permissions['identifiable'] = $perm->identifiable == '1'? true : false;
					}

					if(($perm->model_name == $class) && ($perm->model_name != null) && ($perm->model_name != '*')) {
						$permissions['read'] = $perm->read == '1' ? true : false;
						$permissions['create'] = $perm->create == '1'? true : false;
						$permissions['update'] = $perm->update == '1'? true : false;
						$permissions['delete'] = $perm->delete == '1'? true : false;
						$permissions['identifiable'] = $perm->identifiable == '1'? true : false;
					}
				}
			}
		}
		return $permissions;
	}


	public function getValidationRules() {
		return;
	}


}


