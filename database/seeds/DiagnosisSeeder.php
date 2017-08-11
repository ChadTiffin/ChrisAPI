<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class DiagnosisSeeder extends Seeder {

    public function run()
    {
    	$diagnoses = array(
    		"Subjective Cognitive Impairment (SCI)",
			"Amnestic MCI - memory impairment only",
			"Amnestic MCI - memory impairment plus one or more other domains",
			"Non-amnestic MCI - single domain",
			"Non-amnestic MCI - multiple domains",
			"Probable AD (NINCDS/ADRDA)",
			"Possible AD (NINCDS/ADRDA)",
			"Dementia with Lewy bodies",
			"Vascular dementia (NINDS/AIREN Probable)",
			"Vascular dementia (NINDS/AIREN Possible)",
			"Alcohol-related dementia",
			"Dementia of undetermined etiology",
			"Frontotemporal degeneration (behavioral/executive variant)",
			"Primary progressive aphasia (semantic variant)",
			"Primary progressive aphasia (non-fluent variant)",
			"Progressive supranuclear palsy",
			"Corticobasal degeneration",
			"Posterior Cortical Atrophy",
			"Huntington's disease",
			"Prion disease",
			"Cognitive dysfunction from medications",
			"Cognitive dysfunction from medical illnesses",
			"Depression - Major",
			"Depression - Minor",
			"Other major psychiatric illness",
			"Down's syndrome",
			"Parkinson's disease",
			"Parkinson's disease/Lewy body disease",
			"Parkinson's disease dementia",
			"Stroke",
			"Hydrocephalus",
			"Traumatric brain injury",
			"CNS neoplasm",
		);

        foreach($diagnoses as $diagnosis) {
        	$diag = new App\Diagnosis(array('diagnosis' => $diagnosis));
        	$diag->save();
        }
    }

}