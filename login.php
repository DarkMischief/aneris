<?php

/*
Aneris - A Web-based Issue Tracker
Copyright (C) 2010 Benjamin Hale

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/*
Contact Information
email: webmaster.arasaia@gmail.com

physical address: 2151 Highway 16
                  Searcy, AR 72143
*/

function success(){
	header("Location: index.php"); 
}

function fail($message){
	header("Location: login.php?error=$message");
}

session_start(); 

if (isset($_SESSION['uid'])){
	success();
}
else if (isset($_POST['username']) && isset($_POST['password'])){
	require_once('connect.php');
	
	$username = trim(mysql_real_escape_string(strip_tags($_POST['username'])));
	$password = trim(mysql_real_escape_string(strip_tags($_POST['password'])));
	
	$query = "select * from users where username='$username';";
	$result = mysql_query($query);

	if(mysql_num_rows($result) > 0){
		extract(mysql_fetch_array($result));
		if(md5($_POST['password']) == $password){
			$_SESSION['uid'] = $username;
			$_SESSION['admin'] = $admin;
			success();
		}
		else
			fail('password');
	}
	else{
		fail('username');
	}
}
else {
		print '<?xml version = "1.0" encoding = "utf-8" ?>';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Aneris - Login</title>
    <link type="text/css" rel="stylesheet" href="css/issues.css" />
    <script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      $("document").ready(function(){
        $(".contents").hide().fadeIn();
      });
    </script>
	</head>
	<body>
      <div class="contents left outer-border top-pad login-box auto-center bottom-pad">
        <h1 class="left-indent">Aneris</h1>
        <p class="quote left-indent"><span class="italic">The Aneristic Principle is that of apparent order;<br /><span class="left-indent">the Eristic Principle is that of apparent disorder.</span></span> &#8212; Principia Discordia</p>
		<div id="container" class="left-indent top-pad">
          <form action="login.php" method="post">
			<?php
				if (isset($_GET['error'])) {
					if($_GET['error'] == "username")
						$error = "Username was possibly incorrect.";
					else
						$error = "Password was possibly incorrect.";
			?>
            <div id="msg" style="font-weight:bold; font-size:1.25em">Login failed: <?php echo $error;?></div>
			<?php
				}
			?>
			<div id="username">
				<span id="username-label">Username:</span>
				<span id="username-input"><input name="username" type="text" /></span>
			</div>
			<div id="passwd">
				<span id="password-label">Password:</span>
				<span id="password-input"><input name="password" type="password" /></span>
			</div>
			<div id="controls">
				<span id="submit"><input type="submit" value="Login" /></span>
			</div>
		  </form>		
		</div>
      </div>
	</body>
</html>
<?php
}
?>