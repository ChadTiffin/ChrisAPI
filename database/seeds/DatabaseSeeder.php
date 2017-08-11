<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        Eloquent::unguard();

		$this->call('DiagnosisSeeder');
//		$this->call('ReportsSeeder');
//		$this->call('TemplateSeeder');
		$this->call('ClinicSeeder');
		$this->call('OccupationSeeder');
	 	$this->call('DrugSeeder');
		$this->call('GaitAidSeeder');
		$this->call("DoctorSeeder");

		 //if(!App::environment('staging', 'production')) {

		 	//Seeds groups, and users (root, doctor on non-sso, learna/lindsayj on sso servers)
		 	$this->call('GroupSeeder');
		 	$this->call('UserSeeder');
		 //}
		if(!App::environment('staging', 'production')) {
			$this->call('NewsSeeder');
			$this->call('ResearchTrialSeeder');
			$this->call('CommunityServiceSeeder');
			$this->call('RecommendationSeeder');
		}



    }
}
