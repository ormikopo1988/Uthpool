<?php
require_once("connection.php");
header('Content-Type: text/html; encoding=UTF-8');
//Pass parameters from marker click
$id = $_REQUEST['id'];

//Establish Connection
$mySqlConnection = @mysql_connect ($db_server, $user, $pass) or die ('Error: '.mysql_error());
mysql_set_charset('utf8',$mySqlConnection);

mysql_select_db($database);

// Perform insert
$query = "DELETE FROM transport_table WHERE id = $id";

mysql_query($query) or die(mysql_error());

?>