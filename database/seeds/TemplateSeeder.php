<?php
use Illuminate\Database\Seeder;
class TemplateSeeder extends Seeder {

    public function run()
    {
    	
        $encounter_report_views = array();
        foreach(glob("../app/views/patient/encounters/*.php") as $file)
        {
            $file = pathinfo($file, PATHINFO_FILENAME);
            $file = str_replace(".blade", "", $file);
            $file = str_replace("_", " ", $file);
            $file = ucwords($fancyFile);
            $file = str_replace(" ", "", $file);
            $encounter_report_views[] = $file;
        }

        $templates = array('ABMC - Initial Visit','MCI Clinic','Reporting');
    	$viewsets = array(
    		'ABMC - Histories'=> array(
    			'social_history', 
    			'hobbies', 
    			'employment_history', 
    			'medical_surgical_history',
    			'etiological_factors',
    			'mental_health_history', 
    			'family_history', 
    			'history_of_symptoms', 
    			),
    		'ABMC - Collaborative History' => array(
    			'safety_risks',
    			'zarit_burden_test',
    			'lawton_brody_adls_psms'
    			),
    		'ABMC - Systems Review'=> array(
    			'behavioural_psychological_symptoms',
    			'systems_review_current',
    			'systems_review_neurological',
    			'systems_review_respiratory',
    			'systems_review_cardiovascular',
    			'systems_review_gastro_intestinal',
    			'systems_review_genitourinary',
    			'systems_review_skin',
    			'systems_review_musculoskeletal',
    			'systems_review_falls',
    			),
    		'ABMC - Physical Exam' => array(
    			'general_physical_examination',
    			'vision_examination',
    			'neurological_examination',
    			'tone_power_joint_examination',
    			'cerebellar_test',
    			'primitive_reflexes',
    			'deep_tendon_reflexes',
    			'heent_examination',
    			'respiratory_examination',
    			'cardiovascular_examination',
    			'giu_examination',
    			'musculoskeletal_examination',
    			'gait_examination',
    			),
    		'ABMC - Assessments' => array(
    			'clock_draw',
    			'cornell_depression_scale',
    			'geriatric_depression_scale',
    			'mini_mental_state_examination',
    			'montreal_cognitive_assessment_v1',
    			'trails_a_test',
    			'trails_b_test'
    			),
    		'ABMC - Diagnosis' => array(
    			'differential_diagnosis'
    			),

            /*
    		'Reporting' => array('adcs_adls',
    			'lawton_brody_adls_psms',
    			'behavioural_neurology_assessments',
    			'behavioural_psychological_symptoms',
    			'cardiovascular_examination',
    			'cerebellar_test',
    			'clinical_dementia_rating',
    			'clock_draw',
    			'cornell_depression_scale',
    			'deep_tendon_reflexes',
    			'differential_diagnosis',
    			'functional_assessment_questionnaire',
    			'gait_examination',
    			'general_physical_examination',
    			'geriatric_depression_scale',
    			'giu_examination',
    			'heent_examination',
    			'intercurrent_event',
    			'history_of_symptoms',
    			'family_history',
                'mini_mental_state_examination',
    			'modified_mini_mental_state_test',
    			'montreal_cognitive_assessment_v1',
    			'montreal_cognitive_assessment_v2',
    			'montreal_cognitive_assessment_v3',
    			'musculoskeletal_examination',
    			'neurological_examination',
    			'primitive_reflexes',
    			'respiratory_examination',
    			'safety_risks',
    			'status_of_memory_followup',
    			'systems_review_cardiovascular',
    			'systems_review_current',
    			'systems_review_falls',
    			'systems_review_gastro_intestinal',
    			'systems_review_genitourinary',
    			'systems_review_musculoskeletal',
    			'systems_review_neurological',
    			'systems_review_respiratory',
    			'systems_review_skin',
    			'tone_power_joint_examination',
    			'trails_a_test',
    			'trails_b_test',
    			'vision_examination',
    			'zarit_burden_test'),*/
            'Reporting' => $encounter_report_views,

			'MCI Clinic - Form' => array(
				'medical_surgical_history',
				'history_of_symptoms',
				'safety_risks',
				'social_history',
				'systems_review_current',
				'systems_review_cardiovascular',
				'hobbies',
				'general_physical_examination',
				'differential_diagnosis'


				),
			'MCI Clinic - Assessments' => array(
				'clock_draw',
				'cornell_depression_scale',
				'geriatric_depression_scale',
				'mini_mental_state_examination',
				'montreal_cognitive_assessment_v1',
				'trails_a_test',
				'trails_b_test'
				),
			'MCI Clinic - Collaborative History' => array(
				'safety_risks',
				'zarit_burden_test',
				'lawton_brody_adls_psms'
				),
			);

		$template_ids = array();
		$viewset_ids = array();

		$template_viewsets = array('ABMC - Initial Visit' => array(
			'ABMC - Histories',
			'ABMC - Collaborative History',
			'ABMC - Systems Review',
			'ABMC - Physical Exam',
			'ABMC - Assessments',
			'ABMC - Diagnosis',
			), 
			
			'Reporting' => array('Reporting'),
			
			'MCI Clinic' => array(
				'MCI Clinic - Form',
				'MCI Clinic - Assessments',
				'MCI Clinic - Collaborative History'
				)
		);
		
		foreach($viewsets as $viewset_name => $views) {
			$viewset = new App\EncounterViewset();
			$viewset->name = $viewset_name;
			$viewset->save();
			$viewset_ids[$viewset_name] = $viewset;

			$i = 0;
			foreach($views as $view) {
				$viewset_form = new App\ViewsetForm();
				$viewset_form->form_name = $view;
				$viewset_form->sort = $i++;
				$viewset_form->viewset_id = $viewset->id;
				$viewset_form->save();
			}
		}

		foreach($templates as $template) {
			$template_obj = new App\EncounterTemplate();
			$template_obj->name = $template;
			$template_obj->save();
			$template_ids[$template] = $template_obj;
		}

		foreach($template_viewsets as $template => $viewsets) {
			$i = 0;
			foreach($viewsets as $viewset) {
				$template_ids[$template]->viewsets()->attach($viewset_ids[$viewset]->id);
				$form = App\EncounterViewset::find($viewset_ids[$viewset]->id);
						$form->sort = $i++;
						$form->save();
			}
		}
    }

}