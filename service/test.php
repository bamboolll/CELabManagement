<?php
/**
 * test.php
 * Doing test function.
 * 
 * 
 */
	
error_reporting(E_ALL | ~NOTICE);
ini_set('display_errors', TRUE);
include 'global.php';
include 'info_func.php';
include 'borrow_func.php';
include 'lablog_func.php';
include 'auth_func.php';
include 'db_func.php';

$parent = "test.php";
$db = openSqliteDB();
if(!$_GET['what']){
	echo "What's up??";
	exit();
}
switch($_GET['what']){
	case "auth":
		printdevln("authentication");
		if(!$_GET['want']){
			printdevln("What do you want?");
			exit();
		}
		if($_GET['want'] == "login"){
			printdevln("want login");
			if(do_login($db,$_POST['username'], $_POST['passwd']))
				printdevln("Successful login");
			else
				printdevln("Unlucky man");
			
		}else if($_GET['want'] == "logout"){
			printdevln("want logout");
			do_logout();
		}else{
			printdevln("so ambitious");
			exit();
		}
			
	break;
	case "req":
		printdevln("nomarl request");
		//check type of request
		if(!$_GET['want']){
			printdevln("What do you want?");
			exit();
		}
		if($_GET['want'] == "read"){
			printdevln("Want to read");
			include 'request_read.php';
			
		}else if($_GET['want'] == "write"){
			printdevln("Want to write");
			include 'request_write.php';
		}else{
			printdevln("ambitious request");
			exit();
		}
		
	break;
	default:
		printdevln("What what????");
}

closeSqliteDB($db);



?>
