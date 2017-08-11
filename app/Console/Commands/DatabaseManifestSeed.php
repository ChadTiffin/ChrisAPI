<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

$GLOBALS['migration_code'] = <<<'EOD'
class Migration {

	public function get_comments() {
		return array();
	}
};
class Column {
	public $name;
	public $increments = false;
	public $type; //integer, foreign, etc
	public $primary = false;
	public $length = 0;

	public $fk_column;
	public $fk_table;

	public $unique = false;

	public $default_value = NULL;

	public $nullable = false;
	public $unsigned = false;

	function __construct($type, $name) {
		$this->name = $name;
		$this->type = $type;
	}

	public function unsigned() {
		$this->unsigned = true;
		return $this;
	}	
	public function def_value($val) {
		$this->default_value = $val;
		return $this;
	}
	public function nullable() {
		$this->nullable = true;
		return $this;
	}
	public function references($column) {
		$this->fk_column = $column;
		return $this;
	}
	public function length($len) {
		$this->length = $len;
		return $this;
	}
	public function on($table) {
		$this->fk_table = $table;
		return $this;
	}
	public function unique() {
		$this->unique = true;
		return $this;
	}
	public function primary() {
		$this->primary = true;
		return $this;
	}
}
class Table {

	public $name;

	public $columns = array();

	public $comments = array();

	function __construct($name) {
		$this->name = $name;
	}
	public function get_column($name) {
		foreach($this->columns as $column) {
			if($column->name == $name)
				return $column;
		}
		return NULL;
	}
	public function increments($name) {
		$column = new Column('integer', $name);
		$column->increments = true;
		$column->primary = true;
		$this->columns[] = $column;
		return $column;
	}
	public function longText($name) {
		$column = new Column('longtext', $name);
		$this->columns[] = $column;
		return $column;
	}
	public function string($name) {
		$column = new Column('text', $name);
		$this->columns[] = $column;
		return $column;
	}
	public function text($name) {
		$column = new Column('text', $name);
		$this->columns[] = $column;
		return $column;
	}
	public function timestamp($name) {
		$column = new Column('timestamp', $name);
		$this->columns[] = $column;
		return $column;
	}
	public function integer($name) {
		$column = new Column('integer', $name);
		$this->columns[] = $column;
		return $column;
	}
	public function date($name) {
		$column = new Column('date', $name);
		$this->columns[] = $column;
		return $column;
	}
	public function datetime($name) {
		$column = new Column('datetime', $name);
		$this->columns[] = $column;
		return $column;
	}
	public function float($name) {
		$column = new Column('float', $name);
		$this->columns[] = $column;
		return $column;
	}
	public function double($name) {
		$column = new Column('double', $name);
		$this->columns[] = $column;
		return $column;
	}
	public function boolean($name) {
		$column = new Column('tinyint', $name);
		$this->columns[] = $column;
		return $column;
	}
	public function foreign($name) {
		//$column = new Column('foreignkey', $name);
		//$this->columns[] = $column;
		$column = $this->get_column($name);
		return $column;
	}

	public function primary($name) {
		$column = $this->get_column($name);
		if($column !== NULL) {
			$column->primary = true;
		}
	}
	public function unique($name) {
		$column = $this->get_column($name);
		if($column !== NULL) {
			$column->unique = true;
		}
	}

	public function timestamps() {

	}

}



function write_table_xml($table) {

	$writer = $GLOBALS['writer'];

	$writer->startElement('table');
	$writer->writeAttribute('name', $table->name);

	$comments = $GLOBALS['comments'];


	
	
	if(isset($comments) && isset($comments[$table->name])) {
		$writer->writeAttribute('comment', $comments[$table->name][0]);
		$comments = $comments[$table->name][1];
	}




	foreach($table->columns as $column) {
		if($column->type == 'foreignkey') continue;
		$writer->startElement('column');

		if(isset($comments[$column->name])) {
			$writer->writeAttribute('comment', $comments[$column->name]);
		}

		$writer->writeAttribute('nullable', $column->nullable?1:0);

		$writer->writeAttribute('name', $column->name);
		$writer->writeAttribute('type', $column->type);

		if(isset($column->default_value)) {
			$writer->writeAttribute('default', $column->default_value);
		}

		if($column->fk_table !== null)
			$writer->writeAttribute('fk_table', $column->fk_table);
		if($column->fk_column !== null)
			$writer->writeAttribute('fk_column', $column->fk_column);


		$writer->endElement();
	}

	$writer->endElement();

}
class Schema {
	public static function create($table_name, $table_function) {
		$table = new Table($table_name);
		$table_function($table);

		write_table_xml($table);
		
	}
	public static function drop($table_name) {

	}
}
EOD;

class DatabaseManifestSeed extends Command {

  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'manifest:create';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Generates database.xml for database metadata';

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
  	eval($GLOBALS['migration_code']);

	$writer = new XMLWriter;

	$GLOBALS['writer'] = $writer;
	
	$writer->openMemory();
	$writer->setIndent(1);
	$writer->startDocument('1.0', 'UTF-8');
	$writer->startElement('tables');

	$loaded_classes = array();
	$files = glob(app_path() . "/database/migrations/*.php");

	$patterns = array('/use (\S+)/', '/<\?php/','/->default/');
	$replacements = array('','', '->def_value');

	foreach($files as $file) {

		echo "On file: " . $file."\n";
		$data = file_get_contents($file);
		$data = preg_replace($patterns, $replacements, $data);	

		$class_name = preg_match('/class (\S+) extends/i', $data, $matches);
		$loaded_classes[] = $matches[1];


		eval($data);

		$migration = new $matches[1]();
		$GLOBALS['comments'] = $migration->get_comments();
		$migration->up();

		

	}
	
	$writer->endElement();
	$writer->endDocument();

	$xml_file =  $writer->outputMemory(TRUE);
	$fd = fopen(storage_path() . "/database.xml", "wb");
	if(!$fd) {
		$this->error('Failed to open database.xml file for writing');
		return;
	}
	fwrite($fd, $xml_file);
	fclose($fd);
   
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
