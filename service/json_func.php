<?php
	/**
	 * json_func.php
	 * 
	 * collection of json wrapper function.
	 * 
	 */

/**
 * Return OK along with object
 * 
 */
function returnOK()
{
	$ret = array('code'=>"OK");
	header('Mimetype=application/json');
	echo json_encode($ret);
}


/**
 * Return Failure along with object
 * 
 */
function returnFAIL()
{
	$ret = array('code' => "FAIL");
	header('Mimetype=application/json');
	echo json_encode($ret);
	exit();
}


/**
 * Return array objects
 * 
 */
function returnObject($obj)
{
	//header('Content-Type: application/json');
	echo json_encode($obj);
	exit();
}


?>
