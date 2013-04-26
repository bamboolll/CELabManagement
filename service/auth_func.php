
<?php
/**
 * auth_func.php
 * + login
 * + logout
 * todo:
 * + registration
 * 
 */ 

include_once 'global.php';
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
		//echo "<center><h1>There is no such user ".$username."!</h1><br /><a href=\"login.html\">Go to login page</a></center>";
		return false;
	}
	//print_r($m);
	//TODO handle time stamp check here.
	//TODO handle encoding password here.
	
	if($m['pass'] != $password) {
		//echo "<center><h1>Login attempt rejected for ".$username."!</h1><br /><a href=\"login.html\">Go to login page</a></center>";
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


function get_user_status()
{
	$user = new User();
	session_start();
	print_rdev($_SESSION);
	if(!isset($_SESSION['username']) || !isset($_SESSION['id']) || !isset($_SESSION['power'])){
		$user = null;
		printdevln("user didn't login");
	}
	else{
		$user->username = $_SESSION['username'];
		$user->id = $_SESSION['id'];
		$user->power = $_SESSION['power'];
		printdevln("user success login");
	}
	return $user;
}


?>
