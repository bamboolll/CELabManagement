<?php


//check user power
include_once 'json_func.php';
include_once 'global.php';

printdevln("request_read.php called");

if((!$db || !$parent) && ($parent != "test.php"))
{
	returnFAIL();
	exit();
}

if(!$_GET['aim']){
	returnFAIL();
	exit();
}
switch($_GET['aim']){
	case "device_name":
		$scope = $_GET['scope'];
		$ret;
		if(!$scope){
			returnFAIL();
			exit();
		} 
		switch($scope){
			case "all":
				$ret = getAllDevices($db);
				break;
			case "lookup":
				$device_id = $_GET['device_id'];
				$ret = lookupDeviceName($db, $device_id);
				break;				
			default:
				break;
		}
		if($ret)
			returnObject($ret);
		else
			returnFAIL();
	break;
	case "device_unit":
	/**Scope
	 *    all: all device unit
	 *    total: all device uit of specified devID
	 *    available: all device unit which is current available. 
	 */
		$scope = $_GET['scope'];
		$ret;
		if(!$scope){
			returnFAIL();
			exit();
		}
		switch($scope){
			case "all":
			break;
			case "total":
				$id = $_GET['dev_id'];
				$ret = getAllDeviceUnitByID($db,$id);
			break;
			case "available":
				$id = $_GET['dev_id'];
				$ret = getAvailableDeviceUnitByID($db,$id);
			case "lookup":
				$unit_id = $_GET['unit_id'];
				$ret = lookupDeviceUnit($db,$unit_id);	
			break;
			default:
		}
		
		if($ret)
			returnObject($ret);
		else
			returnFAIL();
	break;
	case "lab_log":
	/**
	 * scope
	 *   all: all log
	 *   scope: id
	 *   search: with more parameters follow
	 *   pending: wait for accept (both borrow and return).
	 * 	 returned: da tra
	 *   borrowed: chua tra.
	 */
		$scope = $_GET['scope'];
		$ret;
		$btype = $_GET['btype'];
		if($btype){
			if($btype == "home")
				$btype = 1;
			else if($btype == "lab")
				$btype = 0;
			else
				$btype = "";
		}
		if(!$scope){
			returnFAIL();
			exit();
		}
		switch($scope){
			case "all":
			//TODO
			break;
			case "search":
			//TODO
			break;
			case "pending":
				$ret = getAllPendingLogsByType($db,$btype);
			break;
			case "pending_borrow":
				$ret = getAllLogsByTypeStatus($db,$btype,0);
			break;
			case "pending_return":
				$ret = getAllLogsByTypeStatus($db,$btype,4);
			break;
			case "returned":
				$ret = getAllLogsByTypeStatus($db,$btype,3);
			break;
			case "borrowed":
				$ret = getAllLogsByTypeStatus($db,$btype,1);
			break;
			case "rejected":
				$ret = getAllLogsByTypeStatus($db,$btype,5);
			break;
			default:
		}
		
		if($ret)
			returnObject($ret);
		else
			returnFAIL();
	 break;
	default:
		returnOK();
}
	exit();
?>
