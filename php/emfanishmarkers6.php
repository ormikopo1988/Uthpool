<?php
require_once("connection.php");
$useremail = $_REQUEST['useremail'];
// Opens a connection to a MySQL server
$mySqlConnection = @mysql_connect ($db_server, $user, $pass) or die ('Error: '.mysql_error());
mysql_set_charset('utf8',$mySqlConnection);

// Set the active MySQL database
$db_selected = mysql_select_db($database, $mySqlConnection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

// Select all the rows in the markers table
$query = "SELECT * FROM `passengers_table` WHERE (`email` = '$useremail') OR (`d_email` = '$useremail' AND `ddate` >= CURDATE())";
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}

header("Content-type: text/xml encoding=UTF-8");

// Start XML file, echo parent node
echo '<markers>';

// Iterate through the rows, printing XML nodes for each
while ($row = @mysql_fetch_assoc($result)){
  // ADD TO XML DOCUMENT NODE
  echo '<marker ';
  echo 'passenger_id="' . $row['passenger_id'] . '" ';
  echo 'username="' . $row['username'] . '" ';
  echo 'email="' . $row['email'] . '" ';
  echo 'facebook="' . $row['facebook'] . '" ';
  echo 'ddate="' . $row['ddate'] . '" ';
  echo 'hour="' . $row['hour'] . '" ';
  echo 'people="' . $row['people'] . '" ';
  echo 'direction="' . $row['direction'] . '" ';
  echo 'details="' . $row['details'] . '" ';
  echo 'lat="' . $row['lat'] . '" ';
  echo 'lng="' . $row['lng'] . '" ';
  echo 'status="' . $row['status'] . '" ';
  echo 'distance="' . $row['distance'] . '" ';
  echo 'duration="' . $row['duration'] . '" ';
  echo 'radius="' . $row['radius'] . '" ';
  echo 'd_username="' . $row['d_username'] . '" ';
  echo 'd_email="' . $row['d_email'] . '" ';
  echo 'd_facebook="' . $row['d_facebook'] . '" ';
  echo 'd_details="' . $row['d_details'] . '" ';
  echo 'name="' . $row['uthname'] . '" ';
  echo '/>';
}

// End XML file
echo '</markers>';

?>