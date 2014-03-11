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
    $ret->code = "FAIL";
    $ret->notes= array();	
    header('Mimetype=application/json');
    echo json_encode($ret);
    exit();
}


/**
 * Return Failure along with object
 * 
 */
function returnFAILWithNote($note)
{
    $ret->code = "FAIL";
    $ret->notes= array();
    array_push($ret->notes,$note);	
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
	header('Mimetype=application/json');
	echo json_encode($obj);
	exit();
}

function returnObjOk($obj)
{
	$obj->code = 'OK';
	returnObject($obj);
}

function returnObjFail($obj)
{
	$obj->code = 'FAIL';
	returnObject($obj);
}



?>
