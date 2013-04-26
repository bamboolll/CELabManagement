<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<?php
//error_reporting(E_ALL | ~NOTICE);
//ini_set('display_errors', TRUE);
include '../service/db_func.php';
include '../service/auth_func.php';
include '../service/info_func.php';
function show_login($pretext)
{
	echo "$pretext\n";
	echo "<input name=\"login\" type=\"hidden\" value=1 />\n";
	echo "User account: <br><input name=\"user\" type=\"text\" size=10 /> <br>\n";
	echo "Password: <br><input name=\"pwd\" type=\"password\" size=10 /> <br>\n";
	echo "<input type=\"submit\" value=\"Login\" />\n";
}
function show_logout($pretext)
{
	echo "$pretext\n";
	echo "<input name=\"login\" type=\"hidden\" value=2 />\n";
	echo "<input type=\"submit\" value=\"Logout\" />\n";
}
?>
<html>
<head>
	<title>Welcome to Computer Engineering Laboratory</title>
	<link rel="stylesheet" href="labstyle.css">
</head>
<body>
<div id="page">
	<div id="header">
		<h1>Computer Engineering Laboratory</h1>
	</div>
	<div id="leftmenu">
		<img width=200 height=200 src="logo.jpg" align="middle"/>
		<ul class="navbar">
			<li><a href="laboratory.php">Home</a>
			<li><a href="equipment.php">Equipments</a>
			<li><a href="laboratory.php?type=1">Timetable</a>
			<li><a href="laboratory.php?type=2">Announcement</a>
			<li><a href="laboratory.php?type=3">Regulation</a>
			<br> <br>
			<form method="post" action="laboratory.php">
			<?php
				session_start();
				if($_POST['login'] == 1)
				{
					$username = $_POST['user'];
					$password = $_POST['pwd'];
					if($username && $password)
					{
						$db = openSqliteDB();
						if(do_login($db,$username, $password))
						{
							show_logout("Log in successfully. Welcome $username to CELAB<br>\n");
						}
						else
						{
							show_login("Wrong username or password. Log in unsuccessfully <br>\n");
						}
						closeSqliteDB($db);
					} else 
					{
						show_login("Please enter your username or password <br>\n");
					}
				}
				else if($_POST['login'] == 2)
				{
					do_logout();
					show_login("Logged out\n");
				}else
				{
					if($_SESSION['username'] == "")
					{
						show_login("");
			  		}else
			  		{
			  			show_logout("");
			  		}
		  		}
		  	?>
			</form>
		</ul>
	</div>
	<div id="content">
		
	</div>
	<div id="footer">
	</div>
</div>
</body>
</html>
