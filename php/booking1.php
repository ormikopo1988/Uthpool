<?php
require_once("connection.php");
//header('Content-Type: text/html; encoding=UTF-8');

$driver_id = $_GET['driver_id'];

//Establish Connection
$mySqlConnection = @mysql_connect ($db_server, $user, $pass) or die ('Error: '.mysql_error());
mysql_set_charset('utf8',$mySqlConnection);

$sql = 'UPDATE drivers_table
        SET status="Inactive..."
        WHERE driver_id='.$driver_id;
		
mysql_select_db($database);

$retval = mysql_query( $sql, $mySqlConnection );

if(! $retval )
{
  die('Could not update data: ' . mysql_error());
}

mysql_close($mySqlConnection);

?>