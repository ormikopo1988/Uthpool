<?php
	$birthyear = $_REQUEST["birthyear"];
	// PHP variable to store the host address
	$db_host  = "localhost";
	// PHP variable to store the username
	$db_uid  = "carpooling";
	// PHP variable to store the password
	$db_pass = "P57G3aWH";
	// PHP variable to store the Database name  
	$db_name  = "carpooling"; 
		// PHP variable to store the result of the PHP function 'mysql_connect()' which establishes the PHP & MySQL connection  
	$db_con = mysql_connect($db_host,$db_uid,$db_pass) or die('could not connect');
	mysql_select_db($db_name);
	$sql = "SELECT * FROM `passengers_table` WHERE `ddate` >= CURDATE();";
	$result = mysql_query($sql);
	while($row=mysql_fetch_assoc($result))
	$output[]=$row;
	print(json_encode($output));
	mysql_close();   
?>