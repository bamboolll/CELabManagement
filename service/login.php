<?php
/*login.php*/
function check_login($db,$username, $password)
{
	if (!($username && $password))
		return false;
	echo $username."  ".addslashes($username);
	$query="SELECT id,pass FROM user WHERE  name='".$username."'";
	$result = $db->query($query);
	//echo "<br> rowcoutn ".$result->rowCount();
	//~ if($result->rowCount() != 1){
		//~ echo "<center><h1>User ".$username." not found</h1><br /><a href=\"login.html\">Go to login page</a></center>";
		//~ return false;
	//~ }
	
	$m = $result->fetch(PDO::FETCH_ASSOC);
	print_r($m);
	if($m['pass'] != $password) {
		echo "<center><h1>Login attempt rejected for ".$username."!</h1><br /><a href=\"login.html\">Go to login page</a></center>";
		return false;
	}
	session_start();
	$_SESSION['username'] = $username;
	$_SESSION['id'] = $m['id'];
	return true;
}
	try{
		// Create (connect to) SQLite database in file
		$file_db = new PDO('sqlite:celab.sqlite');
		// Set errormode to exceptions
		$file_db->setAttribute(PDO::ATTR_ERRMODE, 
								PDO::ERRMODE_EXCEPTION);
		
		if(check_login($file_db,$_POST['username'], $_POST['passwd']))
			echo "<center><h1>Welcome ".$_SESSION['username']."!</h1><br /><br />n";
		
		echo "<a href=\"status.php\">Check status!</a><br /><a href=\"protectedimage.php\">View Protected Image</a><br /><a href=\"logout.php\">Logout</a></center>n";
		
		$file_db = null;
	}catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
  } 
?>
