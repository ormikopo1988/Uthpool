<?php
	require_once("connection.php");
	
	//Pass parameters from marker click
	$type1 = $_REQUEST['type1']; //direction
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

	if($type1 == "From Volos") {
		$sql = "SELECT * FROM `drivers_table` WHERE ((direction = 'From Volos') AND ((lat > $swLat AND lat < $neLat ) AND (lng > $swLng AND lng < $neLng)) AND (`ddate` >= CURDATE()))";
	}

	else if ($type1 == "To Volos") {
		$sql = "SELECT * FROM `drivers_table` WHERE ((direction = 'To Volos') AND ((lat > $swLat AND lat < $neLat ) AND (lng > $swLng AND lng < $neLng)) AND (`ddate` >= CURDATE()))";
	}
	
	if($type1 == "From Larisa") {
		$sql = "SELECT * FROM `drivers_table` WHERE ((direction = 'From Larisa') AND ((lat > $swLat AND lat < $neLat ) AND (lng > $swLng AND lng < $neLng)) AND (`ddate` >= CURDATE()))";
	}

	else if ($type1 == "To Larisa") {
		$sql = "SELECT * FROM `drivers_table` WHERE ((direction = 'To Larisa') AND ((lat > $swLat AND lat < $neLat ) AND (lng > $swLng AND lng < $neLng)) AND (`ddate` >= CURDATE()))";
	}
	
	if($type1 == "From Trikala") {
		$sql = "SELECT * FROM `drivers_table` WHERE ((direction = 'From Trikala') AND ((lat > $swLat AND lat < $neLat ) AND (lng > $swLng AND lng < $neLng)) AND (`ddate` >= CURDATE()))";
	}

	else if ($type1 == "To Trikala") {
		$sql = "SELECT * FROM `drivers_table` WHERE ((direction = 'To Trikala') AND ((lat > $swLat AND lat < $neLat ) AND (lng > $swLng AND lng < $neLng)) AND (`ddate` >= CURDATE()))";
	}
	
	if($type1 == "From Karditsa") {
		$sql = "SELECT * FROM `drivers_table` WHERE ((direction = 'From Karditsa') AND ((lat > $swLat AND lat < $neLat ) AND (lng > $swLng AND lng < $neLng)) AND (`ddate` >= CURDATE()))";
	}

	else if ($type1 == "To Karditsa") {
		$sql = "SELECT * FROM `drivers_table` WHERE ((direction = 'To Karditsa') AND ((lat > $swLat AND lat < $neLat ) AND (lng > $swLng AND lng < $neLng)) AND (`ddate` >= CURDATE()))";
	}
	
	if($type1 == "From Lamia") {
		$sql = "SELECT * FROM `drivers_table` WHERE ((direction = 'From Lamia') AND ((lat > $swLat AND lat < $neLat ) AND (lng > $swLng AND lng < $neLng)) AND (`ddate` >= CURDATE()))";
	}

	else if ($type1 == "To Lamia") {
		$sql = "SELECT * FROM `drivers_table` WHERE ((direction = 'To Lamia') AND ((lat > $swLat AND lat < $neLat ) AND (lng > $swLng AND lng < $neLng)) AND (`ddate` >= CURDATE()))";
	}
			
	$result = mysql_query($sql);
	if (!$result) {
	  die('Invalid query: ' . mysql_error());
	}

	header("Content-type: text/xml encoding=UTF-8");

	// Start XML file, echo parent Node
	echo '<markers>';

	// Iterate through the rows, printing XML Nodes for each
	while ($row = @mysql_fetch_assoc($result)){
	  // ADD TO XML DOCUMENT NoDE
	  echo '<marker ';
	  echo 'driver_id="' . $row['driver_id'] . '" ';
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
	  echo 'p_username="' . $row['p_username'] . '" ';
	  echo 'p_email="' . $row['p_email'] . '" ';
	  echo 'p_facebook="' . $row['p_facebook'] . '" ';
	  echo 'p_details="' . $row['p_details'] . '" ';
	  echo 'name="' . $row['uthname'] . '" ';
	  echo '/>';
	}

	// End XML file
	echo '</markers>';

?>