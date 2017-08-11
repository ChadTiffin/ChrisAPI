<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class CommunityServiceSeeder extends Seeder {

    public function run()
    {
    	$community_services = array(
    		array('McCormick Home - Adult Day Program'),
            array('Alzheimer Society - Day Program'),
            array('Dearness Home - Adult Day Program and Wellness Centre'),
            array('Salvation Army - London - Adult Day Program'),
            array('VON - Adult Day Program'),
            array('Third Age Outreach')
		);

        foreach($community_services as $service) {
        	$c = new App\CommunityServiceType(array('service_type' => $service[0]));
        	$c->save();
        }
    }

}