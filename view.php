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
	if($_SERVER['REQUEST_METHOD'] == 'GET') {
		require_once('connect.php');

		extract($_GET);
	
		if(isset($id))
		{
			$id = mysql_real_escape_string(trim($id));
			$query = "select * from issues where id=$id;";
			$result = mysql_query($query);
		
			$row = mysql_fetch_array($result);
			extract($row);
			print '<?xml version = "1.0" encoding = "utf-8" ?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Aneris - Issue <?php echo $id ?></title>
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
      <p><a href="index.php" class="no-decor"><input type="button" value="Index" /></a><a href="add.php" class="no-decor"><input type="button" value="Add Issue" /></a><a href="logout.php" class="no-decor"><input type="button" value="Logout" /></a></p>
      <div class="left small-pad">
<?php
			
			print "        <h2>$title</h2>\n";
			print "        <p class=\"small-indent\">Last updated: <span class=\"bold\">$updated</span></p>";
			print "        <p class=\"small-indent\">Status: <span class=\"bold\">$status</span></p><br />";
			print '        <p class=\"bold\">Description:</p>';
			print "        <p class=\"description-text\">$description</p>\n";
			print "        <p><a href=\"edit.php?id=$id\"<input type=\"button\" value=\"Edit Issue\" /></a></p>";
		}
	}
?>
      </div>
    </div>
  </body>
</html>
<?php
}
else {
	header('Location: login.php');
}
?>