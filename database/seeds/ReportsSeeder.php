<?php
use Illuminate\Database\Seeder;
class ReportsSeeder extends Seeder {

    public function run()
    {
     $reports = array(
         array(
           'ABMC Visit Summary',
           'abmc_visit_summary',
           file_get_contents(__DIR__ . '/report_code/abmc_visit_summary'),
           '0',
           '0', 
           array(
            array('encounter','Encounter','Encounter'),
            array('referral','Referral','Referral')
            )
           ),



         array('ABMC PT Letterhead',
            'letterhead_sjhc_pw',
            file_get_contents(__DIR__ . '/report_code/pwmb_letterhead'),
            '0',
            '1'
            ),



         array('POP - History of Symptoms',
            'pop_hist_of_sympt',
            file_get_contents(__DIR__ . '/report_code/pop_hist_of_sympt'),
            '0',
            '1',
            array(
                array('encounter','Encounter','Encounter')
                )
            ),


         array('Medication List',
            'med-list',
            file_get_contents(__DIR__ . '/report_code/med_list'), 
            '1',
            '0',
            ),



         array('Add Snippet Button',
            'add-snippet',
            file_get_contents(__DIR__ . '/report_code/add-snippet'), 
            '0',
            '1'),



         array('MCI Report',
            'mci-report',
            file_get_contents(__DIR__ . '/report_code/mci_report'), 
            '0',
            '0', 
            array(
                array('encounter','Current Encounter','Encounter'),
                array('prev_encounter','Previous Encounter','Encounter'),
                array('orig_encounter','Original Encounter','Encounter'),
                array('referral','Referral','Referral')
                )
            ),



         array('MCI - Encounter Report Snippet',
            'mci-report-snippet',
            file_get_contents(__DIR__ . '/report_code/mci_report_snippet'),  
            '1',
            '0', 
            array(
                array('encounter','Current Encounter','Encounter'),
                array('prev_encounter','Previous Encounter','Encounter')

                )
            ),


         array('MCI - Collateral History Snippet',
            'mci-collateral-snip',
            file_get_contents(__DIR__ . '/report_code/mci_collateral_snip'),
            '1',
            '0', 
            array(
                array('encounter','Current Encounter','Encounter'),

                )
            ),


         );


        foreach($reports as $report) {
			  $rep = new App\ReportTemplate(
				  array('description'=>$report[0],
				  'filename'=>$report[1], 
				  'code'=>$report[2],
				  'is_snippet'=>$report[3],
				  'is_internal'=>$report[4]));
				$rep->save();
                if(isset($report[5])) {
                    foreach($report[5] as $variable) {
                     $var = new App\ReportTemplateVariable(
                       array('report_template'=>$rep->id,
                       'variable_name'=>$variable[0], 
                       'variable_pretty_name'=>$variable[1],
                       'model'=>$variable[2]));
                     $var->save();
                    }
                }
		  }

    }

}
