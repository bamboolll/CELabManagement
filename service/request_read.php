<?php


//check user power
include_once 'json_func.php';
include_once 'global.php';
include_once 'lablog_func.php';

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
                                break;
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
		if(!isset($_GET['scope'])){
			returnFAIL();
			exit();
		}
		$scope = $_GET['scope'];
		$ret;
		if(!isset($_GET['btype']))
			$btype = "";
		else
			$btype = $_GET['btype'];
		
		if($btype == "home")
			$btype = 1;
		else if($btype == "lab")
			$btype = 0;
		else 
			$btype = "";

		if(!$scope){
			returnFAIL();
			exit();
		}
		switch($scope){
			case "all":
			//TODO
			break;
			case "search":
				printdevln("request search called");
				$name = $_GET['name'];
				$id = $_GET['id'];
				$status=$_GET['status'];
				if(!$name)
					$name="";
				if(!$id)
					$id = "";
				if(!$status)
					$status = 1;
				$ret = searchLogsWithNameOrID_mysql($db,$name,$id,$status);
			break;
			case "pending":
				$ret = getAllPendingLogsByType_mysql($db,$btype);
			break;
			case "pending_borrow":
				$ret = getAllLogsByTypeStatus_mysql($db,$btype,0);
			break;
			case "pending_return":
				$ret = getAllLogsByTypeStatus_mysql($db,$btype,4);
			break;
			case "returned":
				$ret = getAllLogsByTypeStatus_mysql($db,$btype,3);
			break;
			case "borrowed":
				$ret = getAllLogsByTypeStatus_mysql($db,$btype,1);
			break;
			case "rejected":
				$ret = getAllLogsByTypeStatus_mysql($db,$btype,5);
			break;
			default:
		}
		
		if(isset($ret) && !empty($ret))
                    returnObject($ret);
		else
			returnFAIL();
	 break;
	default:
		returnOK();
}
	exit();
?>
