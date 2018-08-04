<?php
	// setup LDAP parameters
	$name = $_REQUEST['user'];
	$ldapUrl = "ldap.uth.gr";

	$bindDn = "uid=ormikopo,dc=uth,dc=gr";

	$bindPw = "*********************";

	$searchBase = "dc=uth,dc=gr";

	$searchFilter = "(cn=$name)";
	
	// establish LDAP connection

	$ldap = ldap_connect($ldapUrl);

	if (! $ldap) {

		error_log("Could not connect to LDAP server");

	}

	// bind as app user

	if (! ldap_bind($ldap, $bindDn, $bindPw)) {

		error_log(ldap_error($ldap));

	}

	// perform search

	if (($sr = ldap_search($ldap, $searchBase, $searchFilter)) == FALSE) {

		error_log(ldap_error($ldap));

	}

	// retrieve entry

	$entry = ldap_first_entry($ldap, $sr);

	if ($entry) {

		$vals1 = ldap_get_values($ldap, $entry, "eduPersonOrgUnitDN");
		$temp1   = explode(',',$vals1[0]);
		$temp2   = array_slice($temp1, 0, 1);
		$vals1 = implode(',', $temp2);
		$vals2 = ldap_get_values($ldap, $entry, "eduPersonAffiliation");
		$vals3 = ldap_get_values($ldap, $entry, "uid");
		$vals4 = ldap_get_values($ldap, $entry, "cn");
		$vals5 = ldap_get_values($ldap, $entry, "mail");
	}
	
	header("Content-type: text/xml encoding=UTF-8");

	// Start XML file, echo parent node
	// Iterate through the rows, printing XML nodes for each
	  // ADD TO XML DOCUMENT NODE
	echo '<users>';
	
		echo '<user ';
		echo 'uname="' . $vals3[0] . '" ';
		echo 'name="' . $vals4[0] . '" ';
		echo 'mail="' . $vals5[0] . '" ';
		echo 'affiliation="' . $vals2[0] . '" ';
		echo 'unit="' . $vals1 . '" ';
		echo '/>';

	// End XML file
	echo '</users>';

	ldap_close($ldap);
    //LDAP stuff here.
    /*$username = "ormikopo";
    $password = "**************************";
	
    $ds = ldap_connect("ldap.uth.gr");
    
    //Can't connect to LDAP.
    if(!ds) {
        echo "Error in contacting the LDAP server -- contact ";
    }
    
    //Connection made -- bind anonymously and get dn for username.
    $bind = @ldap_bind($ds);
    
    //Check to make sure we're bound.
    if(!bind) {
        echo "Anonymous bind to LDAP FAILED.  Contact Tech Services! (Debug 2)";
    }
    
    $search = ldap_search($ds, "dc=uth,dc=gr", "uid=$username");
    
    //Make sure only ONE result was returned -- if not, they might've thrown a * into the username.  Bad user!
    if( ldap_count_entries($ds,$search) != 1 ) {
        echo "Problem1";
    }
    
    $info = ldap_get_entries($ds, $search);
    
    //Now, try to rebind with their full dn and password.
    $bind = @ldap_bind($ds, $info[0][dn], $password);
    if( !$bind || !isset($bind)) {
        echo "Problem2";
    }
    
    //Now verify the previous search using their credentials.
    $search = ldap_search($ds, "dc=uth,dc=gr", "uid=$username");
        
    $info = ldap_get_entries($ds, $search);
	
	if ($info) {

		$vals = ldap_get_values($ds, $info, "eduPersonAffiliation");

		 

		// examine values

		foreach($vals as $v) {

			echo 'eduPersonAffiliation: ',$v,"\n";

		}

	}
	
    if($username == $info[0][uid][0]) {
        $_SESSION['username'] = $username;
        $_SESSION['fullname'] = $info[0][cn][0];
		echo $username;
		echo " ";
		echo $info[0][mail][0];
		echo " ";
		echo $info[0][eduPersonOrgUnitDN][0];
		echo "Success!";
    }
    else {
        echo "Problem3";
	}
    ldap_close($ds);
    exit;*/
?>
