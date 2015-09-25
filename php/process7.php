<?php
require_once("connection.php");
header('Content-Type: text/html; encoding=UTF-8');
//Pass parameters from marker click
$driver_id = $_REQUEST['driver_id'];
$ddate = $_REQUEST['ddate'];
$hour = $_REQUEST['hour'];
$people = $_REQUEST['people'];
$details = $_REQUEST['details'];
$radius = $_REQUEST['radius'];

//Establish Connection
$mySqlConnection = @mysql_connect ($db_server, $user, $pass) or die ('Error: '.mysql_error());
mysql_set_charset('utf8',$mySqlConnection);

$sql= sprintf("UPDATE drivers_table SET ddate = '%s', hour = '%s', people = '%s', details = '%s', radius = '%s' WHERE driver_id = %d", $ddate, $hour, $people, $details, $radius, $driver_id);
		
mysql_select_db($database);

$retval = mysql_query( $sql, $mySqlConnection );

if(! $retval )
{
  die('Could not update data: ' . mysql_error());
}

mysql_close($mySqlConnection);

?>