<?php
//check user power
include_once 'json_func.php';
include_once 'global.php';
include_once 'lablog_func.php';
include_once 'auth_func.php';

printdevln("request_write.php called");


$user = get_user_status();

if((!$db || !$parent) && ($parent != "server.php"))
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
		//TODO
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
		//TODO
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
				//check user level
				if($user->power > 1) //must be 0 root or 1 normal user.
					returnFAIL();
					
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
			case "request_return":
				//check user status:
				if($user->power > 1) //must be 0 root or 1 normal user
					returnFAIL();
				//get parameter
				$entry = new LogEntry();
				$entry->borrower_name = $_POST['borrower_name'];
				$entry->borrower_id = $_POST['borrower_id'];
				$entry->borrow_type = ($_POST['borrow_type']);
				$entry->unit_id = $_POST['unit_id'];
				$entry->receive_date = $_POST['receive_date'];
				$entry->return_date = $_POST['return_date'];
				$entry->status_id = 2;//want to return
				$entry->log_description = $_POST['log_description'];
				$ret = putNewLogEntry($db, $entry);
				if($ret)
					returnOK();
				else
					returnFAIL();
				exit();
				break;
				
			case "approve":
				//check user power
				if($user->power>0) // must be root to do this kind of action
					returnFAIL();
				//get parameter
				$entry = new LogEntry();
				$entry->log_id = $_POST['log_id'];
				$entry->borrower_name = $_POST['borrower_name'];
				$entry->borrower_id = $_POST['borrower_id'];
				$entry->borrow_type = ($_POST['borrow_type']);
				$entry->unit_id = $_POST['unit_id'];
				$entry->receive_date = $_POST['receive_date'];
				$entry->return_date = $_POST['return_date'];
				$entry->status_id = $_POST['status_id'];//want to return or want to borrow
				$entry->log_description = $_POST['log_description'];
				$ret = putApproveLogEntry($db, $entry);
				if($ret)
					returnOK();
				else
					returnFAIL();
				exit();
				break;
				case "reject":
					//check user power
					if($user->power>0) // must be root to do this kind of action
						returnFAIL();
					//get parameter
					$entry = new LogEntry();
					$entry->log_id = $_POST['log_id'];
					$entry->borrower_name = $_POST['borrower_name'];
					$entry->borrower_id = $_POST['borrower_id'];
					$entry->borrow_type = ($_POST['borrow_type']);
					$entry->unit_id = $_POST['unit_id'];
					$entry->receive_date = $_POST['receive_date'];
					$entry->return_date = $_POST['return_date'];
					$entry->status_id = $_POST['status_id'];//don't care
					$entry->log_description = $_POST['log_description'];
					$ret = putRejectLogEntry($db, $entry);
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
		//TODO
		returnOK();
}
exit();
?>