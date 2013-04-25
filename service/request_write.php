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
		$scope = "all"; //another scope is search.
		//$scope = $_GET['scope'];
		$all = getAllDevices($db);
		//echo "dlskfjldsf";
		if($all)
			returnObject($all);
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
		if(!$scope){
			returnFAIL();
			exit();
		}
		switch($scope){
			case "request_borrow":
				//get parameter
				$entry = new LogEntry();
				$entry->borrower_name = $_POST['borrower_name'];
				$entry->borrower_id = $_POST['borrower_id'];
				$entry->borrow_type = ($_POST['borrow_type']);
				$entry->unit_id = $_POST['unit_id'];
				$entry->receive_date = $_POST['receive_date'];
				$entry->status_id = 0;//want to borrow
				$entry->log_description = $_POST['log_description'];			
				$ret = putNewLogEntry($db, $entry);
				if($ret)
					returnOK();
				else
					returnFAIL();
				exit();
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