<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ClinicSeeder extends Seeder {

    public function run()
    {
    	$clinics = array(
    		array('ABMC Clinic', '550 Wellington Road, London, ON N6C 0A7', 'A2182', 'Parkwood Institute - Main Building')
		);

        foreach($clinics as $clinic) {
        	$c = new App\Clinic(array('name' => $clinic[0], 'address' => $clinic[1], 'room' => $clinic[2],'site' => $clinic[3]));
        	$c->save();
        }
    }

}