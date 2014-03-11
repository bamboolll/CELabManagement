<?php

include_once 'info_func.php';

/**
 * Put new Log with LogEntry structure
 * $db databse
 * $entry LogEntry struc
 * 
 */

function putNewLogEntry($db, $entry)
{
	$all=false;
	
	$lastID= getLastLogEntry($db)+1;
	printdevln("put new log " + json_encode($entry));
	$query="INSERT INTO LabLog(log_id,unit_id,borrower_name,borrower_id,receive_date,return_date,borrow_type,status_id,log_description)
	VALUES(:f0,:f1,:f2,:f3,:f4,:f5,:f6,:f7,:f8)";
	try{
		$stmt = $db->prepare($query);
		$stmt->bindParam(':f0',$lastID,PDO::PARAM_INT);
		$stmt->bindParam(':f1',$entry->unit_id,PDO::PARAM_INT);
		$stmt->bindParam(':f2',$entry->borrower_name,PDO::PARAM_STR);
		$stmt->bindParam(':f3',$entry->borrower_id,PDO::PARAM_STR);
		$stmt->bindParam(':f4',$entry->receive_date,PDO::PARAM_STR);
		$stmt->bindParam(':f5',$entry->return_date,PDO::PARAM_STR);
		$stmt->bindParam(':f6',$entry->borrow_type,PDO::PARAM_INT);
		$stmt->bindParam(':f7',$entry->status_id,PDO::PARAM_INT);
		$stmt->bindParam(':f8',$entry->log_description,PDO::PARAM_STR);
		$stmt->execute();
		$affected_rows=$stmt->rowCount();
		print_r($affected_rows);
		$all=true;
		
	}catch(PDOException $e)
	{
		echo $e->getMessage();
	}
	return $all;
}

/**
* Update log entry to returnstatus = 2
*/
function updateLogEntryRequestReturn($db,$entry)
{
    $all->code = "FAIL";//default return fail
        $all->notes = array();
	//check data consistent here, can only update if status is 1
	try{
		//update LabLog table
		$entry->status_id = 2; //return request
		$entry->log_id= intval($entry->log_id);
		$query = "UPDATE LabLog SET status_id=:f0, return_date=:f1 WHERE log_id=:f2 AND status_id=1";
		$stmt = $db->prepare($query);
		$stmt->bindParam(':f0',$entry->status_id,PDO::PARAM_INT);
		$stmt->bindParam(':f1',$entry->return_date,PDO::PARAM_STR);
		$stmt->bindParam(':f2',$entry->log_id,PDO::PARAM_INT);
		$stmt->execute();
		$affected_rows=$stmt->rowCount();
		printdevln("Success request return lablog");
		print_rdev($affected_rows);
                $all->count=$affected_rows;
	}catch(PDOException $e)
	{
		printdevln($e->getMessage());
                array_push($all->notes, $e->getMessage());
                return $all;
	}
        
        $all->code = "OK";
        array_push($all->notes, "Successful send a returning request");
        return $all;
}


/**
*
*
*
*/
function searchLogsWithNameOrID_mysql($db, $name, $id, $status_id)
{
	$all->code = "FAIL";//default return fail
        $all->notes = array();
        
        //SELECT * FROM celabdb.LabLog as t1 , celabdb.DeviceUnit as t2, celabdb.DeviceName as t3 WHERE t1.unit_id=t2.unit_id AND t2.device_id=t3.device_id AND t1.borrower_name LIKE '%' AND t1.borrower_id LIKE '%' AND t1.status_id=1
	$string = "Get Log " . $name . " - " . $id . " - " . $status_id;
	printdevln($string);
	$name = "%" . $name . "%";
	$id =  "%" . $id . "%";
	$query="SELECT * FROM LabLog as t1 , DeviceUnit as t2, DeviceName as t3 WHERE t1.unit_id=t2.unit_id AND t2.device_id=t3.device_id AND t1.borrower_name LIKE :f0 AND t1.borrower_id LIKE :f1 AND t1.status_id=:f2";
	printdevln($query);
	try{
		$stmt = $db->prepare($query);
		$stmt->bindParam(':f0',$name,PDO::PARAM_STR);
		$stmt->bindParam(':f1',$id,PDO::PARAM_STR);
		$stmt->bindParam(':f2',$status_id,PDO::PARAM_INT);
		$stmt->execute();
		$affected_rows=$stmt->rowCount();
		print_rdev($affected_rows);
                $all->count = $affected_rows;
		$all->logs = $stmt->fetchAll(PDO::FETCH_ASSOC);;
		
	}catch(PDOException $e)
	{
		printdevln($e->getMessage());
                array_push($all->notes,$e->getMessage());
		return $all;
	}
        $all->code = "OK";
	return $all;
}

