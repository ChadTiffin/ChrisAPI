<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
class ReportTemplateVariable extends Chrismodel
{
	public $table = 'report_template_variables';

	public function report() {
		return $this->belongsTo('Report', 'report_template');
	}
}