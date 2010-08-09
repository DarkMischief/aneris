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

	extract($_GET);
	$id = '';
	if(isset($pending)){
		$id = mysql_real_escape_string(trim($pending));
		$query = "update issues set status='pending' where id=$id;";
	}
	else if(isset($complete)){
		$id = mysql_real_escape_string(trim($complete));
		$query = "update issues set status='complete' where id=$id;";
	}
	else if(isset($incomplete)){
		$id = mysql_real_escape_string(trim($incomplete));
		$query = "update issues set status='incomplete' where id=$id;";
	}
	else if(isset($delete)){
		$id = mysql_real_escape_string(trim($delete));
		$query = "update issues set status='deleted' where id=$id;";
	}
	
	$message = mysql_query($query) ? $id : 'no';

	echo $message;
}
else {
	header('Location: login.php');
}
?>