/**
*	Search all log for matching $name or $id with the status is 'not return'
*
*/
function searchLogsWithNameOrID($db, $name, $id, $status_id)
{	
	$string = "Get Log " . $name . " - " . $id . " - " . $status_id;
	printdevln($string);
	$all=false;
	$name = "%" . $name . "%";
	$id =  "%" . $id . "%";
	$query="SELECT * FROM LabLog WHERE borrower_name LIKE :f0 AND borrower_id LIKE :f1 AND status_id=:f2";
	printdevln($query);
	try{
		$stmt = $db->prepare($query);
		$stmt->bindParam(':f0',$name,PDO::PARAM_STR);
		$stmt->bindParam(':f1',$id,PDO::PARAM_STR);
		$stmt->bindParam(':f2',$status_id,PDO::PARAM_INT);
		$stmt->execute();
		$affected_rows=$stmt->rowCount();
		print_rdev($affected_rows);
		$all = $stmt->fetchAll(PDO::FETCH_ASSOC);;
		
	}catch(PDOException $e)
	{
		printdevln($e->getMessage());
		return false;
	}
	return $all;
}


/**
 * 
 * Approve a pending request.
 * @param unknown $db
 * @param unknown $entry
 *
 * TODO: check if device unit is alreadry taken, return reason if needed.
 */
function putApproveBorrowLogEntry($db, $entry)
{
	$all->code = "FAIL";//default fail status
	$all->notes = array();
	$log_id = $entry->log_id;
	//TODO validate consistent of database
	//$entry->status_id must be 0 or 2
	//must be a device unit in database.
	
	//update lab_log entry
	//$query="INSERT INTO LabLog(log_id,unit_id,borrower_name,borrower_id,receive_date,return_date,borrow_type,status_id,log_description)
	//VALUES(:f0,:f1,:f2,:f3,:f4,:f5,:f6,:f7,:f8)";
	//update Device_Unit table and Device_Name Table
	try{
		//get Device ID
		$query = "SELECT * from DeviceUnit where unit_id=".$entry->unit_id;
		$result = $db->query($query);
		$m = $result->fetch(PDO::FETCH_ASSOC);
		if(!empty($m)){
			$device_id=$m['device_id'];
			if($m['status']==0){ // check if device unit is already taken.
				array_push($all->notes,'Device is already taken! '.$entry->unit_id);
				return $all;
			}
		}
		else{
			array_push($all->notes,'Invlalid device_id!');
			return $all;
		}
		printdevln("success get device_id");
		//get No Availabel of device_id
		$query = "SELECT no_available from DeviceName where device_id=".$device_id;
		$result = $db->query($query);
		$m = $result->fetch(PDO::FETCH_ASSOC);
		if(!empty($m))
			$no_available=$m['no_available'];
		else{
			array_push($all->notes,'Invalid device_name!');
			return $all;
		}
		printdevln("success get no_available");
		if($no_available <=0){
			array_push($all->notes,'All devices is already taken!');
			return $all;
		}

		//update LabLog table
		$entry->status_id = 1; //borrowed now.

		//$query = "UPDATE LabLog SET status_id=:f0,log_description=:f1 WHERE log_id=:f2";
		$query = "UPDATE LabLog SET status_id=:f0,log_description=:f1,receive_date=:f2,borrower_name=:f4,borrower_id=:f5,borrow_type=:f6 WHERE log_id=:f7";
		//printdevln("query".$query);
		$stmt = $db->prepare($query);
		$stmt->bindParam(':f0',$entry->status_id,PDO::PARAM_INT);
		$stmt->bindParam(':f1',$entry->log_description,PDO::PARAM_STR);
		$stmt->bindParam(':f2',$entry->receive_date,PDO::PARAM_STR);
		$stmt->bindParam(':f4',$entry->borrower_name,PDO::PARAM_STR);
		$stmt->bindParam(':f5',$entry->borrower_id,PDO::PARAM_STR);
		$stmt->bindParam(':f6',$entry->borrow_type,PDO::PARAM_INT);
		$stmt->bindParam(':f7',$entry->log_id,PDO::PARAM_INT);
		$stmt->execute();
		$affected_rows=$stmt->rowCount();
		$all->count = $affected_rows;
		printdevln("Success update lablog");
		print_rdev($affected_rows);
		//update No Vailable and device status

		$no_available = $no_available -1;
		$status = 0;

		
		//update status of device_unit
		$query = "UPDATE DeviceUnit SET status=".$status." where unit_id=".$entry->unit_id;
		$result = $db->query($query);
		//update no_available of device_id
		$query = "UPDATE DeviceName SET no_available=".$no_available." where device_id=".$device_id;
		$result = $db->query($query);
		
		
		$all->code = "OK";
		
	}catch(PDOException $e)
	{
		printdevln($e->getMessage());
		array_push($all->notes,$e->getMessage());
		$all->code = "FAIL";
	}
	return $all;
}



