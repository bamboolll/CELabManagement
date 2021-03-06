<?php
/**
 * Configure global variable
 * 
*/

$DEBUG = false;
$DEBUG_JSON = true;


function printdevln($string){
	global $DEBUG;
	if($DEBUG)
		echo $string."<br>";
}


class User {
	public $username = "";
	public $id = "";
	public $power = "";
}

class LogEntry {
	public $log_id = "";
	public $unit_id = "";
	public $borrower_name = "";
	public $borrower_id = "";
	public $receive_date = "";
	public $return_date = "";
	public $borrow_type = "";
	public $status_id = "";
	public $log_description="";
}

function print_rdev($object){
	global $DEBUG;
	if($DEBUG)
		print_r($object);
}

function print_dbg_obj($object,$string){
	global $DEBUG_JSON;
	if($DEBUG_JSON){
		$object->debug = $object->debug."+".$string;
	}
}

?>
