
<?php
/**
 * auth_func.php
 * + login
 * + logout
 * todo:
 * + registration
 * 
 */ 


/**
 * 
 * For check user login
 * param: 
 *   $db: database PDO
 *   $username
 *   $password
 * return
 *   true success - store in session
 *   false unsuccess.
 * 
 */
function do_login($db,$username, $password)
{
	if (!($username && $password))
		return false;
	echo $username."  ".addslashes($username);
	$query="SELECT id,pass,power FROM user WHERE  name='".$username."'";
	$result = $db->query($query);
	$m = $result->fetch(PDO::FETCH_ASSOC);
	if(empty($m)){
		echo "<center><h1>There is no such user ".$username."!</h1><br /><a href=\"login.html\">Go to login page</a></center>";
		return false;
	}
	print_r($m);
	//TODO handle time stamp check here.
	//TODO handle encoding password here.
	
	if($m['pass'] != $password) {
		echo "<center><h1>Login attempt rejected for ".$username."!</h1><br /><a href=\"login.html\">Go to login page</a></center>";
		return false;
	}
	session_start();
	$_SESSION['username'] = $username;
	$_SESSION['id'] = $m['id'];
	$_SESSION['power']= $m['power'];
	return true;
}

/**
 * Do logout
 * 
 * always return true.
 * 
 */
function do_logout()
{
	session_start();
	session_destroy();
	return true;
}



?>