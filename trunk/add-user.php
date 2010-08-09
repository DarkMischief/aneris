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

session_start();
	
if($_SERVER['REQUEST_METHOD'] == "GET") {
	print '<?xml version = "1.0" encoding = "utf-8" ?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Aneris - Basic Addition</title>
    <link type="text/css" rel="stylesheet" href="css/issues.css" />
    <script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      $("document").ready(function(){
        $(".contents").hide().fadeIn();
      });
    </script>
  </head>
  <body>
    <form action="add-user.php" method="post" id="user-add-form">
      <p>Username: <input type="text" name="username" /></p>
      <p>Password: <input type="password" name="password" /></p>
      <p><input type="submit" value="Submit" /><input type="reset" value="Clear" /></p>
    </form>
  </body>
</html>
<?php
}
else if($_SERVER['REQUEST_METHOD'] == "POST"){
	extract($_POST);
		
	require_once('connect.php');	
	$title = trim(mysql_real_escape_string(strip_tags($title)));
	$description = trim(mysql_real_escape_string(strip_tags($description)));
	$query = "insert into users values ('$username', md5('$password'), false);";

	$result = mysql_query($query);
	mysql_close();
		
	print "<p style=\"font-size:1.5em;\">Successfully added! <a href=\"login.php\">Log in</a>!</p>";
}
?>