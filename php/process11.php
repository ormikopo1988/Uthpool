<?php
require_once("connection.php");
header('Content-Type: text/html; encoding=UTF-8');
//Pass parameters from marker click
$id = $_REQUEST['id'];
$ddate = $_REQUEST['ddate'];
$hour = $_REQUEST['hour'];
$amea = $_REQUEST['amea'];
$people = $_REQUEST['people'];
$details = $_REQUEST['details'];
$radius = $_REQUEST['radius'];
$direction = $_REQUEST['direction'];

//Establish Connection
$mySqlConnection = @mysql_connect ($db_server, $user, $pass) or die ('Error: '.mysql_error());
mysql_set_charset('utf8',$mySqlConnection);

$sql= sprintf("UPDATE transport_table SET ddate = '%s', hour = '%s', everyday = '%s', people = '%s', direction = '%s', details = '%s', radius = '%s' WHERE id = %d", $ddate, $hour, $amea, $people, $direction, $details, $radius, $id);
		
mysql_select_db($database);

$retval = mysql_query( $sql, $mySqlConnection );

if(! $retval )
{
  die('Could not update data: ' . mysql_error());
}

mysql_close($mySqlConnection);

?>