/**
 * 
 * Approve a pending request.
 * @param unknown $db
 * @param unknown $entry
 *
 * TODO: check if device unit is alreadry taken, return reason if needed.
 */
function putApproveReturnLogEntry($db, $entry)
{
	$all->code = "FAIL";//default fail status
	$all->notes = array();
	$log_id = $entry->log_id;
	//TODO validate consistent of database
	//$entry->status_id must be 0 or 2
	//must be a device unit in database.
	
	//update lab_log entry
	//$query="INSERT INTO LabLog(log_id,unit_id,borrower_name,borrower_id,receive_date,return_date,borrow_type,status_id,log_description)
	//VALUES(:f0,:f1,:f2,:f3,:f4,:f5,:f6,:f7,:f8)";
	//update Device_Unit table and Device_Name Table
	try{
		//get Device ID
		$query = "SELECT * from DeviceUnit where unit_id=".$entry->unit_id;
		$result = $db->query($query);
		$m = $result->fetch(PDO::FETCH_ASSOC);
		if(!empty($m)){
			$device_id=$m['device_id'];
			if($m['status'] != 0){
                            array_push($all->notes,'Device is already returned!');
				return $all;
			}
		}
		else{
			array_push($all->notes,'Invalid unit_id!');
			return $all;
		}
		printdevln("success get device_id");
		//get No Availabel of device_id
		$query = "SELECT no_available from DeviceName where device_id=".$device_id;
		$result = $db->query($query);
		$m = $result->fetch(PDO::FETCH_ASSOC);
		if(!empty($m)){
			$no_available=$m['no_available'];
		}
		else{
			array_push($all->notes,'Invalid device_id!');
			return $all;
		}
		printdevln("success get no_available");
		
		//update LabLog table
		$entry->status_id = 3; //Have returned

		//$query = "UPDATE LabLog SET status_id=:f0,log_description=:f1 WHERE log_id=:f2";
		$query = "UPDATE LabLog SET status_id=:f0,log_description=:f1,receive_date=:f2,return_date=:f3,borrower_name=:f4,borrower_id=:f5 WHERE log_id=:f7";
		//printdevln("query".$query);
		$stmt = $db->prepare($query);
		$stmt->bindParam(':f0',$entry->status_id,PDO::PARAM_INT);
		$stmt->bindParam(':f1',$entry->log_description,PDO::PARAM_STR);
		$stmt->bindParam(':f2',$entry->receive_date,PDO::PARAM_STR);
		$stmt->bindParam(':f3',$entry->return_date,PDO::PARAM_STR);
		$stmt->bindParam(':f4',$entry->borrower_name,PDO::PARAM_STR);
		$stmt->bindParam(':f5',$entry->borrower_id,PDO::PARAM_STR);
		//$stmt->bindParam(':f6',$entry->borrow_type,PDO::PARAM_INT);
		$stmt->bindParam(':f7',$entry->log_id,PDO::PARAM_INT);
		$stmt->execute();
		$affected_rows=$stmt->rowCount();
		$all->count = $affected_rows;
		printdevln("Success update lablog");
		print_rdev($affected_rows);
		//update No Vailable and device status
		
		$no_available = $no_available + 1;
		$status = 1;

		
		//update status of device_unit
		$query = "UPDATE DeviceUnit SET status=".$status." where unit_id=".$entry->unit_id;
		$result = $db->query($query);
		//update no_available of device_id
		$query = "UPDATE DeviceName SET no_available=".$no_available." where device_id=".$device_id;
		$result = $db->query($query);
		
		
	}catch(PDOException $e)
	{
		printdevln($e->getMessage());
		array_push($all->notes,$e->getMessage());
                $all->code = "FAIL";
                return $all;
	}
        $all->code ="OK";
	return $all;
}


