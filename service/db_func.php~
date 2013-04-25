<?php
/**
 * DB collection of function 
 */
 
/**
 *  
 * return $db _ sqlite3 pdo db.
 * 
 */
function openSqliteDB(){
	//Create (connect) SQLite database in file
	$db = new PDO('sqlite:celab.sqlite');
	//Set erromode to exceptions
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	
	return $db;
}
 
 
 /**
  * Close DB 
  *
  */
function closeSqliteDB($db){
	try{
		$db = null;
	}catch(PDOException $e){
		if($DEBUG)
			echo $e->getMessage();
		return false;
	}
	return true;
}


?>
