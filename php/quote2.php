<?php
require_once("connection.php");
// Opens a connection to a MySQL server

$passenger_id = $_REQUEST['passenger_id'];

$mySqlConnection = @mysql_connect ($db_server, $user, $pass) or die ('Error: '.mysql_error());
mysql_set_charset('utf8',$mySqlConnection);

// Set the active MySQL database
$db_selected = mysql_select_db($database, $mySqlConnection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

// Select all the rows in the markers table
//$query = "SELECT * FROM `providers` WHERE `status` = 'Αναμονή για πιστοποίηση...'";
$query = "SELECT `email` FROM `passengers_table` WHERE `passenger_id` = $passenger_id";
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}

header("Content-type: text/xml encoding=UTF-8");

// Start XML file, echo parent node
echo '<quotes>';

// Iterate through the rows, printing XML nodes for each
while ($row = @mysql_fetch_assoc($result)){
  // ADD TO XML DOCUMENT NODE
  echo '<quote ';
	echo 'email="' . $row['email'] . '" ';
  echo '/>';
}

// End XML file
echo '</quotes>';
?>