/**
 * 
 * Approve a pending request.
 * @param unknown $db
 * @param unknown $entry
 *
 * TODO: check if device unit is alreadry taken, return reason if needed.
 */
function putApproveLogEntry($db, $entry)
{
	$all=false;
	$log_id = $entry->log_id;
	//TODO validate consistent of database
	//$entry->status_id must be 0 or 2
	//must be a device unit in database.
	
	//update lab_log entry
	//$query="INSERT INTO LabLog(log_id,unit_id,borrower_name,borrower_id,receive_date,return_date,borrow_type,status_id,log_description)
	//VALUES(:f0,:f1,:f2,:f3,:f4,:f5,:f6,:f7,:f8)";
	//update Device_Unit table and Device_Name Table
	try{
		//get Device ID
		$query = "SELECT device_id from DeviceUnit where unit_id=".$entry->unit_id;
		$result = $db->query($query);
		$m = $result->fetch(PDO::FETCH_ASSOC);
		if(!empty($m))
			$device_id=$m['device_id'];
		else
			return $all;
		printdevln("success get device_id");
		//get No Availabel of device_id
		$query = "SELECT no_available from DeviceName where device_id=".$device_id;
		$result = $db->query($query);
		$m = $result->fetch(PDO::FETCH_ASSOC);
		if(!empty($m))
			$no_available=$m['no_available'];
		else
			return $all;
		printdevln("success get no_available");
		
		//update LabLog table
		$entry->status_id = $entry->status_id+1;
		printdevln("success get status_id = ".$entry->status_id);
		if($entry->status_id != 1 && $entry->status_id != 3)
			return $all;
		//$query = "UPDATE LabLog SET status_id=:f0,log_description=:f1 WHERE log_id=:f2";
		$query = "UPDATE LabLog SET status_id=:f0,log_description=:f1,receive_date=:f2,return_date=:f3,borrower_name=:f4,borrower_id=:f5,borrow_type=:f6 WHERE log_id=:f7";
		//printdevln("query".$query);
		$stmt = $db->prepare($query);
		$stmt->bindParam(':f0',$entry->status_id,PDO::PARAM_INT);
		$stmt->bindParam(':f1',$entry->log_description,PDO::PARAM_STR);
		$stmt->bindParam(':f2',$entry->receive_date,PDO::PARAM_STR);
		$stmt->bindParam(':f3',$entry->return_date,PDO::PARAM_STR);
		$stmt->bindParam(':f4',$entry->borrower_name,PDO::PARAM_STR);
		$stmt->bindParam(':f5',$entry->borrower_id,PDO::PARAM_STR);
		$stmt->bindParam(':f6',$entry->borrow_type,PDO::PARAM_INT);
		$stmt->bindParam(':f7',$entry->log_id,PDO::PARAM_INT);
		$stmt->execute();
		$affected_rows=$stmt->rowCount();
		printdevln("Success update lablog");
		print_rdev($affected_rows);
		//update No Vailable and device status
		if($entry->status_id == 1){//borrowed
			$no_available = $no_available -1;
			$status = 0;
		}
		else{ 
			$no_available = $no_available + 1;
			$status = 1;
		}
		
		//update status of device_unit
		$query = "UPDATE DeviceUnit SET status=".$status." where unit_id=".$entry->unit_id;
		$result = $db->query($query);
		//update no_available of device_id
		$query = "UPDATE DeviceName SET no_available=".$no_available." where device_id=".$device_id;
		$result = $db->query($query);
		
		
		$all= true;
		
	}catch(PDOException $e)
	{
		printdevln($e->getMessage());
		return false;
	}
	return $all;
}


