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
	$db = new PDO('sqlite:../service/celab.sqlite');
	//Set erromode to exceptions
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	
	return $db;
}
 

/**
 *  
 * return $db _ mysql pdo db.
 * 
 */
function openMySQLDB(){
	//Create (connect) SQLite database in file
	$dsn  = 'mysql:host=localhost;dbname=celabdb';
	$username = 'root';
	$password = 'root';
	$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    ); 
	//Set erromode to exceptions
	$db = new PDO($dsn, $username, $password, $options);
	
	return $db;
}


 /**
  * Close DB 
  *
  */
function closeMySQLDB($db){
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
