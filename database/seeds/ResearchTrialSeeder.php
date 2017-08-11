<?php
use Illuminate\Database\Seeder;
class ResearchTrialSeeder extends Seeder {

    public function run()
    {
    	$trials = array(
    		array('#445522', 'Trial Name', 'Some Trial Description')
		);

        foreach($trials as $trial) {
        	$c = new App\ResearchTrial(array('study_ethics_number' => $trial[0], 'study_short_name' => $trial[1], 'study_description' => $trial[2]));
        	$c->save();
        }
    }

}