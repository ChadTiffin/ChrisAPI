<?php

class EncounterTemplate extends ChrisModel
{

	public $collection = 'encounter_templates';

	/*
	protected $with = array(
		'creator',
	);

	public static $_relations = array('viewsets');

	public function viewsets() {
		return $this->belongsToMany('EncounterViewset', 'encounter_template_viewsets', 'template_id', 'viewset_id');
	}

	public function getAllFormsAttribute() {
		$viewsets = $this->viewsets;
		$forms = array();
		foreach($viewsets as $v) {
			foreach($v->forms as $form) {
				$forms[] = $form;
			}
		}
		return $forms;
	}

	//if this is a patient viewset, there will be 1 enconuter ONLY since it was cloned
	public function encounter() {
		
	}

	public function creator()
	{
		return $this->belongsTo('User', 'created_by');
	}

	public function lastEditor()
	{
		return $this->belongsTo('User', 'modified_by');
	}
	
	public static function findReportTemplate() {

		return EncounterTemplate::where('patient_encounter','=',0)->where('name','=','Reporting')->get()->first();
	}*/
}
