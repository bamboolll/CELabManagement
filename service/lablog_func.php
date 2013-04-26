<?php


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
 * 
 * Approve a pending request.
 * @param unknown $db
 * @param unknown $entry
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
	}
	return $all;
}


/**
 * 
 * @param PDO database $db
 * @param Log_Entry $entry
 */
function putRejectLogEntry($db, $entry)
{
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
	}
	return true;
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
	

?>
