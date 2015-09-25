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
$people = $_REQUEST['people'];
$details = $_REQUEST['details'];
$lat = $_REQUEST['lat'];
$lng = $_REQUEST['lng'];
$status = $_REQUEST['status'];
$direction = $_REQUEST['direction'];
$dis = $_REQUEST['dis'];
$dur = $_REQUEST['dur'];
$radius = $_REQUEST['radius'];

//Establish Connection
$mySqlConnection = @mysql_connect ($db_server, $user, $pass) or die ('Error: '.mysql_error());
mysql_set_charset('utf8',$mySqlConnection);

mysql_select_db($database);

// Perform insert
$query = "INSERT INTO passengers_table (passenger_id, username, email, facebook, ddate, hour, people, direction, details, lat, lng, status, distance, duration, radius, uthname) VALUES (NULL, '".$fullname."', '".$useremail."', '".$facebook."', '".$ddate."', '".$hour."', '".$people."', '".$direction."', '".$details."', '".$lat."', '".$lng."', '".$status."', '".$dis."', '".$dur."', '".$radius."', '".$uthname."')";

mysql_query($query) or die(mysql_error());

?>