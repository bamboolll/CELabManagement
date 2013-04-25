<?php
/**
 * Configure global variable
 * 
*/

$DEBUG = true;


function printdevln($string){
	global $DEBUG;
	if($DEBUG)
		echo $string."<br>";
}
?>
