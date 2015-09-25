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
$query = "SELECT * FROM `transport_table` WHERE (`email` = '$useremail')";
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
  echo 'id="' . $row['id'] . '" ';
  echo 'username="' . $row['username'] . '" ';
  echo 'email="' . $row['email'] . '" ';
  echo 'facebook="' . $row['facebook'] . '" ';
  echo 'ddate="' . $row['ddate'] . '" ';
  echo 'hour="' . $row['hour'] . '" ';
  echo 'people="' . $row['people'] . '" ';
  echo 'direction="' . $row['direction'] . '" ';
  echo 'details="' . $row['details'] . '" ';
  echo 'lat1="' . $row['lat1'] . '" ';
  echo 'lng1="' . $row['lng1'] . '" ';
  echo 'lat2="' . $row['lat2'] . '" ';
  echo 'lng2="' . $row['lng2'] . '" ';
  echo 'status="' . $row['status'] . '" ';
  echo 'distance="' . $row['distance'] . '" ';
  echo 'duration="' . $row['duration'] . '" ';
  echo 'radius="' . $row['radius'] . '" ';
  echo 'name="' . $row['uthname'] . '" ';
  echo 'everyday="' . $row['everyday'] . '" ';
  echo '/>';
}

// End XML file
echo '</markers>';

?>