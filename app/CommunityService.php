<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommunityService extends Chrismodel
{
	public $validation_rules = array(
		'community_service_type_id' => 'required',
		'hours_per_visit' => 'required',
		'visits_per_week' => 'required',
	);
	public static $_relations = array('communityServiceType');

	protected $appends = ['CommunityServiceName'];

	public function communityServiceType()
	{
		return $this->belongsTo('CommunityServiceType');
	}

	public function patient()
	{
		return $this->belongsTo('Patient');
	}

	public function getCommunityServiceNameAttribute()
	{
		$service_type = CommunityServiceType::find($this->community_service_type_id);
		return $service_type->service_type;
	}
}
