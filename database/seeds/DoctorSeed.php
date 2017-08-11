<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DoctorSeed extends Command {

  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'doctor:seed';

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
    	$numdocs = $this->option('number');

    	$faker = Faker\Factory::create();
    	for($i=0;$i<$numdocs;$i++) {
    		$doc = Doctor::fake($faker);
    		$doc->save();
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
