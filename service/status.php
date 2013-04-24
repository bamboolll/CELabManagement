<?php
	/*status.php*/
	session_start();
	//Check for valid session. Exit from page if not valid.
if(!isset($_SESSION['username']) && !isset($_SESSION['id'])) {
	echo "<center><h1>invalid session!</h1><br />n<a href=\"login.html\">Login</a>";
	exit();
}
	echo "<center><b>Welcome ".$_SESSION['username']."! Your id is: ".$_SESSION['id']."</b>";
	echo "<br /><a href=\"logout.php\">Logout ".$_SESSION['username']."</a></center>";
?>
