<?php
use Illuminate\Database\Seeder;
class GaitAidSeeder extends Seeder {

    public function run()
    {
    	$gait_aids = array(
   		            	array('name' => '4 Wheel Walker'),
						array('name' => '2 Wheel Walker'),
						array('name' => 'Cane'),
						array('name' => 'Shoes'),
						array('name' => 'Wheel Chair')
		);
		foreach($gait_aids as $g) {
			$ga = new App\GaitAid($g);
			$ga->save();
		}

    }

}

