<?php
/**
 * Collection of info query related function.
 * 
 */

/**
 * Get name of BorrowStatus
 * $db database
 * $id status_id
 */
function getBorrowStatusName($db,$id)
{
	$name="";
	$query="SELECT * FROM BorrowStatus WHERE status_id=".$id;
	try{
		$result = $db->query($query);
		foreach ($result as $m) {
			$name=$m['status_name'];
		}
	}catch(PDOException $e)
	{
		echo $e->getMessage();
	}
	return $name;
}


/**
 * Get descriptions of BorrowStatus
 * $db database
 * $id status_id
 */
function getBorrowStatusDescription($db,$id)
{
	$name="";
	$query="SELECT status_description FROM BorrowStatus WHERE status_id=".$id;
	try{
		$stmt = $db->prepare($query);
		$stmt->execute();
		
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		$name=$result['status_description'];
	}catch(PDOException $e)
	{
		echo $e->getMessage();
	}
	return $name;
}


/**
 * Get list of devices from DeviceName table
 * $db database
 */
function getAllDevices($db)
{
	$all="";
	$query="SELECT * FROM DeviceName";
	try{
		$result = $db->query($query);
		
		$all = $result->fetchAll(PDO::FETCH_ASSOC);
	}catch(PDOException $e)
	{
		echo $e->getMessage();
	}
	return $all;
}


/**
 * Get list of devices from DeviceName table
 * $db database
 * $id device id;
 */
function getDevicesRow($db,$id)
{
	$all="";
	$query="SELECT * FROM DeviceName WHERE device_id=".$id;
	try{
		$result = $db->query($query);
		
		$all = $result->fetchAll(PDO::FETCH_ASSOC);
	}catch(PDOException $e)
	{
		echo $e->getMessage();
	}
	return $all;
}

/**
 * Get list of device unit with device ID.
 * 
 */
function getAllDeviceUnitByID($db,$id)
{
	$all="";
	$query="SELECT * FROM DeviceUnit WHERE device_id=".$id;
	try{
		$result = $db->query($query);
		$all = $result->fetchAll(PDO::FETCH_ASSOC);
	}catch(PDOException $e)
	{
		printdevln($e->getMessage());
	}
	return $all;
}


/**
 * Get borrowable device unit by ID.
 * 
 */
function getAvailableDeviceUnitByID($db,$id)
{
	$all="";
	$query="SELECT * FROM DeviceUnit WHERE device_id=".$id." and status=1";
	try{
		$result = $db->query($query);
		$all = $result->fetchAll(PDO::FETCH_ASSOC);
	}catch(PDOException $e)
	{
		printdevln($e->getMessage());
	}
	return $all;
}

/**
 *  getAll Log which status is dang muon.
 *  $db: 
 *  $type: borrow type home or lab
 */
function getAllLogsByTypeStatus($db,$type,$status){
	$all="";
	if(!$status && !empty($status))
		$status = 1; // dang muon
	if($type && !empty($type))
		$query="SELECT * FROM LabLog WHERE borrow_type=".$type." and status_id=".$status;
	else
		$query="SELECT * FROM LabLog WHERE status_id=".$status;
	try{
		$result = $db->query($query);
		$all = $result->fetchAll(PDO::FETCH_ASSOC);
	}catch(PDOException $e)
	{
		printdevln($e->getMessage());
	}
	return $all;
}

/**
 * 
 * 
 * 
 * 
 */
 function getAllPendingLogsByType($db,$type){
	$all="";
	if($type && !empty($type))
		$query="SELECT * FROM LabLog WHERE borrow_type=".$type." AND (status_id=0 OR status_id=2)";
	else
		$query="SELECT * FROM LabLog WHERE (status_id=0 OR status_id=2)";
	try{
		$result = $db->query($query);
		$all = $result->fetchAll(PDO::FETCH_ASSOC);
	}catch(PDOException $e)
	{
		printdevln($e->getMessage());
	}
	return $all;	
 }

?>
