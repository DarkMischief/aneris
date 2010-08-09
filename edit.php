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

if (isset($_SESSION['uid'])) {
	if($_SERVER['REQUEST_METHOD'] == "GET") {
		require_once('connect.php');
		$query = "select * from issues where id=$_GET[id];";
		
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		extract($row);
		
		$i = $id;
		$t = $title;
		$d = $description;
		$s = $status;
		$o = $owner;
		
		print '<?xml version = "1.0" encoding = "utf-8" ?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Aneris - Editing Issue</title>
    <link type="text/css" rel="stylesheet" href="css/issues.css" />
    <script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      $("document").ready(function(){
        $(".contents").hide().fadeIn();
      });
    </script>
  </head>
  <body>
    <div class="contents">
      <p><a href="index.php" class="no-decor"><input type="button" value="Index" /></a><a href="index.php" class="no-decor"><input type="button" value="Add" /></a><a href="add.php" class="no-decor"><input type="button" value="Logout" /></a></p>
      <form action="edit.php" method="post" id="edit-form">
        <input type="hidden" name="id" value="<?php echo $i ?>" />
        <p>Issue Title: <input type="text" name="title" value="<?php echo $t ?>" /></p>
        <p>Owner: <select name="owner" value="<?php echo $o ?>">
<?php
		$query = 'select username from users where username != \'aneris\';';
		$result = mysql_query($query);
	
		while($row = mysql_fetch_array($result)){
			extract($row);
			$value = strtolower($username);
			
			print "<option value=\"$value\"";
			if($value === $o)
				print " selected=\"selected\"";
			print ">$value</option>";
		}
?></select></p>
        <p>Status: <select name="status" value="<?php echo $o ?>">
<?php
		$query = 'select status from statuses where status != \'deleted\';';
		$result = mysql_query($query);
	
		while($row = mysql_fetch_array($result)){
			extract($row);
			$value = strtolower($status);
			
			print "<option value=\"$value\"";
			if($value === $s)
				print " selected=\"selected\"";
			print ">$value</option>";
		}
?></select></p>
        <p>Issue Description: <textarea cols="50" rows="5" name="description"><?php echo $d ?></textarea></p>
        <p><a href="view.php?id=<?php echo $i ?>"><input type="button" value="Return to Issue" /></a><input type="submit" value="Submit" /><input type="reset" value="Clear" /></p>
      </form>
    </div>
  </body>
</html>
<?php
	}
	else if($_SERVER['REQUEST_METHOD'] == "POST"){
		extract($_POST);
		
		require_once('connect.php');	
		$title = trim(mysql_real_escape_string(strip_tags($title)));
		$description = trim(mysql_real_escape_string(strip_tags($description)));
		$query = "update issues set title='$title', description='$description', status='$status', owner='$_POST[owner]' where id=$id;";

		$result = mysql_query($query);
		mysql_close();
			
		header("Location: view.php?id=$id");
	}
}
else {
	header('Location: login.php'); 
}
?>