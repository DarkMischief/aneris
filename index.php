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
	require_once('connect.php');
	
	$next_order = "asc";
	$query = '';
	$query_field = '';
	$query_order = '';

	if(isset($_GET['sort']))
	{
		extract($_GET);
		if($sort == "yes" && isset($field))
		{
			$query_field = $field;
			$query_order = $order;

			$query = "select * from issues where status != 'deleted' order by $field $order;";

			$next_order = ($order == "asc") ? "desc" : "asc";
		}
	}
	else
	{
		$query = "select * from issues where status != 'deleted' order by status desc;";
	}
	print '<?xml version = "1.0" encoding = "utf-8" ?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Aneris - Issues</title>
    <link type="text/css" rel="stylesheet" href="css/issues.css" />
    <script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
    <script src="js/jquery.timers-1.2.js" type="text/javascript"></script>
    <script src="js/issues.js" type="text/javascript"></script>
    <script type="text/javascript">
    	$(".document").ready(function(){
    		$(".issue-table").hide().fadeIn();
    	});
    </script>
  </head>
  <body>
    <div class="issue-table">
      <p><a href="add.php" class="no-decor"><input type="button" value="Add Issue" /></a><a href="logout.php" class="no-decor"><input type="button" value="Logout" /></a></p>
      <table class="center" width="85%">
        <tr>
          <td></td>
          <td class="bigger bold"><a href="index.php?sort=yes&amp;field=title&amp;order=<?php echo $next_order ?>" class="field no-decor">Issue</a></td>
          <td class="bigger bold"><a href="index.php?sort=yes&amp;field=owner&amp;order=<?php echo $next_order ?>" class="field no-decor">Owner</a></td>
          <td class="bigger bold"><a href="index.php?sort=yes&amp;field=status&amp;order=<?php echo $next_order ?>" class="field no-decor">Status</a></td>
          <td class="bigger bold"><a href="index.php?sort=yes&amp;field=updated&amp;order=<?php echo $next_order ?>" class="field no-decor">Updated</a></td>
          <td></td>
          <td colspan="2" class="bigger bold">Status Markers</td>
          <td></td>
        </tr>
<?php
	$result = mysql_query($query);
	
	$index = 0;
	while($row = mysql_fetch_array($result))
	{
		extract($row);
		
		$type = ($index++ % 2 == 0) ? "tan" : "plain";
		
		print "        <tr id=\"issue$id\" class=\"$type hoverable issue-row\">\n";
		print "          <td class=\"view-button\" onclick=\"viewIssue($id)\">View</td>\n";
		print "          <td class=\"bold title-cell\" onclick=\"viewIssue($id)\">$title</td>\n";
		print "          <td class=\"owner-cell\" onclick=\"viewIssue($id)\">$owner</td>\n";
		print "          <td class=\"status-cell ";
		print ($status == "incomplete") ? "incomplete-status" : (($status == "pending") ? "pending-status" : "complete-status");
		print " issue$id-status-cell\" onclick=\"viewIssue($id)\"><span id=\"issue$id-status\">$status</span></td>\n";
		print "          <td class=\"timestamp-cell\" onclick=\"viewIssue($id)\">$updated</td>\n";
		print "          <td class=\"incomplete-button issue-button\" onclick=\"dealWithIssue('incomplete',$id)\">Incomplete</td>\n";
		print "          <td class=\"pending-button issue-button\" onclick=\"dealWithIssue('pending',$id)\">Pending</td>\n";
		print "          <td class=\"complete-button issue-button\" onclick=\"dealWithIssue('complete',$id)\">Complete</td>\n";
		print "          <td class=\"delete-button issue-button\" onclick=\"dealWithIssue('delete',$id)\">Delete</td>\n";
		print "        </tr>\n";
	}
	
	mysql_close();
?>
      </table>
    </div>
	<div id="message-box"></div>
  </body>
</html>
<?php
}
else {
	header('Location: login.php'); 
}