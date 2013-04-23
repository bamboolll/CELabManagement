<?php
error_reporting(E_ALL | ~NOTICE);
ini_set('display_errors', TRUE);
include 'info_func.php';
include 'borrow_func.php';
include 'lablog_func.php';



echo ".dfjs ".$_GET['type']." \n";
echo ".dfjs ".$_GET['root']." \n";

echo "<br>";
echo phpversion();


	// Set default timezone
  date_default_timezone_set('UTC');
  echo "<br>";
  $ab=array("Apple", "Banana", "Pear");
  print_r($ab);
  echo "<br>";
  echo json_encode($ab);
  echo "<br>";
  
 
  try {
    /**************************************
    * Create databases and                *
    * open connections                    *
    **************************************/
 
    // Create (connect to) SQLite database in file
    $file_db = new PDO('sqlite:celab.sqlite');
    // Set errormode to exceptions
    $file_db->setAttribute(PDO::ATTR_ERRMODE, 
                            PDO::ERRMODE_EXCEPTION);
	 // Select all data from file db messages table 
    $result = $file_db->query('SELECT * FROM BorrowStatus');
     // Loop thru all data from messages table 
    // and insert it to file db
    echo "<br>";
    foreach ($result as $m) {
      print_r($m);
      echo "<br>";
      echo json_encode($m);
      echo "==== <br>";
    }  
    
    
    echo "<br>=================<br>";
    $name=getBorrowStatusName($file_db,0);
    print_r($name);
    echo "<br>";
    $name=getBorrowStatusDescription($file_db,0);
    print_r($name);
    echo "<br>";
    
    
    echo "<br>=================<br>";
    $name=getAllDevices($file_db);
    print_r($name);
    
    echo "<br>=================<br>";
    $name=getDevicesRow($file_db,0);
    print_r($name);
	
	echo "<br>=================<br>";
    $name=getLogWithStatus($file_db,0);
    print_r($name);
    echo "<br>=================<br>";
    //test insert Log
    $log1  = new LogEntry();
    $log1->unit_id=1;
    $log1->borrower_name="Tran Van A";
    $log1->borrower_id = "50600818";
    $log1->borrow_type = 0; //at Lab room
    $log1->status_id = 0; //request only.
    $log1->receive_date = date ("Y-m-d H:i:s");
    print_r($log1);
    $ret=putNewLogEntry($file_db,$log1);
    
	
	
    
    
    
    
    $file_db = null;
    
   }
  catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
  }                     

/*
$dbhandle = sqlite_open('celab.sqlite', 0666, $error);
if (!$dbhandle) die ($error);

$query = "SELECT * FROM BorrowStatus";
$result = sqlite_query($dbhandle,$query);
if(!$result) die ("Cannot execute query.");

$row = sqlite_fetch_array($result,SQLITE_ASSOC);
print_r($row);
echo "<br>";

sqlite_rewind($result);
$row = sqlite_fetch_array($result,SQLITE_NUM);
print_r($row);
echo "<br>";

sqlite_rewind($result);
$row = sqlite_fetch_array($result, SQLITE_BOTH); 
print_r($row);
echo "<br>"

sqlite_close($dbhandle);*/


?>


