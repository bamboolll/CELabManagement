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
