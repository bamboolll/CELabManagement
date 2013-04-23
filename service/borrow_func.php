<?php
/**
 * Collection of borrow related function.
 * 
 */


/**
 * Get list of Logs where the status is ..
 * $db database
 * $id status id;
 * 0: muon muon
 * 1: dang muon
 * 2: muon tra
 * 3: dang tra
 */
function getLogWithStatus($db,$id)
{
	$all="";
	$query="SELECT * FROM LabLog WHERE status_id=".$id;
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
