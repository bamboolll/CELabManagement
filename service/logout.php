<?php
session_start();
echo "<center><h1>Good Bye ".$_SESSION['username']."!</h1><br /><a href=\"login.html\">Go to login page!</a><br /><a href=\"status.php\">Get Status</a></center>";
session_destroy();
?>