/**
*	reject the want-return status => update it to in-borrowed :D
*
*/
function putRejectReturnLogEntry($db, $entry)
{
    $all->code = "FAIL";//default fail status
    $all->notes = array();
	//simply change log entry status to reject
	//check data consistent here
	try{
		//update LabLog table
		$entry->status_id = 1; //in-borrowed
		$query = "UPDATE LabLog SET status_id=:f0,log_description=:f1 WHERE log_id=:f2";
		$stmt = $db->prepare($query);
		$stmt->bindParam(':f0',$entry->status_id,PDO::PARAM_INT);
		$stmt->bindParam(':f1',$entry->log_description,PDO::PARAM_STR);
		$stmt->bindParam(':f2',$entry->log_id,PDO::PARAM_INT);
		$stmt->execute();
		$affected_rows=$stmt->rowCount();
		printdevln("Success reject lablog");
		print_rdev($affected_rows);
	}catch(PDOException $e)
	{
		printdevln($e->getMessage());
                array_push($all->notes, $e->getMessage());
	        return $all;
	}
	$all->code="OK";
        array_push($all->notes, "Successful reject returning request");
        return $all;
}

/**
 * 
 * @param PDO database $db
 * @param Log_Entry $entry
 */
function putRejectBorrowLogEntry($db, $entry)
{   
    $all->code = "FAIL";//default fail status
    $all->notes = array();
	//simply change log entry status to reject
	//check data consistent here
	try{
		//update LabLog table
		$entry->status_id = 5; //reject
		$query = "UPDATE LabLog SET status_id=:f0,log_description=:f1 WHERE log_id=:f2";
		$stmt = $db->prepare($query);
		$stmt->bindParam(':f0',$entry->status_id,PDO::PARAM_INT);
		$stmt->bindParam(':f1',$entry->log_description,PDO::PARAM_STR);
		$stmt->bindParam(':f2',$entry->log_id,PDO::PARAM_INT);
		$stmt->execute();
		$affected_rows=$stmt->rowCount();
		printdevln("Success reject lablog");
		print_rdev($affected_rows);
	}catch(PDOException $e)
	{
		printdevln($e->getMessage());
                array_push($all->notes, $e->getMessage());
                return $all;
	}
	$all->code="OK";
        array_push($all->notes, "Successful reject borrowing request");
        return $all;
}


/**
 * Get last log entry
 * 
 */
function getLastLogEntry($db){
	$query1="SELECT * FROM LabLog ORDER BY log_id DESC LIMIT 1";
	$num=0;
	try{
		$result = $db->query($query1);
		$m = $result->fetch(PDO::FETCH_ASSOC);
		if(!empty($m))
			$num=$m['log_id'];
		else
			$num=0;
	}catch(PDOException $e)
	{
		echo $e->getMessage();
	}
	return $num;
}

/**
 *  getAll Log which status is dang muon.
 *  $db: 
 *  $type: borrow type home or lab
 */
function getAllLogsByTypeStatus($db,$type,$status){
	if(!isset($status) || empty($type))
		$status = 1; // dang muo

	try{
		if(isset($type) && !empty($type)){
			$query="SELECT * FROM LabLog WHERE borrow_type=:f1 and status_id=:f2";
			$stmt = $db->prepare($query);
			$stmt->bindParam(':f1',$type,PDO::PARAM_INT);
			$stmt->bindParam(':f2',$status,PDO::PARAM_INT);
		}
		else{
			$query="SELECT * FROM LabLog WHERE status_id=:f1";
			$stmt = $db->prepare($query);
			$stmt->bindParam(':f1',$status,PDO::PARAM_INT);
		}
		$stmt->execute();
		$affected_rows=$stmt->rowCount();
		$all->count = $affected_rows;
		$all->logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
		print_rdev($affected_rows);
	}catch(PDOException $e)
	{
		printdevln($e->getMessage());
	}
	return all;
}



