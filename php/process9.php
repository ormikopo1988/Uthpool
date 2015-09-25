<?php
require_once("connection.php");
header('Content-Type: text/html; encoding=UTF-8');
//Pass parameters from marker click
$uthname = $_REQUEST['uthname'];
$fullname = $_REQUEST['fullname'];
$useremail = $_REQUEST['useremail'];
$facebook = $_REQUEST['facebook'];
$ddate = urldecode ($_REQUEST['ddate']);
$hour = $_REQUEST['hour'];
$everyday = $_REQUEST['amea'];
$people = $_REQUEST['people'];
$details = $_REQUEST['details'];
$lat1 = $_REQUEST['lat1'];
$lng1 = $_REQUEST['lng1'];
$lat2 = $_REQUEST['lat2'];
$lng2 = $_REQUEST['lng2'];
$status = $_REQUEST['status'];
$direction = $_REQUEST['direction'];
$radius = $_REQUEST['radius'];

//Establish Connection
$mySqlConnection = @mysql_connect ($db_server, $user, $pass) or die ('Error: '.mysql_error());
mysql_set_charset('utf8',$mySqlConnection);

mysql_select_db($database);

// Perform insert
$query = "INSERT INTO transport_table (id, username, email, facebook, ddate, hour, people, direction, details, lat1, lng1, lat2, lng2, status, radius, uthname, everyday) VALUES (NULL, '".$fullname."', '".$useremail."', '".$facebook."', '".$ddate."', '".$hour."', '".$people."', '".$direction."', '".$details."', '".$lat1."', '".$lng1."', '".$lat2."', '".$lng2."', '".$status."', '".$radius."', '".$uthname."', '".$everyday."')";

mysql_query($query) or die(mysql_error());
?>