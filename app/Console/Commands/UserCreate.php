<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UserCreate extends Command {

  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'user:create';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Create a new user';

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
    $email = $this->ask("email:");
	
	$username = $this->ask("username:");

    $password = $this->secret("password:");

    $user = new User(compact('email','username'));

    $user->password = $password;

    $this->info('Please select a group, or choose 0 for no group');

    $groups = PermissionGroup::all();
    foreach($groups as $g) {
      $this->info($g->name . ' - ' . $g->id);
    }
    $group = $this->ask('Enter group id:');



    if( $user->save() )
    {
      if($group != 0) {
        $user->groups()->attach($group);
        $user->save();
      }
      $this->info("$user->username created.");
    }
    else
    {
      $this->error("Could not create user.");
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
    );
  }

}