/**
 *  getAll Log which status is dang muon.
 *  $db: 
 *  $type: borrow type home or lab
 */
function getAllLogsByTypeStatus_mysql($db,$type,$status){
    $all->code = "FAIL";
    $all->notes = array();
    if (!isset($status) || empty($type))
        $status = 1; // dang muo

    try {
        if (isset($type) && !empty($type)) {
            $query = "SELECT * FROM  LabLog as t1 , DeviceUnit as t2, DeviceName as t3 WHERE t1.unit_id=t2.unit_id AND t2.device_id=t3.device_id AND borrow_type=:f1 and status_id=:f2";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':f1', $type, PDO::PARAM_INT);
            $stmt->bindParam(':f2', $status, PDO::PARAM_INT);
        } else {
            $query = "SELECT * FROM  LabLog as t1 , DeviceUnit as t2, DeviceName as t3 WHERE t1.unit_id=t2.unit_id AND t2.device_id=t3.device_id AND  status_id=:f1";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':f1', $status, PDO::PARAM_INT);
        }
        $stmt->execute();
        $affected_rows = $stmt->rowCount();
        $all->count = $affected_rows;
        $all->logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        print_rdev($affected_rows);
    } catch (PDOException $e) {
        printdevln($e->getMessage());
        array_push($all->notes,$e->getMessage());
        return $all;
    }
    $all->code = "OK";
    return $all;
}

/**
 * 
 * 
 * 
 * 
 */
 function getAllPendingLogsByType($db,$type){
    $all->code = "FAIL";
    $all->notes = array();
    try{
        if(isset($type) && !empty($type)){
            $query="SELECT * FROM LabLog WHERE borrow_type=:f1 AND (status_id=0 OR status_id=2)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':f1',$type,PDO::PARAM_INT);
        }
        else{
            $query="SELECT * FROM LabLog WHERE status_id=0 OR status_id=2";
            $stmt = $db->prepare($query);
        }
        $stmt->execute();
        $affected_rows=$stmt->rowCount();
        $all->count = $affected_rows;
        $all->logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        print_rdev($affected_rows);
    }catch(PDOException $e)
    {
            printdevln($e->getMessage());
            array_push($all->notes,$e->getMessage());
            return $all;
    }
    $all->code = "OK";
    return $all;	
 }


/**
 * 
 * 
 * 
 * 
 */
 function getAllPendingLogsByType_mysql($db,$type){
 	$all->code = "FAIL";
        $all->notes = array();
	try{
		if(isset($type) && !empty($type)){
			$query="SELECT * FROM LabLog as t1 , DeviceUnit as t2, DeviceName as t3 WHERE t1.unit_id=t2.unit_id AND t2.device_id=t3.device_id AND borrow_type=:f1 AND (status_id=0 OR status_id=2)";
			$stmt = $db->prepare($query);
			$stmt->bindParam(':f1',$type,PDO::PARAM_INT);
		}
		else{
			$query="SELECT * FROM LabLog as t1 , DeviceUnit as t2, DeviceName as t3 WHERE t1.unit_id=t2.unit_id AND t2.device_id=t3.device_id AND (status_id=0 OR status_id=2)";
			$stmt = $db->prepare($query);
		}
		$stmt->execute();
		$affected_rows=$stmt->rowCount();
		$all->count = $affected_rows;
		$all->logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
		//print_r($affected_rows);
		//print_r($all);
		print_rdev($affected_rows);
	}catch(PDOException $e)
	{
		 printdevln($e->getMessage());
            array_push($all->notes,$e->getMessage());
            return $all;
        }
    $all->code = "OK";
    return $all;	
 }

 //

?>
