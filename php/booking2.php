<?php
require_once("connection.php");
//header('Content-Type: text/html; encoding=UTF-8');

$passenger_id = $_GET['passenger_id'];

//Establish Connection
$mySqlConnection = @mysql_connect ($db_server, $user, $pass) or die ('Error: '.mysql_error());
mysql_set_charset('utf8',$mySqlConnection);

$sql = 'UPDATE passengers_table
        SET status="Inactive..."
        WHERE passenger_id='.$passenger_id;
		
mysql_select_db($database);

$retval = mysql_query( $sql, $mySqlConnection );

if(! $retval )
{
  die('Could not update data: ' . mysql_error());
}

mysql_close($mySqlConnection);

?>