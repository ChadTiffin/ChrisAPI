<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DictionarySeed extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'dictionary:seed';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Read all the tables in MySQL and create a manifest of them in the dictionary_tables and dictionary_fields tables.';

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
	 * @return mixed
	 */
	public function fire()
	{
		//

		//get comments
		$loaded_classes = array();
		$files = glob(app_path() . "/database/migrations/*.php");

		$patterns = array('/use (\S+)/', '/<\?php/','/->default/');
		$replacements = array('','', '->def_value');

		$comments = [];
		foreach($files as $file) {

			//echo "On file: " . $file."\n";
			$data = file_get_contents($file);
			$data = preg_replace($patterns, $replacements, $data);	

			$class_name = preg_match('/class (\S+) extends/i', $data, $matches);
			$loaded_classes[] = $matches[1];

			if (class_exists($matches[1])) {
				$migration = new $matches[1]();

				if (method_exists($migration,'get_comments')) {
					$table_comments = $migration->get_comments();

					$comments[key($table_comments)] = $table_comments[key($table_comments)];
				}
			}
		}

		$tables = DB::select('SHOW TABLES');

		foreach ($tables as $table) {

			$table_name = $table->Tables_in_geriatric_medicine;

			$table_description = "";
			if (isset($comments[$table_name][0]))
				$table_description = $comments[$table_name][0];

			DB::table('dictionary_tables')
				->insert([
					'table_name' => $table_name,
					'description' => $table_description
				]);

			$table_id = DB::getPdo()->lastInsertId();

			$table_columns = DB::select(DB::raw('DESCRIBE '.$table_name));

			foreach ($table_columns as $column) {

				$col_description = "";
				if (isset($comments[$table_name][1][$column->Field]))
					$col_description = $comments[$table_name][1][$column->Field];
				
				DB::table('dictionary_fields')
					->insert([
						'table_id' => $table_id,
						'field_name' => $column->Field,
						'type' => $column->Type,
						'nullable' => $column->Null,
						'description' => $col_description
					]);
			}
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
			//array('example', InputArgument::REQUIRED, 'An example argument.'),
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
			//array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
