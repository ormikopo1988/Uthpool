<?php
require_once("connection.php");
header('Content-Type: text/html; encoding=UTF-8');
//Pass parameters from marker click
$passenger_id = $_REQUEST['passenger_id'];

//Establish Connection
$mySqlConnection = @mysql_connect ($db_server, $user, $pass) or die ('Error: '.mysql_error());
mysql_set_charset('utf8',$mySqlConnection);

mysql_select_db($database);

// Perform insert
$query = "DELETE FROM passengers_table WHERE passenger_id = $passenger_id";

mysql_query($query) or die(mysql_error());

?>