<?php
	require_once("connection.php");
	
	//Pass parameters from marker click
	$type1 = $_REQUEST['type1']; //direction - Driver or Passenger
	$swLat = $_REQUEST['swLat']; 
	$swLng = $_REQUEST['swLng']; 
	$neLat = $_REQUEST['neLat']; 
	$neLng = $_REQUEST['neLng'];

	//Establish Connection
	$mySqlConnection = @mysql_connect ($db_server, $user, $pass) or die ('Error: '.mysql_error());
	mysql_set_charset('utf8',$mySqlConnection);

	// Set the active MySQL database
	$db_selected = mysql_select_db($database, $mySqlConnection);
	if (!$db_selected) {
	  die ('Can\'t use db : ' . mysql_error());
	}

	if($type1 == "Driver") {
		$sql2 = "SELECT * FROM `transport_table` WHERE ((direction = 'Driver') AND ((lat1 > $swLat AND lat1 < $neLat ) AND (lng1 > $swLng AND lng1 < $neLng)) AND ((lat2 > $swLat AND lat2 < $neLat ) AND (lng2 > $swLng AND lng2 < $neLng)) AND (`everyday` = 'true'))";
		$sql1 = "SELECT * FROM `transport_table` WHERE ((direction = 'Driver') AND ((lat1 > $swLat AND lat1 < $neLat ) AND (lng1 > $swLng AND lng1 < $neLng)) AND ((lat2 > $swLat AND lat2 < $neLat ) AND (lng2 > $swLng AND lng2 < $neLng)) AND (`ddate` >= CURDATE()) AND (`everyday` = 'false'))";
	}

	else if ($type1 == "Passenger") {
		$sql2 = "SELECT * FROM `transport_table` WHERE ((direction = 'Passenger') AND ((lat1 > $swLat AND lat1 < $neLat ) AND (lng1 > $swLng AND lng1 < $neLng)) AND ((lat2 > $swLat AND lat2 < $neLat ) AND (lng2 > $swLng AND lng2 < $neLng)) AND (`everyday` = 'true'))";
		$sql1 = "SELECT * FROM `transport_table` WHERE ((direction = 'Passenger') AND ((lat1 > $swLat AND lat1 < $neLat ) AND (lng1 > $swLng AND lng1 < $neLng)) AND ((lat2 > $swLat AND lat2 < $neLat ) AND (lng2 > $swLng AND lng2 < $neLng)) AND (`ddate` >= CURDATE()) AND (`everyday` = 'false'))";
	}

	$result1 = mysql_query($sql1);
	if (!$result1) {
	  die('Invalid query: ' . mysql_error());
	}
	
	$result2 = mysql_query($sql2);
	if (!$result2) {
	  die('Invalid query: ' . mysql_error());
	}
	
	header("Content-type: text/xml encoding=UTF-8");

	// Start XML file, echo parent Node
	echo '<markers>';
	
	// Iterate through the rows, printing XML Nodes for each
	while (($row1 = @mysql_fetch_assoc($result1)) || ($row2 = @mysql_fetch_assoc($result2))){
	  if ($row1) {
		  // ADD TO XML DOCUMENT NoDE
		  echo '<marker ';
		  echo 'id="' . $row1['id'] . '" ';
		  echo 'username="' . $row1['username'] . '" ';
		  echo 'email="' . $row1['email'] . '" ';
		  echo 'facebook="' . $row1['facebook'] . '" ';
		  echo 'ddate="' . $row1['ddate'] . '" ';
		  echo 'hour="' . $row1['hour'] . '" ';
		  echo 'people="' . $row1['people'] . '" ';
		  echo 'direction="' . $row1['direction'] . '" ';
		  echo 'details="' . $row1['details'] . '" ';
		  echo 'lat1="' . $row1['lat1'] . '" ';
		  echo 'lng1="' . $row1['lng1'] . '" ';
		  echo 'lat2="' . $row1['lat2'] . '" ';
		  echo 'lng2="' . $row1['lng2'] . '" ';
		  echo 'status="' . $row1['status'] . '" ';
		  echo 'radius="' . $row1['radius'] . '" ';
		  echo 'name="' . $row1['uthname'] . '" ';
		  echo 'everyday="' . $row1['everyday'] . '" ';
		  echo '/>';
	  }
	  
	  else if ($row2) {
		echo '<marker ';
		echo 'id="' . $row2['id'] . '" ';
		echo 'username="' . $row2['username'] . '" ';
		echo 'email="' . $row2['email'] . '" ';
		echo 'facebook="' . $row2['facebook'] . '" ';
		echo 'ddate="' . $row2['ddate'] . '" ';
		echo 'hour="' . $row2['hour'] . '" ';
		echo 'people="' . $row2['people'] . '" ';
		echo 'direction="' . $row2['direction'] . '" ';
		echo 'details="' . $row2['details'] . '" ';
		echo 'lat1="' . $row2['lat1'] . '" ';
		echo 'lng1="' . $row2['lng1'] . '" ';
		echo 'lat2="' . $row2['lat2'] . '" ';
		echo 'lng2="' . $row2['lng2'] . '" ';
		echo 'status="' . $row2['status'] . '" ';
		echo 'radius="' . $row2['radius'] . '" ';
		echo 'name="' . $row2['uthname'] . '" ';
		echo 'everyday="' . $row2['everyday'] . '" ';
		echo '/>';
	  }
	}
	
	// End XML file
	echo '</markers>';
?>