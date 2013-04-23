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


?>
