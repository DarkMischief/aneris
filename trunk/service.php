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

// choose data format
// JSON is the default
if(isset($_GET['format']) && strtolower($_GET['format']) == 'xml')
	$format = 'xml';
else
	$format = 'json';

if(isset($_GET['username']))
	$user = strtolower($_GET['username']);
else if(isset($_SESSION['uid']))
	$user = $_SESSION['uid'];
else
	$user = '';

// connect/select
require_once('connect.php');

// build query based on query string
$query = 'select * from issues where ';

$parameters = 0;

if($user != '')
{
	$query = $query .  "owner='$user'";
	$parameters++;
}

if(isset($_GET['initializer'])){
	if($parameters > 0) 
		$query = $query . "and ";

	$query = $query . "initializer='$_GET[initializer]'";
	$parameters++;
}
	
if(isset($_GET['status'])){
	if($parameters > 0)
		$query = $query . "and ";
		
	if($_GET['status'] != 'deleted'){
		$query = $query . "status='$_GET[status]'";
		$parameters++;
	}
}

if(isset($_GET['owner'])){
	if($parameters > 0) 
		$query = $query . "and ";

	$query = $query . "owner='$_GET[owner]'";
	$parameters++;
}

if($parameters === 0)
	$query = "select * from issues where status != 'deleted';";
else
	$query = $query.' and status != \'deleted\';';
	
$result = mysql_query($query) or die('Error: '.$query);

// construct array of issues
$issues = array();
$i=0;
while($issue = mysql_fetch_array($result)) {
	$issues[$i++] = array($i=>$issue);
}

/* output in necessary format */
if($format == 'json') {
	header('Content-type: application/json');
	print json_encode(array('issues'=>$issues));
}
else {
	header('Content-type: text/xml');
	echo "<issues>\n";
	foreach($issues as $index => $issue) {
		if(is_array($issue)) {
			foreach($issue as $key => $value) {
				echo "  <issue>\n";
				if(is_array($value)) {
					foreach($value as $tag => $val) {
						if(!is_numeric($tag)){
							echo "    <",$tag,">",htmlentities($val),"</",$tag,">\n";
						}
					}
				}
				echo "  </issue>\n";
			}
		}
	}
	echo "</issues>";
}

// disconnect
mysql_close();
?>