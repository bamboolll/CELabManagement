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

?>
