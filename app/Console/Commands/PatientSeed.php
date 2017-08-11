<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class PatientSeed extends Command {

  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'patient:seed';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Fake some new patients';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return void
   */
  public function fire()
  {
    $numpatients = $this->option('number');

		$faker = Faker\Factory::create();
		for($i=0;$i<$numpatients;$i++) {
			$patient = Patient::fake($faker);
			$patient->save();



			$num_referrals = $faker->numberBetween(1, 2);

			$referral = null;

			for($j=0;$j<$num_referrals;$j++) {
				
				$referral = Referral::fake($faker);
				$referral->patient_id = $patient->id;
				$referral->referring_physician_id = $patient->family_doctor_id;
				$referral->save();
			}

      $num_contacts = $faker->numberBetween(1, 5);

      for($j=0;$j<$num_contacts;$j++) {     
        $contact = Contact::fake($faker);
      
        $contact->patient_id = $patient->id;
        $contact->save();

      }

			$num_encounters = $faker->numberBetween(1, 3);

			for($j=0;$j<$num_encounters;$j++) {
				$encounter = Encounter::fake($faker);
				$encounter->patient_id = $patient->id;
				$encounter->referral_id = $referral->id;
				$physicians = User::doctors()->get()->first();
				$encounter->clinical_staff_id = $physicians->id;


				$template = EncounterTemplate::find($encounter->template_id);
				$template = clone_template($template)->id; //clone the view

				$encounter->template_id = $template; //TODO: needs to be fixed...
				$encounter->save();

        $contacts = Contact::where('patient_id','=',$patient->id)->get();
        $contact_ids = array();
        $contacts->each(function($contact) use(&$contact_ids) {
          $contact_ids[] = $contact->id;
        });

        foreach($contact_ids as $id)
          $encounter->accompanyingContacts()->attach($id);

        $encounter->save();
				

			}

			$num_arrangments = 1;//$faker->numberBetween(0, 5);

			for($j=0;$j<$num_arrangments;$j++) {
				$livingarrangements = LivingArrangement::fake($faker, 0, 1);
				$livingarrangements->patient_id = $patient->id;
				$livingarrangements->save();
            }
            $count = $i + 1;
            $this->info('Patient '. $count . ' seeded! ----- '. (round($count/$numpatients,4)*100) . "%");//This echoes which patient has been seeded and % complete
		}

	}

  /**
   * Get the console command arguments.
   *
   * @return array
   */
  protected function getArguments()
  {
    return array(
    );
  }

  /**
   * Get the console command options.
   *
   * @return array
   */
  protected function getOptions()
  {
    return array(
    	array('number', null, InputOption::VALUE_OPTIONAL, 'Number of doctors to seed', 5)
    );
  }

}
