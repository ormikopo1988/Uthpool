<?php
	function popup($vMsg,$vDestination) {
		echo("<html>\n");
		echo("<head>\n");
		echo("<script language=\"JavaScript\" type=\"text/JavaScript\">\n");
		echo("alert('$vMsg');\n");
		echo("window.location = ('$vDestination');\n");
		echo("</script>\n");
		echo("</head>\n");
		echo("</html>\n");
		exit();
	}
	if( isset($_POST['username']) && isset($_POST['password']) ) {
		//LDAP stuff here.
		$username = trim($_REQUEST['username']);
		$password = trim($_REQUEST['password']);
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
			popup('Λάθος όνομα χρήστη/κωδικός.Προσπαθήστε ξανά!','LoginPage.php');
			header("Location:LoginPage2.php");
		}
		$info = ldap_get_entries($ds, $search);
		//Now, try to rebind with their full dn and password.
		$bind = @ldap_bind($ds, $info[0][dn], $password);
		if( !$bind || !isset($bind)) {
			popup('Λάθος όνομα χρήστη/κωδικός.Προσπαθήστε ξανά!','LoginPage.php');
			header("Location:LoginPage2.php");
		}
		//Now verify the previous search using their credentials.
		$search = ldap_search($ds, "dc=uth,dc=gr", "uid=$username");	
		$info = ldap_get_entries($ds, $search);
		if($username == $info[0][uid][0]) {
			$_SESSION['username'] = $username;
			$_SESSION['fullname'] = $info[0][cn][0];
			$_SESSION['email'] = $info[0][mail][0];
		}
		else {
			popup('Λάθος όνομα χρήστη/κωδικός.Προσπαθήστε ξανά!','LoginPage.php');
			header("Location:LoginPage2.php");
		}
	}
	else {
		Logout();
	}
	function Logout() {
	   session_start();
	   session_unset();
	   header("Location:LoginPage2.php");
	   return false;
	   exit();
	}
?>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>UthPool</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css"/>
	<style type="text/css">
			html,body {width:100%;height:100%;margin:0;padding:0;}
			.controls {
				margin-top: 5px;
				border: 1px solid transparent;
				border-radius: 2px 0 0 2px;
				box-sizing: border-box;
				-moz-box-sizing: border-box;
				height: 30px;
				outline: none;
				box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
			}
			#search3 {
				background-color: #fff;
				padding: 0 11px 0 13px;
				width: 226px;
				font-family: Roboto;
				font-size: 15px;
				font-weight: 300;
				text-overflow: ellipsis;
			}
			#search3:focus {
				border-color: #4d90fe;
				margin-left: -1px;
				padding-left: 14px;
				width: 227px;
			}
			#search5 {
				background-color: #fff;
				padding: 0 11px 0 13px;
				width: 226px;
				font-family: Roboto;
				font-size: 15px;
				font-weight: 300;
				text-overflow: ellipsis;
			}
			#search5:focus {
				border-color: #4d90fe;
				margin-left: -1px;
				padding-left: 14px;
				width: 227px;
			}
			.controls2 {
				margin-top: -2px;
				border: 1px solid transparent;
				border-radius: 2px 0 0 2px;
				box-sizing: border-box;
				-moz-box-sizing: border-box;
				height: 27px;
				outline: none;
				box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
			}
			#map-canvas
			{
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
			}
			#directions-panel {
				height: 40%;
				float: right;
				width: 20%;
				overflow: auto;
				background: #DCEEF4;
			}
			#login_button {
				color:white;
				//z-index:100;
				padding:5px;
				background: rgba(0,0,0,.35);
				//position:absolute;
				border-radius: 5px;
				width:150px;
				height:120px;
				//display:none;
			}
			#recent_posts {
				color:white;
				z-index:100;
				padding:10px;
				background: rgba(0,0,0,.5);
				position:absolute;
				border-radius: 5px;
				top:30px;
				right:10px;
				width:345px;
				height:100px;
				display:none;
			}
			#in_posts {
				color:white;
				z-index:100;
				padding:10px;
				background: rgba(0,0,0,.5);
				position:absolute;
				border-radius: 5px;
				top:160px;
				right:10px;
				width:300px;
				height:195px;
				display:none;
			}
			#help {
				background: none repeat scroll 0 0 rgba(0, 0, 0, 0.5);
				border-radius: 5px;
				color: #FFFFFF;
				display: none;
				height: 437px;
				padding: 9px;
				position: absolute;
				right: 10px;
				top: 30px;
				width: 616px;
				z-index: 100;
			}
			#admin {
				background: none repeat scroll 0 0 rgba(0, 0, 0, 0.5);
				border-radius: 5px;
				color: #FFFFFF;
				display: none;
				height: 140px;
				padding: 9px;
				position: absolute;
				right: 10px;
				top: 30px;
				width: 265px;
				z-index: 100;
			}
			#face {
				background: none repeat scroll 0 0 rgba(0, 0, 0, 0.5);
				border-radius: 5px;
				color: #FFFFFF;
				display: none;
				height: 140px;
				padding: 9px;
				position: absolute;
				right: 10px;
				top: 30px;
				width: 265px;
				z-index: 100;
			}
			.close_box{
				background:#00AEEF;
				color:#fff;
				padding:1px 4px 1px;
				display:inline;
				position:absolute;
				right:0px;
				top:0px;
				height:20px;
				border-radius:3px;
				cursor:pointer;
				z-index:100;
				text-decoration:none;
			}
			.gmnoprint a, .gmnoprint span {
				display:none;
			}
			#GMapsID div div a div img {
				display:none;
			}
			/*<![CDATA[*/
			.fbplbadge2 {background-color:#3B5998;display: block;height: 50px;top: 50%;margin-top: -145px;margin-left: 109px;position: absolute;bottom: -100px;width: 140px;transform:rotate(-0deg);background-image: url("http://www.gasmems.eu/site/www/fichiers/UTH_en.gif");background-repeat: no-repeat;overflow: hidden;-webkit-border-top-right-radius: 8px;-webkit-border-top-left-radius: 8px;-moz-border-radius-topright: 8px;-moz-border-radius-topleft: 8px;border-top-right-radius: 8px;border-top-left-radius: 8px;}
			.fbplbadge4 {background-color:#3B5998;display: block;height: 50px;top: 50%;margin-top: -146px;margin-left: 109px;position: absolute;bottom: -100px;width: 140px;transform:rotate(-0deg);background-image: url("http://www.gasmems.eu/site/www/fichiers/UTH_en.gif");background-repeat: no-repeat;overflow: hidden;-webkit-border-top-right-radius: 8px;-webkit-border-top-left-radius: 8px;-moz-border-radius-topright: 8px;-moz-border-radius-topleft: 8px;border-top-right-radius: 8px;border-top-left-radius: 8px;}
			/*]]>*/
		</style>
		<script type="text/javascript"
			src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyBvJFVY3P3bwTflFzlBIU6pdPQjTqGpsNQ&sensor=false&libraries=geometry">
		</script>
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<script type="text/javascript">
			function load() {
				show2();
			}
			var geocoder = new google.maps.Geocoder();
			
			function detailed1(type1, dest) {
				var errors = '';
				var dest = jQuery("#detailed_form1 [name='opt']").val();
				var type1 = jQuery("#detailed_form1 [name='type1']").val();
				if (type1=="1") {
					errors += ' - Παρακαλούμε επιλέξτε κατεύθυνση\n';
				}
				if (errors) {
					errors = ' Διαπιστώθηκαν τα παρακάτω σφάλματα: \n' + errors;
					alert(errors);
					return false;
				}
				else {
					for (var i=0; i<passengeroffer.length; i++) {
						passengeroffer[i].setVisible(false);
						InfoWindow.close();
					}
					passengeroffer = [];
					geocoder.geocode( { 'address': dest}, function(results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							map.setCenter(results[0].geometry.location);
							var lat = results[0].geometry.location.lat();
							var lng = results[0].geometry.location.lng();
							map.setZoom(12);
							load10(map,type1);
						} 
						else {
						  load10(map,type1);
						}
					});
					jQuery("#detailed_form1").clearForm().clearFields().resetForm();
				}
			}
			
			function detailed2(type1, dest) {
				var errors = '';
				var dest = jQuery("#detailed_form2 [name='opt']").val();
				var type1 = jQuery("#detailed_form2 [name='type1']").val();
				if (type1=="1") {
					errors += ' - Παρακαλούμε επιλέξτε κατεύθυνση\n';
				}
				if (errors) {
					errors = ' Διαπιστώθηκαν τα παρακάτω σφάλματα: \n' + errors;
					alert(errors);
					return false;
				}
				else {
					for (var i=0; i<driveroffer.length; i++) {
						driveroffer[i].setVisible(false);
						InfoWindow.close();
					}
					driveroffer = [];
					geocoder.geocode( { 'address': dest}, function(results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							map.setCenter(results[0].geometry.location);
							var lat = results[0].geometry.location.lat();
							var lng = results[0].geometry.location.lng();
							map.setZoom(12);
							load11(map,type1);
						} 
						else {
						  load11(map,type1);
						}
					});
					jQuery("#detailed_form2").clearForm().clearFields().resetForm();
				}
			}

			function transport(opt, type1) {
				var errors = '';
				var dest = jQuery("#detailed_form3 [name='opt']").val();
				var type = jQuery("#detailed_form3 [name='type1']").val();
				if (dest == "1") {
					errors += ' - Παρακαλούμε επιλέξτε πόλη\n';
				}
				if (type == "2") {
					errors += ' - Παρακαλούμε δηλώστε τι ψάχνετε\n';
				}
				if (errors) {
					errors = ' Διαπιστώθηκαν τα παρακάτω σφάλματα: \n' + errors;
					alert(errors);
					return false;
				}
				else {
					state = 0;
					driveroffer = [];
					geocoder.geocode( { 'address': dest}, function(results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							map.setCenter(results[0].geometry.location);
							var lat = results[0].geometry.location.lat();
							var lng = results[0].geometry.location.lng();
							map.setZoom(14);
							load12(map,type);
						}
					});
					google.maps.event.addListener(map,"click", function() {
						for (var i=0; i<tmpmarkers.length; i++) {
							inInfoWindow.close();
						}
					});
					for (var i=0; i<tmpmarkers.length; i++) {
						tmpmarkers[i].setMap(null);
					}
					jQuery("#detailed_form3").clearForm().clearFields().resetForm();
				}
				return false;
			}
			
			function load10(map,type1) {
				var bounds = map.getBounds();
				var swPoint = bounds.getSouthWest();
				var nePoint = bounds.getNorthEast();
				var swLat = swPoint.lat();
				var swLng = swPoint.lng();
				var neLat = nePoint.lat();
				var neLng = nePoint.lng();
				downloadUrl('php/process5.php?type1=' +type1+ '&swLat=' +swLat+ '&swLng=' +swLng+ '&neLat=' +neLat+ '&neLng=' +neLng, function(data) {
					var data = new XMLHttpRequest(); 
					data.open("GET", 'php/process5.php?type1=' +type1+ '&swLat=' +swLat+ '&swLng=' +swLng+ '&neLat=' +neLat+ '&neLng=' +neLng, false); 
					data.overrideMimeType("text/xml");
					data.send(null);
					var xml = data.responseXML;
					var markers = xml.documentElement.getElementsByTagName("marker");
					for (var i = 0; i < markers.length; i++) {
						var passenger_id = markers[i].getAttribute("passenger_id");
						var name = markers[i].getAttribute("name");
						var username = markers[i].getAttribute("username");
						var email = markers[i].getAttribute("email");
						var facebook = markers[i].getAttribute("facebook");
						var ddate = markers[i].getAttribute("ddate");
						var hour = markers[i].getAttribute("hour");
						var people = markers[i].getAttribute("people");
						var direction = markers[i].getAttribute("direction");
						var details = markers[i].getAttribute("details");
						var point = new google.maps.LatLng(
							parseFloat(markers[i].getAttribute("lat")),
							parseFloat(markers[i].getAttribute("lng")));
						var status = markers[i].getAttribute("status");
						var distance = markers[i].getAttribute("distance");
						var duration = markers[i].getAttribute("duration");
						var radius = markers[i].getAttribute("radius");
						var d_username = markers[i].getAttribute("d_username");
						var d_email = markers[i].getAttribute("d_email");
						var d_facebook = markers[i].getAttribute("d_facebook");
						var d_details = markers[i].getAttribute("d_details");
						var marker = createMarker4(passenger_id,name,username,email,facebook,ddate,hour,people,details,point,status,distance,duration,radius,d_username,d_email,d_facebook,d_details,direction);
						passengeroffer.push(marker);
						google.maps.event.trigger(marker,"click");
					}
					InfoWindow.close();
					directionsDisplay.setMap(null);
				});
				function downloadUrl(url, callback) {
					var request = window.ActiveXObject ?
					new ActiveXObject('Microsoft.XMLHTTP') :
					new XMLHttpRequest;

					request.onreadystatechange = function() {
						if (request.readyState == 4) {
							request.onreadystatechange = doNothing;
							callback(request, request.status);
						}
					};
					request.open('GET', url, true);
					request.send(null);
				}
				function doNothing() {}
			}
			
			function load11(map,type1) {
				var bounds = map.getBounds();
				var swPoint = bounds.getSouthWest();
				var nePoint = bounds.getNorthEast();
				var swLat = swPoint.lat();
				var swLng = swPoint.lng();
				var neLat = nePoint.lat();
				var neLng = nePoint.lng();
				downloadUrl('php/process6.php?type1=' +type1+ '&swLat=' +swLat+ '&swLng=' +swLng+ '&neLat=' +neLat+ '&neLng=' +neLng, function(data) {
					var data = new XMLHttpRequest(); 
					data.open("GET", 'php/process6.php?type1=' +type1+ '&swLat=' +swLat+ '&swLng=' +swLng+ '&neLat=' +neLat+ '&neLng=' +neLng, false); 
					data.overrideMimeType("text/xml");
					data.send(null);
					var xml = data.responseXML;
					var markers = xml.documentElement.getElementsByTagName("marker");
					for (var i = 0; i < markers.length; i++) {
						var driver_id = markers[i].getAttribute("driver_id");
						var name = markers[i].getAttribute("name");
						var username = markers[i].getAttribute("username");
						var email = markers[i].getAttribute("email");
						var facebook = markers[i].getAttribute("facebook");
						var ddate = markers[i].getAttribute("ddate");
						var hour = markers[i].getAttribute("hour");
						var people = markers[i].getAttribute("people");
						var direction = markers[i].getAttribute("direction");
						var details = markers[i].getAttribute("details");
						var point = new google.maps.LatLng(
							parseFloat(markers[i].getAttribute("lat")),
							parseFloat(markers[i].getAttribute("lng")));
						var status = markers[i].getAttribute("status");
						var distance = markers[i].getAttribute("distance");
						var duration = markers[i].getAttribute("duration");
						var radius = markers[i].getAttribute("radius");
						var p_username = markers[i].getAttribute("p_username");
						var p_email = markers[i].getAttribute("p_email");
						var p_facebook = markers[i].getAttribute("p_facebook");
						var p_details = markers[i].getAttribute("p_details");
						var marker = createMarker3(driver_id,name,username,email,facebook,ddate,hour,people,details,point,status,distance,duration,radius,p_username,p_email,p_facebook,p_details,direction);
						driveroffer.push(marker);
						google.maps.event.trigger(marker,"click");
					}
					InfoWindow.close();
					directionsDisplay.setMap(null);
				});
				function downloadUrl(url, callback) {
					var request = window.ActiveXObject ?
					new ActiveXObject('Microsoft.XMLHTTP') :
					new XMLHttpRequest;

					request.onreadystatechange = function() {
						if (request.readyState == 4) {
							request.onreadystatechange = doNothing;
							callback(request, request.status);
						}
					};
					request.open('GET', url, true);
					request.send(null);
				}
				function doNothing() {}
			}
			
			function load12(map,type1) {
				showmarkers3 = [];
				showmarkers4 = [];
				for (var i=0; i<show3markers.length; i++) {
					show3markers[i].setVisible(false);
					InfoWindow.close();
				}
				for (var i=0; i<show4markers.length; i++) {
					show4markers[i].setVisible(false);
					InfoWindow.close();
				}
				var bounds = map.getBounds();
				var swPoint = bounds.getSouthWest();
				var nePoint = bounds.getNorthEast();
				var swLat = swPoint.lat();
				var swLng = swPoint.lng();
				var neLat = nePoint.lat();
				var neLng = nePoint.lng();
				downloadUrl('php/process10.php?type1=' +type1+ '&swLat=' +swLat+ '&swLng=' +swLng+ '&neLat=' +neLat+ '&neLng=' +neLng, function(data) {
					var data = new XMLHttpRequest(); 
					data.open("GET", 'php/process10.php?type1=' +type1+ '&swLat=' +swLat+ '&swLng=' +swLng+ '&neLat=' +neLat+ '&neLng=' +neLng, false); 
					data.overrideMimeType("text/xml");
					data.send(null);
					var xml = data.responseXML;
					var markers = xml.documentElement.getElementsByTagName("marker");
					for (var i = 0; i < markers.length; i++) {
						var id = markers[i].getAttribute("id");
						var username = markers[i].getAttribute("username");
						var email = markers[i].getAttribute("email");
						var facebook = markers[i].getAttribute("facebook");
						var ddate = markers[i].getAttribute("ddate");
						var hour = markers[i].getAttribute("hour");
						var people = markers[i].getAttribute("people");
						var direction = markers[i].getAttribute("direction");
						var details = markers[i].getAttribute("details");
						var point1 = new google.maps.LatLng(
							parseFloat(markers[i].getAttribute("lat1")),
							parseFloat(markers[i].getAttribute("lng1")));
						var point2 = new google.maps.LatLng(
							parseFloat(markers[i].getAttribute("lat2")),
							parseFloat(markers[i].getAttribute("lng2")));
						var status = markers[i].getAttribute("status");
						var radius = markers[i].getAttribute("radius");
						var name = markers[i].getAttribute("name");
						var everyday = markers[i].getAttribute("everyday");
						var marker = createMarker5(id,username,email,facebook,ddate,hour,people,direction,details,point1,point2,status,radius,name,everyday);
						passengeroffer.push(marker);
						google.maps.event.trigger(marker,"click");
					}
					InfoWindow.close();
					directionsDisplay.setMap(null);
					for (var i=0; i<show3markers.length; i++) {
						show3markers[i].setMap(null);
					}
				});
				function downloadUrl(url, callback) {
					var request = window.ActiveXObject ?
					new ActiveXObject('Microsoft.XMLHTTP') :
					new XMLHttpRequest;

					request.onreadystatechange = function() {
						if (request.readyState == 4) {
							request.onreadystatechange = doNothing;
							callback(request, request.status);
						}
					};
					request.open('GET', url, true);
					request.send(null);
				}
				function doNothing() {}
			}
		</script>
  </head>
  <body onload="load()">
    <div id="map-canvas"></div>
	<div id="logo">
		<a href="http://deaneng.uth.gr/en/" target="_blank"><img border="0" src="/images/uth.png" alt="Πανεπιστήμιο Θεσσαλίας - Πολυτεχνική Σχολή" style="padding-top: 6px"></a>
	</div>
	<div id="help" style="display: block;">
		<a href="#" class="close_box" id="close_recent_posts_div">Κλείσιμο </a>
		<table border="1" id="sxhma2" align="center">
		  <tbody><tr>
			<td>
				<p style="font-weight:bold; font-size:10pt; text-align:center; color:white;"><b>ΣΥΜΒΟΛΑ</b></p>
			</td>
			<td>
				<p style="font-weight:bold; font-size:10pt; text-align:center; color:white;"><b>ΕΠΕΞΗΓΗΣΗ</b></p>
			</td>
		  </tbody></tr>
		  <tbody><tr>
			<td>
				<div align="center">
					<img src="images/blue_Marker_new2.png"/>
				</div>
			</td>
			<td>
				<p style="color:white; font-weight:bold; text-align:center">Οδηγοί με την αναγραφόμενη στο παράθυρο πληροφοριών αφετηρία και προορισμό την κορυφή του δείκτη</p>
			</td>
		  </tbody></tr>
		  <tbody><tr>
			<td>
				<div align="center">
					<img src="images/blue_Marker_new3.png"/>
				</div>
			</td>
			<td>
				<p style="color:white; font-weight:bold; text-align:center">Οδηγοί με αφετηρία την ουρά του δείκτη και τον αναγραφόμενο στο παράθυρο πληροφοριών προορισμό</p>
			</td>
		  </tbody></tr>
		  <tbody><tr>
			<td>
				<div align="center">
					<img src="images/marker_red2.png"/>
				</div>
			</td>
			<td>
				<p style="color:white; font-weight:bold; text-align:center">Συνεπιβάτες με την αναγραφόμενη στο παράθυρο πληροφοριών αφετηρία και προορισμό την κορυφή του δείκτη</p>
			</td>
		  </tbody></tr>
		  <tbody><tr>
			<td>
				<div align="center">
					<img src="images/marker_red3.png"/>
				</div>
			</td>
			<td>
				<p style="color:white; font-weight:bold; text-align:center">Συνεπιβάτες με αφετηρία την ουρά του δείκτη και τον αναγραφόμενο στο παράθυρο πληροφοριών προορισμό</p>
			</td>
		  </tbody></tr>
		</table><br>
		<div align="center">
			<iframe width="450" height="190" src="//www.youtube.com/embed/Kqoz0yfnSV0" frameborder="0" allowfullscreen></iframe>
		</div>
		<div style="font-size:8pt; margin-top: 5px;">* Οι ονομασίες των χωρών προέρχονται από τη βάση δεδομένων της Google και δεν έχουμε ουδεμία ευθύνη για το περιεχόμενο τους</div>
	</div>
	<div id="admin" style="display: block;">
		<a href="#" class="close_box" id="close_recent_posts_div3">Κλείσιμο </a>
		<h5 style="color:white;"><u>Στοιχεία δημιουργού</u></h5>
		<ul>
		  <li><strong>Όνομα:</strong> Μεϊκόπουλος Ορέστης</li>
		  <li><strong>E-mail:</strong> diktyas1988@gmail.com</li>
		  <li><strong>Τηλέφωνο:</strong> +30 24210 74935</li>
		  <li><strong>SkypeID:</strong> ormikopo</li>
		  <li><strong>Διεύθυνση:</strong> Γκλαβάνη 37, 38221 Βόλος</li>
		</ul>
	</div>
	<div id="face" style="display: block;">
		<a href="#" class="close_box" id="close_recent_posts_div5">Κλείσιμο </a>
		<div align="center">
			<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Futhpool&amp;width&amp;height=103&amp;colorscheme=dark&amp;show_faces=false&amp;header=true&amp;stream=true&amp;show_border=true&amp;appId=197807020430151" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:104px; width:251px;" allowTransparency="true"></iframe><br>
			<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Futhpool&amp;width&amp;layout=button_count&amp;action=recommend&amp;show_faces=false&amp;share=true&amp;height=21&amp;appId=197807020430151" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:21px; width:200px;" allowTransparency="true"></iframe>
		</div>
	</div>
	<div id="main_menu">
	<div style="padding-top: 10px;">
		<table border="0">
			<tbody>
			<tr>
			<td>
				<span style="margin-left:0px; font-size:13pt; font-weight:bold">
					<a class="option1" id="target1" href="javascript:void(0);" onclick="this.style.color='white';this.style.background='blue';target2.style.background='grey';target2.style.color='white';">Οδηγός</a>
				<span style="margin-left:10px">
					<a class="option2" id="target2" href="javascript:void(0);" onclick="this.style.color='white';this.style.background='red';target1.style.background='grey';target1.style.color='white';">Συνεπιβάτης</a></span>
				</span>
			</td>
			</tr>
			</tbody>
		</table>
	</div>
	</div>
	<div id="submenu">
		<div style="padding: 5px; padding-left: 0px;">
			<span style="padding-left:15px"><input type="submit" value="" title="Έξοδος <?php echo $username ?>" id="target6" onclick="logout(); return false" style="font-family:sans-serif; font-size:12pt; font-weight:bold; background-image:url('images/exit.gif'); none; color:white; width:1.6em">
			</SUBMIT></span>
			<span style="padding-left:15px">
			<input type="submit" value="" title="Στοιχεία επικοινωνίας του διαχειριστή" id="target5"
			style="font-family:sans-serif; font-size:12pt;
			font-weight:bold; background-image:url('images/contact.gif'); none; color:white; width:2.1em" onclick="admin(); return false">
			</SUBMIT>
			</span>
			<span style="padding-left:15px">
			<input type="submit" value="" title="Βοήθεια" id="target3"
			style="font-family:sans-serif; font-size:12pt;
			font-weight:bold; background-image:url('images/help.gif'); none; color:white; width:1.4em" onclick="help(); return false">
			</SUBMIT>
			</span>
			<span style="padding-left:15px">
			<input type="submit" value="" title="Facebook page" id="target6"
			style="font-family:sans-serif; font-size:12pt;
			font-weight:bold; background-image:url('http://www.bosch.com/media/_tech_magazine/layout_magazine/images_magazine/share_icons/share_icons_small/share_facebook.png'); none; color:white; width:1.6em" onclick="face(); return false">
			</SUBMIT>
			</span>
		</div>
	</div>
	<div id="drivers">
		<div class="fbplbadge2"></div>
		<table style="background:#DCEEF4" border="1" cellpadding="10">
			<tbody>
				<tr>
					<td align="center">
						<div id="controls1" style="padding-left: 0px; padding-top:0px; font-size:12pt; font-family:sans-serif">
							<b>1. Διπλό κλικ για δήλωση ταξιδιού ή</b>
						</div>
					</td>
				</tr>
				<tr>
					<td align="center" colspan="2">
						<div id="first_search">
							<b>2. Επίλεξε(ή zoom) αφετηρία/προορισμό <br>και στη συνέχεια επίλεξε <span style="color:red;">συνεπιβάτη</span></b>
							<form id="detailed_form1" method="post" action="php/process3.php">
								<select name="opt" id="opt">
									<option selected value="">-Επίλεξε πόλη-</option>
									<option value="Αθήνα">Αθήνα
									<option value="Θεσσαλονίκη">Θεσσαλονίκη
									<option value="Λάρισα">Λάρισα
									<option value="Τρίκαλα">Τρίκαλα
									<option value="Καρδίτσα">Καρδίτσα
									<option value="Αλεξανδρούπολη">Αλεξανδρούπολη
									<option value="Άμφισσα">Άμφισσα
									<option value="Άρτα">Άρτα	
									<option value="Βέροια">Βέροια
									<option value="Γρεβενά">Γρεβενά
									<option value="Δράμα">Δράμα
									<option value="Έδεσσα">Έδεσσα
									<option value="Ιωάννινα">Ιωάννινα
									<option value="Καβάλα">Καβάλα
									<option value="Καλαμάτα">Καλαμάτα
									<option value="Καστοριά">Καστοριά
									<option value="Κατερίνη">Κατερίνη
									<option value="Κιλκίς">Κιλκίς
									<option value="Κοζάνη">Κοζάνη
									<option value="Κομοτηνή">Κομοτηνή
									<option value="Κόρινθος">Κόρινθος
									<option value="Λαμία">Λαμία
									<option value="Μεσολόγγι">Μεσολόγγι
									<option value="Ξάνθη">Ξάνθη
									<option value="Πάτρα">Πάτρα
									<option value="Πρέβεζα">Πρέβεζα
									<option value="Σέρρες">Σέρρες
									<option value="Τρίπολη">Τρίπολη
									<option value="Χαλκίδα">Χαλκίδα
								</select>
								<select name="type1">
									<option selected value="1">-Κατεύθυνση-</option>
									<option value="From Volos">Από Βόλο
									<option value="To Volos">Προς Βόλο
									<option value="From Larisa">Από Λάρισα
									<option value="To Larisa">Προς Λάρισα
									<option value="From Trikala">Από Τρίκαλα
									<option value="To Trikala">Προς Τρίκαλα
									<option value="From Karditsa">Από Καρδίτσα
									<option value="To Karditsa">Προς Καρδίτσα
									<option value="From Lamia">Από Λαμία
									<option value="To Lamia">Προς Λαμία
								</select><br>
								<span align="center">
									<input type="submit" style="margin-bottom:-2px;" name="showpass" id="showpass" onclick="detailed1(opt.value, type1.value); return false" value="Δείξε μου συνεπιβάτες" />
									<input type="submit" style="margin-bottom:-2px;" name="showroutes" id="showroutes" onclick="routes1(); return false" value="Τα δρομολόγια μου" />
								</span>
							</form>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div id="passengers">
		<div class="fbplbadge4"></div>
		<table style="background:#DCEEF4" border="1" cellpadding="10">
			<tbody>
				<tr>
					<td align="center">
						<b>1. Διπλό κλικ για δήλωση ταξιδιού ή</b>
					</td>
				</tr>
				<tr>
					<td align="center" colspan="2">
						<b>2. Επίλεξε(ή zoom) αφετηρία/προορισμό <br>και στη συνέχεια επίλεξε <span style="color:blue;">οδηγό</span></b>
						<div id="first_search3">
							<form id="detailed_form2" method="post" action="php/process4.php">
								<select name="opt" id="opt">
									<option selected value="">-Επίλεξε πόλη-</option>
									<option value="Αθήνα">Αθήνα
									<option value="Θεσσαλονίκη">Θεσσαλονίκη
									<option value="Λάρισα">Λάρισα
									<option value="Τρίκαλα">Τρίκαλα
									<option value="Καρδίτσα">Καρδίτσα
									<option value="Αλεξανδρούπολη">Αλεξανδρούπολη
									<option value="Άμφισσα">Άμφισσα
									<option value="Άρτα">Άρτα	
									<option value="Βέροια">Βέροια
									<option value="Γρεβενά">Γρεβενά
									<option value="Δράμα">Δράμα
									<option value="Έδεσσα">Έδεσσα
									<option value="Ιωάννινα">Ιωάννινα
									<option value="Καβάλα">Καβάλα
									<option value="Καλαμάτα">Καλαμάτα
									<option value="Καστοριά">Καστοριά
									<option value="Κατερίνη">Κατερίνη
									<option value="Κιλκίς">Κιλκίς
									<option value="Κοζάνη">Κοζάνη
									<option value="Κομοτηνή">Κομοτηνή
									<option value="Κόρινθος">Κόρινθος
									<option value="Λαμία">Λαμία
									<option value="Μεσολόγγι">Μεσολόγγι
									<option value="Ξάνθη">Ξάνθη
									<option value="Πάτρα">Πάτρα
									<option value="Πρέβεζα">Πρέβεζα
									<option value="Σέρρες">Σέρρες
									<option value="Τρίπολη">Τρίπολη
									<option value="Χαλκίδα">Χαλκίδα
								</select> 
								<select name="type1">
									<option selected value="1">-Κατεύθυνση-</option>
									<option value="From Volos">Από Βόλο
									<option value="To Volos">Προς Βόλο
									<option value="From Larisa">Από Λάρισα
									<option value="To Larisa">Προς Λάρισα
									<option value="From Trikala">Από Τρίκαλα
									<option value="To Trikala">Προς Τρίκαλα
									<option value="From Karditsa">Από Καρδίτσα
									<option value="To Karditsa">Προς Καρδίτσα
									<option value="From Lamia">Από Λαμία
									<option value="To Lamia">Προς Λαμία
								</select><br>
								<span align="center">
									<input type="submit" style="margin-bottom:-2px;" name="showpass" id="showpass" onclick="detailed2(opt.value, type1.value); return false" value="Δείξε μου οδηγούς" />
									<input type="submit" style="margin-bottom:-2px;" name="showroutes" id="showroutes" onclick="routes2(); return false" value="Τα δρομολόγια μου" />
								</span>
							</form>
						</div>
					</td>
				</tr>
			</tbody>
			<input type="hidden" value="<?php echo $username ;?>" id="user" />
			<input type="hidden" value="<?php echo $info[0][cn][0] ;?>" id="fullname" />
			<input type="hidden" value="<?php echo $info[0][mail][0] ;?>" id="email" />
		</table>
	</div>
	<div id="recent_posts" style="display: block;">
		<a href="#" class="close_box" id="close_recent_posts_div4">Κλείσιμο </a>
		<span>
		</span>
	</div>
	<div id="in_posts" style="display: block;">
		<a href="#" class="close_box" id="close_recent_posts_div6">Κλείσιμο </a>
		<span>
			<b><u>Τοπικές μετακινήσεις - Βήμα 1</u></b>
			<form id="detailed_form3" method="post" action="php/process4.php" style="padding-top: 5px;">
				<select name="opt" id="opt">
					<option selected value="1">-Επίλεξε πόλη-</option>
					<option value="Βόλος">Βόλος
					<option value="Λάρισα">Λάρισα
					<option value="Τρίκαλα">Τρίκαλα
					<option value="Καρδίτσα">Καρδίτσα
					<option value="Λαμία">Λαμία
				</select> 
				<select name="type1">
					<option selected value="2">-Ψάχνω για-</option>
					<option value="Driver">Ψάχνω για οδηγούς
					<option value="Passenger">Ψάχνω για συνεπιβάτες
				</select><br>
				<span align="center">
					<input type="submit" style="margin-bottom:-2px;" name="showpass" id="showpass" onclick="transport(opt.value, type1.value); return false" value="Δείξε μου διαδρομές" />
					<input type="submit" style="margin-bottom:-2px;" name="showroutes" id="showroutes" onclick="routes3(); return false" value="Τα δρομολόγια μου" />					
				</span>
			</form><hr>
			<b><u>Τοπικές μετακινήσεις - Βήμα 2</u></b>
			<div style="font-family: Yanone; padding-top:7px; text-align:justify; text-justify:inter-word; font-weight:bold;">
			Ή 1) 1ο δεξί κλικ - Αφετηρία 2) 2ο δεξί κλικ - Προορισμός 3) Δήλωση τοπικής σας μετακίνησης
			</div>
		</span>
	</div>
	<div id="in_transport" style="padding: 5px;">
		<input type="submit" value="" title="Τοπικές μετακινήσεις" id="in_button"
		style="font-family:sans-serif; font-size:12pt;
		font-weight:bold; background-image:url('http://www.adelaidecarpool.com.au/images/carpool50.png'); none; color:white; width:3.4em; height:3.4em; border-radius: 30px;">
		</SUBMIT>
	</div>
	<script>
		function logout() {
			window.location = "/index2.php";
			return false;
		}
		
		$('#target1').click(function() {
			$('#controls1').show();
			$('#controls2').hide();
			$('#details1').hide();
			$('#details2').hide();
			dblclick1();
			for (var i=0; i<tmpmarkers.length; i++) {
				tmpmarkers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<show1markers.length; i++) {
				show1markers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<show2markers.length; i++) {
				show2markers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<show3markers.length; i++) {
				show3markers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<show4markers.length; i++) {
				show4markers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<drivermarkers.length; i++) {
				drivermarkers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<passengermarkers.length; i++) {
				passengermarkers[i].setVisible(false);
				InfoWindow.close();
			}
			jQuery('#drivers').show();
			jQuery('#passengers').hide();
			jQuery('#help').hide();
			jQuery('#admin').hide();
			jQuery('#face').hide();
			jQuery('#recent_posts').hide();
			jQuery('#in_posts').hide();
			directionsDisplay.setMap(null);
			state = 2;
			flag = 1;
			return false;
		});
		
		$('#target2').click(function() {
			$('#controls2').show();
			$('#controls1').hide();
			dblclick2();
			for (var i=0; i<tmpmarkers.length; i++) {
				tmpmarkers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<show1markers.length; i++) {
				show1markers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<show2markers.length; i++) {
				show2markers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<show3markers.length; i++) {
				show3markers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<show4markers.length; i++) {
				show4markers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<drivermarkers.length; i++) {
				drivermarkers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<passengermarkers.length; i++) {
				passengermarkers[i].setVisible(false);
				InfoWindow.close();
			}
			jQuery('#passengers').show();
			jQuery('#drivers').hide();
			jQuery('#help').hide();
			jQuery('#admin').hide();
			jQuery('#face').hide();
			jQuery('#recent_posts').hide();
			jQuery('#in_posts').hide();
			directionsDisplay.setMap(null);
			state = 2;
			flag = 1;
			return false;	
		});
		
		function help() {
			$("#help").fadeIn(10);
			$("#admin").fadeOut(10);
			$('#face').fadeOut(10);
			$("#recent_posts").fadeOut(10);
			$("#in_posts").fadeOut(10);
			state = 2;
			flag = 1;
			for (var i=0; i<show3markers.length; i++) {
				show3markers[i].setMap(null);
			}
			for (var i=0; i<show4markers.length; i++) {
				show4markers[i].setMap(null);
			}
			return false;
		}
		
		function admin() {
			$("#admin").fadeIn(10);
			$("#help").fadeOut(10);
			$('#face').fadeOut(10);
			$("#recent_posts").fadeOut(10);
			$("#in_posts").fadeOut(10);
			state = 2;
			flag = 1;
			for (var i=0; i<show3markers.length; i++) {
				show3markers[i].setMap(null);
			}
			for (var i=0; i<show4markers.length; i++) {
				show4markers[i].setMap(null);
			}
			return false;
		}
		
		function face() {
			$("#face").fadeIn(10);
			$("#help").fadeOut(10);
			$('#admin').fadeOut(10);
			$("#recent_posts").fadeOut(10);
			$("#in_posts").fadeOut(10);
			state = 2;
			flag = 1;
			for (var i=0; i<show3markers.length; i++) {
				show3markers[i].setMap(null);
			}
			for (var i=0; i<show4markers.length; i++) {
				show4markers[i].setMap(null);
			}
			return false;
		}
		
		$("#close_recent_posts_div").click(function(){
			$("#help").fadeOut(10);
			return false;
		});
		$("#close_recent_posts_div3").click(function(){
			$("#admin").fadeOut(10);
			return false;
		});
		$("#close_recent_posts_div4").click(function(){
			$("#recent_posts").fadeOut(10);
			return false;
		});
		$("#close_recent_posts_div5").click(function(){
			$("#face").fadeOut(10);
			return false;
		});
		jQuery('#in_button').click(function() {
			$("#in_posts").fadeIn(10);
			$("#face").fadeOut(10);
			$("#help").fadeOut(10);
			$('#admin').fadeOut(10);
			$("#recent_posts").fadeOut(10);
			if (flag == 0) {
				rightclick();
			}
			return false;
		});
		$("#close_recent_posts_div6").click(function(){
			$("#in_posts").fadeOut(10);
			flag = 1;
			for (var i=0; i<tmpmarkers.length; i++) {
				tmpmarkers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<show1markers.length; i++) {
				show1markers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<show2markers.length; i++) {
				show2markers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<drivermarkers.length; i++) {
				drivermarkers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<passengermarkers.length; i++) {
				passengermarkers[i].setVisible(false);
				InfoWindow.close();
			}
			directionsDisplay.setMap(null);
			state = 2;
			for (var i=0; i<show3markers.length; i++) {
				show3markers[i].setMap(null);
			}
			for (var i=0; i<show4markers.length; i++) {
				show4markers[i].setMap(null);
			}
			return false;
		});
    </script>
	<noscript><b>JavaScript must be enabled in order for you to use Google Maps.</b> 
      However, it seems JavaScript is either disabled or not supported by your browser. 
      To view Google Maps, enable JavaScript by changing your browser options, and then 
      try again.
    </noscript>
    <script type="text/javascript">		
		var lastmarker;
		var tmpmarkers = [];
		var drivermarkers = [];
		var passengermarkers = [];
		var show1markers = [];
		var show2markers = [];
		var show3markers = [];
		var show4markers = [];
		var driver_distance = [];
		var passenger_distance = [];
		var home = new google.maps.LatLng(39.359785,22.930802);
		var home1 = new google.maps.LatLng(39.359785,22.930802); //volos
		var home2 = new google.maps.LatLng(39.614747,22.387719); //larisa
		var home3 = new google.maps.LatLng(39.535027,21.779652); //trikala
		var home4 = new google.maps.LatLng(39.378431,21.912217); //karditsa
		var home5 = new google.maps.LatLng(38.912541,22.428145); //lamia
		var InfoWindow = new google.maps.InfoWindow();
		var tmpInfoWindow = new google.maps.InfoWindow();
		var homeInfoWindow = new google.maps.InfoWindow();
		var inInfoWindow = new google.maps.InfoWindow();
		var Circle = new google.maps.Circle();
		var passengeroffer = [];
		var driveroffer = [];
		var uthname = document.getElementById('user').value;
		var fullname = document.getElementById('fullname').value;
		var useremail = document.getElementById('email').value;
		var rendererOptions = {
			suppressMarkers : true,
			preserveViewport: false
		}
		var directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
		var directionsService = new google.maps.DirectionsService();
		var state = 0;
		var path = [];
		var flag = 0;
		var marker1 = new google.maps.Marker;
		
		HomeControl.prototype.home_ = null;
		HomeControl.prototype.getHome = function() {
			return this.home_;
		}
		HomeControl.prototype.setHome = function(home) {
			this.home_ = home;
		}

		function HomeControl(controlDiv, map, home) 
		{
			var control = this;
			control.home_ = home;
			controlDiv.style.padding = '5px';
			var goHomeUI = document.createElement('div');
			goHomeUI.style.backgroundColor = 'white';
			goHomeUI.style.borderStyle = 'solid';
			goHomeUI.style.borderWidth = '2px';
			goHomeUI.style.cursor = 'pointer';
			goHomeUI.style.textAlign = 'center';
			goHomeUI.title = 'Click to set the map to Home';
			controlDiv.appendChild(goHomeUI);
			var goHomeText = document.createElement('div');
			goHomeText.style.fontFamily = 'Arial,sans-serif';
			goHomeText.style.fontSize = '12px';
			goHomeText.style.paddingLeft = '4px';
			goHomeText.style.paddingRight = '4px';
			goHomeText.innerHTML = '<b>Αρχικός Χάρτης</b>';
			goHomeUI.appendChild(goHomeText);
			google.maps.event.addDomListener(goHomeUI, 'click', function() {
				var currentHome = control.getHome();
				map.setCenter(currentHome);
				map.setZoom(8);
			});
		}
		
		var iwform =   ' <form id="in_details" method="post" action="php/process9.php">'
					  + '   <fieldset>'
					  + '   <legend>Στοιχεία μετακίνησης</legend>'
					  + '   <label style="padding-left:3px;">Ημερομηνία/Ώρα αναχώρησης και αριθμός ατόμων:</label><br>'
				      + '	<input type="date" name="ddate" maxlength="21" size="21" id="driver_date" value="ΕΕΕΕ-MM-ΗΗ"><br>'
					  + '	<select name="hour">'
				      + '	<option selected value="sel3"> - Ώρα (+|- 30 λεπτά) - </option>'
					  + ' 	<option value="00:00">00:00'
				      + ' 	<option value="01:00">01:00'
				      + ' 	<option value="02:00">02:00'
				      + ' 	<option value="03:00">03:00'
					  + ' 	<option value="04:00">04:00'
				      + ' 	<option value="05:00">05:00'
				      + ' 	<option value="06:00">06:00'
					  + ' 	<option value="07:00">07:00'
				      + ' 	<option value="08:00">08:00'
				      + ' 	<option value="09:00">09:00'
					  + ' 	<option value="10:00">10:00'
				      + ' 	<option value="11:00">11:00'
					  + ' 	<option value="12:00">12:00'
					  + ' 	<option value="13:00">13:00'
				      + ' 	<option value="14:00">14:00'
				      + ' 	<option value="15:00">15:00'
					  + ' 	<option value="16:00">16:00'
				      + ' 	<option value="17:00">17:00'
				      + ' 	<option value="18:00">18:00'
					  + ' 	<option value="19:00">19:00'
				      + ' 	<option value="20:00">20:00'
				      + ' 	<option value="21:00">21:00'
					  + ' 	<option value="22:00">22:00'
				      + ' 	<option value="23:00">23:00'
					  + '	</select>'
					  + '	<select name="people">'
				      + '	<option selected value="choice"> - Άτομα - </option>'
				      + ' 	<option value="1">1'
				      + ' 	<option value="2">2'
				      + ' 	<option value="3">3'
					  + '	</select>'
					  + ' 	<select name="direction">'
					  + '	<option selected value="choice2"> - Είμαι - </option>'
				      + ' 	<option value="Driver">Οδηγός'
				      + ' 	<option value="Passenger">Συνεπιβάτης'
					  + '	</select><br>'
					  + '   <label><input type="checkbox" id="amea_box" name="amea_box">Καθημερινό δρομολόγιο</label>'
					  + '   <label for="details" style="padding-left:3px;">Λεπτομέρειες (καπνιστής/μη καπνιστής, τηλέφωνο):</label>'
				      + '   <textarea name="details" rows="3" cols="40"></textarea><br><br>'
					  + '	<select name="radius">'
				      + '	<option selected value="choice3"> - Αποδεκτή εμβέλεια επιβίβασης / αποβίβασης - </option>'
				      + ' 	<option value="0.1">100 μ'
				      + ' 	<option value="0.2">200 μ'
					  + ' 	<option value="0.3">300 μ'
				      + ' 	<option value="0.4">400 μ'
					  + ' 	<option value="0.5">500 μ'
					  + '	</select>'
					  + '   <label for="communicate" style="padding-left:3px;">Facebook username (*προαιρετικό):</label><br>'
					  + '   <img type="image" src="images/facebook_logo.jpg" name="image" width="26px" height="22px">:'
					  + '   www.facebook.com/<input type="text" id="facebook" name="facebook"/><br><br>'
					  + '   <button type="button" name="submit" onclick="process9(facebook.value,ddate.value,hour.value,amea_box.value,people.value,form.details.value,direction.value,radius.value); return false">Καταχώρηση</button>'
					  + ' 	</fieldset>'
				      + ' </form>'
		
		var iwform1 =   ' <form id="driver_details" method="post" action="php/process1.php">'
					  + '   <fieldset>'
					  + '   <legend>Στοιχεία ταξιδιού και οδηγού</legend>'
					  + '   <label style="padding-left:3px;">Ημερομηνία/Ώρα αναχώρησης και αριθμός ατόμων:</label><br>'
				      + '	<input type="date" name="ddate" maxlength="21" size="21" id="driver_date" value="ΕΕΕΕ-MM-ΗΗ"><br>'
					  + '	<select name="hour">'
				      + '	<option selected value="sel3"> - Ώρα (+|- 30 λεπτά) - </option>'
					  + ' 	<option value="00:00">00:00'
				      + ' 	<option value="01:00">01:00'
				      + ' 	<option value="02:00">02:00'
				      + ' 	<option value="03:00">03:00'
					  + ' 	<option value="04:00">04:00'
				      + ' 	<option value="05:00">05:00'
				      + ' 	<option value="06:00">06:00'
					  + ' 	<option value="07:00">07:00'
				      + ' 	<option value="08:00">08:00'
				      + ' 	<option value="09:00">09:00'
					  + ' 	<option value="10:00">10:00'
				      + ' 	<option value="11:00">11:00'
					  + ' 	<option value="12:00">12:00'
					  + ' 	<option value="13:00">13:00'
				      + ' 	<option value="14:00">14:00'
				      + ' 	<option value="15:00">15:00'
					  + ' 	<option value="16:00">16:00'
				      + ' 	<option value="17:00">17:00'
				      + ' 	<option value="18:00">18:00'
					  + ' 	<option value="19:00">19:00'
				      + ' 	<option value="20:00">20:00'
				      + ' 	<option value="21:00">21:00'
					  + ' 	<option value="22:00">22:00'
				      + ' 	<option value="23:00">23:00'
					  + '	</select>'
					  + '	<select name="people">'
				      + '	<option selected value="choice"> - Άτομα - </option>'
				      + ' 	<option value="1">1'
				      + ' 	<option value="2">2'
				      + ' 	<option value="3">3'
					  + '	</select>'
					  + ' 	<select name="direction">'
					  + '	<option selected value="choice2"> - Κατεύθυνση - </option>'
				      + ' 	<option value="From Volos">Από Βόλο'
				      + ' 	<option value="To Volos">Προς Βόλο'
					  + '	<option value="From Larisa">Από Λάρισα'
					  + '	<option value="To Larisa">Προς Λάρισα'
					  + '	<option value="From Trikala">Από Τρίκαλα'
					  + '	<option value="To Trikala">Προς Τρίκαλα'
					  + '	<option value="From Karditsa">Από Καρδίτσα'
					  + '	<option value="To Karditsa">Προς Καρδίτσα'
					  + '	<option value="From Lamia">Από Λαμία'
					  + '	<option value="To Lamia">Προς Λαμία'
					  + '	</select><br>'
					  + '   <label for="details" style="padding-left:3px;">Λεπτομέρειες (καπνιστής/μη καπνιστής, τηλέφωνο):</label>'
				      + '   <textarea name="details" rows="3" cols="40"></textarea><br><br>'
					  + '	<select name="radius">'
				      + '	<option selected value="choice3"> - Αποδεκτή εμβέλεια επιβίβασης / αποβίβασης - </option>'
				      + ' 	<option value="1">1 χλμ'
				      + ' 	<option value="2">2 χλμ'
				      + ' 	<option value="3">3 χλμ'
					  + ' 	<option value="4">4 χλμ'
					  + ' 	<option value="5">5 χλμ'
					  + '	</select>'
					  + '   <label for="communicate" style="padding-left:3px;">Facebook username (*προαιρετικό):</label><br>'
					  + '   <img type="image" src="images/facebook_logo.jpg" name="image" width="26px" height="22px">:'
					  + '   www.facebook.com/<input type="text" id="facebook" name="facebook"/><br><br>'
					  + '   <button type="button" name="submit" onclick="process1(facebook.value,ddate.value,hour.value,people.value,form.details.value,direction.value,radius.value); return false">Καταχώρηση</button>'
					  + ' 	</fieldset>'
				      + ' </form>'
					  
		var iwform2 =   ' <form id="passenger_details" method="post" action="php/process2.php">'
					  + '   <fieldset>'
					  + '   <legend>Στοιχεία ταξιδιού και συνεπιβάτη</legend>'
					  + '   <label style="padding-left:3px;">Ημερομηνία/Ώρα αναχώρησης και αριθμός ατόμων:</label><br>'
				      + '	<input type="date" name="ddate" maxlength="21" size="21" id="passenger_date" value="ΕΕΕΕ-MM-ΗΗ"><br>'
					  + '	<select name="hour">'
				      + '	<option selected value="sel3"> - Ώρα (+|- 30 λεπτά) - </option>'
					  + ' 	<option value="00:00">00:00'
				      + ' 	<option value="01:00">01:00'
				      + ' 	<option value="02:00">02:00'
				      + ' 	<option value="03:00">03:00'
					  + ' 	<option value="04:00">04:00'
				      + ' 	<option value="05:00">05:00'
				      + ' 	<option value="06:00">06:00'
					  + ' 	<option value="07:00">07:00'
				      + ' 	<option value="08:00">08:00'
				      + ' 	<option value="09:00">09:00'
					  + ' 	<option value="10:00">10:00'
				      + ' 	<option value="11:00">11:00'
					  + ' 	<option value="12:00">12:00'
					  + ' 	<option value="13:00">13:00'
				      + ' 	<option value="14:00">14:00'
				      + ' 	<option value="15:00">15:00'
					  + ' 	<option value="16:00">16:00'
				      + ' 	<option value="17:00">17:00'
				      + ' 	<option value="18:00">18:00'
					  + ' 	<option value="19:00">19:00'
				      + ' 	<option value="20:00">20:00'
				      + ' 	<option value="21:00">21:00'
					  + ' 	<option value="22:00">22:00'
				      + ' 	<option value="23:00">23:00'
					  + '	</select>'
					  + '	<select name="people">'
				      + '	<option selected value="choice"> - Άτομα - </option>'
				      + ' 	<option value="1">1'
				      + ' 	<option value="2">2'
				      + ' 	<option value="3">3'
					  + '	</select>'
					  + ' 	<select name="direction">'
					  + '	<option selected value="choice2"> - Κατεύθυνση - </option>'
				      + ' 	<option value="From Volos">Από Βόλο'
				      + ' 	<option value="To Volos">Προς Βόλο'
					  + '	<option value="From Larisa">Από Λάρισα'
					  + '	<option value="To Larisa">Προς Λάρισα'
					  + '	<option value="From Trikala">Από Τρίκαλα'
					  + '	<option value="To Trikala">Προς Τρίκαλα'
					  + '	<option value="From Karditsa">Από Καρδίτσα'
					  + '	<option value="To Karditsa">Προς Καρδίτσα'
					  + '	<option value="From Lamia">Από Λαμία'
					  + '	<option value="To Lamia">Προς Λαμία'
					  + '	</select><br>'
					  + '   <label for="details" style="padding-left:3px;">Σχόλια (καπνιστής / μη καπνιστής, τηλέφωνο):</label>'
				      + '   <textarea name="details" rows="3" cols="40"></textarea><br><br>'
					  + '	<select name="radius">'
				      + '	<option selected value="choice3"> - Αποδεκτή εμβέλεια επιβίβασης / αποβίβασης - </option>'
				      + ' 	<option value="1">1 χλμ'
				      + ' 	<option value="2">2 χλμ'
				      + ' 	<option value="3">3 χλμ'
					  + ' 	<option value="4">4 χλμ'
					  + ' 	<option value="5">5 χλμ'
					  + '	</select>'
					  + '   <label for="communicate" style="padding-left:3px;">Facebook username (*προαιρετικό):</label><br>'
					  + '   <img type="image" src="images/facebook_logo.jpg" name="image" width="26px" height="22px">:'
					  + '   www.facebook.com/<input type="text" id="facebook" name="facebook"/><br><br>'
					  + '   <button type="button" name="submit" onclick="process2(facebook.value,ddate.value,hour.value,people.value,form.details.value,direction.value,radius.value); return false">Καταχώρηση</button>'
					  + ' 	</fieldset>'
				      + ' </form>'
					  
		function show2() {
			for (var i=0; i<tmpmarkers.length; i++) {
				tmpmarkers[i].setVisible(false);
				InfoWindow.close();
				tmpInfoWindow.close();
			}
			for (var i=0; i<show1markers.length; i++) {
				show1markers[i].setVisible(false);
				InfoWindow.close();
				tmpInfoWindow.close();
			}
			for (var i=0; i<show2markers.length; i++) {
				show2markers[i].setVisible(false);
				InfoWindow.close();
				tmpInfoWindow.close();
			}
			for (var i=0; i<drivermarkers.length; i++) {
				drivermarkers[i].setVisible(false);
				InfoWindow.close();
				tmpInfoWindow.close();
			}
			for (var i=0; i<passengermarkers.length; i++) {
				passengermarkers[i].setVisible(false);
				InfoWindow.close();
				tmpInfoWindow.close();
			}
			map.setCenter(new google.maps.LatLng(39.359785,22.930802), 8);
			var input = /** @type {HTMLInputElement} */(
			document.getElementById('main_menu'));
			map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
			
			var input = /** @type {HTMLInputElement} */(
			document.getElementById('submenu'));
			map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(input);
			
			var input = /** @type {HTMLInputElement} */(
			document.getElementById('logo'));
			map.controls[google.maps.ControlPosition.TOP_RIGHT].push(input);
			
			var input = /** @type {HTMLInputElement} */(
			document.getElementById('drivers'));
			map.controls[google.maps.ControlPosition.BOTTOM_LEFT].push(input);
			
			var input = /** @type {HTMLInputElement} */(
			document.getElementById('likes'));
			map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
				
			var input = /** @type {HTMLInputElement} */(
			document.getElementById('passengers'));
			map.controls[google.maps.ControlPosition.BOTTOM_RIGHT].push(input);
			
			var input = /** @type {HTMLInputElement} */(
			document.getElementById('in_transport'));
			map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

			var homeControlDiv = document.createElement('div');
			var homeControl = new HomeControl(homeControlDiv, map, home);
			homeControlDiv.index = 1;
			map.controls[google.maps.ControlPosition.TOP_RIGHT].push(homeControlDiv);
			var home_marker1 = new google.maps.Marker({
				position: home1,
				map: map,
				animation: google.maps.Animation.DROP
			});
			home_marker1.setIcon("images/University_map_marker.png");
			var home_marker2 = new google.maps.Marker({
				position: home2,
				map: map,
				animation: google.maps.Animation.DROP
			});
			home_marker2.setIcon("http://www.fpm.iastate.edu/maps/icons/other_marker.png");
			var home_marker3 = new google.maps.Marker({
				position: home3,
				map: map,
				animation: google.maps.Animation.DROP
			});
			home_marker3.setIcon("http://www.fpm.iastate.edu/maps/icons/other_marker.png");
			var home_marker4 = new google.maps.Marker({
				position: home4,
				map: map,
				animation: google.maps.Animation.DROP
			});
			home_marker4.setIcon("http://www.fpm.iastate.edu/maps/icons/other_marker.png");
			var home_marker5 = new google.maps.Marker({
				position: home5,
				map: map,
				animation: google.maps.Animation.DROP
			});
			home_marker5.setIcon("http://www.fpm.iastate.edu/maps/icons/other_marker.png");
			jQuery('#help').hide();		
			jQuery('#admin').hide();
			jQuery('#face').hide();
			jQuery('#recent_posts').hide();
			jQuery('#in_posts').hide();
			jQuery('#in_transport').hide();
			
			if ((uthname == "ormikopo") || (uthname == "mav") || (uthname == "leonska") || (uthname == "gkala")) {
				jQuery('#in_transport').show();
			}
		}
		
		function rightclick() {
			google.maps.event.addListener(map,'rightclick',function(event){
				if (event.latLng) {
					if (state == 0) { 
						doStart(event.latLng);
						state = 1;
					}
					else if (state == 1) {
						doEnd(event.latLng);
						state = 2;
					}
				}
			});
		}
		
		function doStart(point) {
			path[0] = point;
			createMarker(point,"images/dd-start.png");
		}

		function doEnd(point) {
			path[1] = point;
			createMarker(point,"images/dd-end.png");
		}
		
		function createMarker(point,icon) {
			var marker = new google.maps.Marker({
				position: point,
				map: map,
				icon: icon,
				draggable:false
			});
			for (var j=0; j<tmpmarkers.length; j++) {
					tmpInfoWindow.close();
			}
			marker.setMap(map);
			lastmarker = marker;
			if (icon == "images/dd-end.png") {
				inInfoWindow.setContent(iwform);
				inInfoWindow.open(map,marker);
				var request = {
					origin:path[0],
					destination:path[1],
					travelMode: google.maps.TravelMode.DRIVING
				};
				directionsService.route(request, function(response, status) {
					if (status == google.maps.DirectionsStatus.OK) {
						directionsDisplay.setDirections(response);
					}
				});
				directionsDisplay.setMap(map);
				google.maps.event.addListener(marker,"click", function() {
					inInfoWindow.open(map,marker);
					directionsDisplay.setMap(map);
				});
				google.maps.event.addListener(marker,"mouseover", function() {
					inInfoWindow.open(map,marker);
				});
			}
			google.maps.event.addListener(map,"click", function() {
				for (var i=0; i<tmpmarkers.length; i++) {
					inInfoWindow.close();
				}
			});
			tmpmarkers.push(marker);
		}
		
		function process9(facebook,ddate,hour,amea_box,people,details,direction,radius) {
			var lat1 = path[0].lat();
			var lng1 = path[0].lng();
			var lat2 = path[1].lat();
			var lng2 = path[1].lng();
			var errors = '';
            var id = null;
			var status = "Active!";
			
			var ddate = $("#in_details [name='ddate']").val();
		    if ((ddate == "ΕΕΕΕ-MM-ΗΗ") || (ddate == "")) {
				errors += '- Παρακαλούμε επιλέξτε ημερομηνία αναχώρησης\n';
		    }
			var hour = $("#in_details [name='hour']").val();
		    if (hour == "sel3") {
				errors += '- Παρακαλούμε επιλέξτε ώρα αναχώρησης\n';
		    }
			var people = $("#in_details [name='people']").val();
		    if (people == "choice") {
				errors += '- Παρακαλούμε επιλέξτε αριθμό ατόμων\n';
		    }
			var direction = $("#in_details [name='direction']").val();
		    if (direction == "choice2") {
				errors += '- Παρακαλούμε επιλέξτε ιδιότητα\n';
		    }
			var radius = $("#in_details [name='radius']").val();
		    if (radius == "choice3") {
				errors += '- Παρακαλούμε επιλέξτε εμβέλεια\n';
		    }
			var facebook = $("#in_details [name='facebook']").val();
			var details = $("#in_details [name='details']").val();
		    if (!details) {
				errors += '- Παρακαλούμε συμπληρώστε λεπτομέρειες\n';
		    }
			if ($('#amea_box').is(':checked')) {
				var amea = "true";
			}
			
			else { 
				var amea = "false";
			}
			if (errors) {
				errors = 'Διαπιστώθηκαν τα παρακάτω σφάλματα: \n' + errors;
				alert(errors);
				return false;
			}
			else {
				var url = "php/process9.php?id=" +id+ "&uthname=" +uthname+ "&fullname=" +fullname+ "&useremail=" +useremail+ "&facebook=" +facebook+ "&ddate=" +ddate+ "&hour=" +hour+ "&amea=" +amea+ "&people=" +people+ "&details=" +details+ "&lat1=" +lat1+ "&lng1=" +lng1+ "&lat2=" +lat2+ "&lng2=" +lng2+ "&status=" +status+ "&direction=" +direction+ "&radius=" +radius;
				$.ajax({
					url: url,
					type: "POST",
					dataType: 'json',
					success: function(){
						showResult10("ok");
					}
				});
				InfoWindow.close();
				tmpInfoWindow.close();
				map.setZoom(14);
				load12(map,direction);
				state = 0;
				path = [];
				directionsDisplay.setMap(null);
				inInfoWindow.close();
			}
		}
		
		function process11(id,ddate,hour,amea_box,people,details,radius,direction) {
			var errors = '';
			
			var ddate = $("#in_details2 [name='ddate']").val();
		    if ((ddate == "ΕΕΕΕ-MM-ΗΗ") || (ddate == "")) {
				errors += '- Παρακαλούμε επιλέξτε ημερομηνία αναχώρησης\n';
		    }
			var hour = $("#in_details2 [name='hour']").val();
		    if (hour == "sel3") {
				errors += '- Παρακαλούμε επιλέξτε ώρα αναχώρησης\n';
		    }
			var people = $("#in_details2 [name='people']").val();
		    if (people == "choice") {
				errors += '- Παρακαλούμε επιλέξτε αριθμό ατόμων\n';
		    }
			var direction = $("#in_details2 [name='direction']").val();
		    if (people == "choice2") {
				errors += '- Παρακαλούμε επιλέξτε ιδιότητα\n';
		    }
			var radius = $("#in_details2 [name='radius']").val();
		    if (radius == "choice3") {
				errors += '- Παρακαλούμε επιλέξτε εμβέλεια\n';
		    }
			var details = $("#in_details2 [name='details']").val();
		    if (!details) {
				errors += '- Παρακαλούμε συμπληρώστε λεπτομέρειες\n';
		    }
			if ($('#amea_box').is(':checked')) {
				var amea = "true";
			}
			
			else { 
				var amea = "false";
			}
			if (errors) {
				errors = 'Διαπιστώθηκαν τα παρακάτω σφάλματα: \n' + errors;
				alert(errors);
				return false;
			}
			else {
				var url = "php/process11.php?id=" +id+ "&ddate=" +ddate+ "&hour=" +hour+ "&amea=" +amea+ "&people=" +people+ "&details=" +details+ "&radius=" +radius+ "&direction=" +direction;
				$.ajax({
					url: url,
					type: "POST",
					dataType: 'json',
					success: function(){
						showResult11("ok");
					}
				});
				InfoWindow.close();
				tmpInfoWindow.close();
				map.setZoom(14);
				load12(map,direction);
				state = 0;
				path = [];
				directionsDisplay.setMap(null);
				inInfoWindow.close();
			}
		}
		
		function dblclick1() {
			google.maps.event.addListener(map,'dblclick',function(event){
				for (var i=0; i<tmpmarkers.length; i++) {
					tmpmarkers[i].setVisible(false);
				}
				driver_distance = [];
				createInputMarker1(event.latLng);
			});
		}
		
		function createInputMarker1(point) {
			var marker = new google.maps.Marker({
				position: point,
				map: map,
				draggable:false
			});
			google.maps.event.addListener(marker, "mouseover", function() {
				lastmarker = marker;
				tmpInfoWindow.open(map,lastmarker);
			});
			google.maps.event.addListener(marker,"click", function() {
				lastmarker = marker;
				tmpInfoWindow.open(map,lastmarker);
			});
			for (var i=0; i<tmpmarkers.length; i++) {
					tmpInfoWindow.close();
			}
			marker.setMap(map);
			marker.setIcon("images/blue_Marker_new2.png");
			lastmarker=marker;				
			tmpInfoWindow.setContent(iwform1);
			tmpInfoWindow.open(map,marker);
			tmpmarkers.push(marker);
			google.maps.event.addListener(map,"click", function() {
				for (var i=0; i<tmpmarkers.length; i++) {
					tmpInfoWindow.close();
				}
			});
			var p1 = new google.maps.LatLng(39.359785,22.930802);
			var p2 = lastmarker.getPosition();
			var service = new google.maps.DistanceMatrixService();
			service.getDistanceMatrix({
				origins: [p1],
				destinations: [p2],
				travelMode: google.maps.TravelMode.DRIVING,
				unitSystem: google.maps.UnitSystem.METRIC,
				avoidHighways: false,
				avoidTolls: false
			}, callback);
			
			function callback(response, status) {
				if (status == google.maps.DistanceMatrixStatus.OK) {
					var origins = response.originAddresses;
					var destinations = response.destinationAddresses;
					for (var i = 0; i < origins.length; i++) {
						var results = response.rows[i].elements;
						for (var j = 0; j < results.length; j++) {
							var element = results[j];
							var distance = element.distance.text;
							var duration = element.duration.text;
							var from = origins[i];
							var to = destinations[j];
							generateArray(distance, duration);
						}
					}
				}
			}
			
			function generateArray(dis, dur){
				driver_distance.push(dis);
				driver_distance.push(dur);
            }
			return marker;
		}
		
		function dblclick2() {
			google.maps.event.addListener(map,'dblclick',function(event){
				for (var i=0; i<tmpmarkers.length; i++) {
					tmpmarkers[i].setVisible(false);
				}
				passenger_distance = [];
				createInputMarker2(event.latLng);
			});
		}
		
		function createInputMarker2(point) {
			var marker = new google.maps.Marker({
				position: point,
				map: map,
				draggable:false
			});
			google.maps.event.addListener(marker, "mouseover", function() {
				lastmarker = marker;
				tmpInfoWindow.open(map,lastmarker);
			});
			google.maps.event.addListener(marker,"click", function() {
				lastmarker = marker;
				tmpInfoWindow.open(map,lastmarker);
			});
			for (var i=0; i<tmpmarkers.length; i++) {
					tmpInfoWindow.close();
			}
			marker.setMap(map);
			marker.setIcon("images/marker_red2.png");
			lastmarker=marker;				
			tmpInfoWindow.setContent(iwform2);
			tmpInfoWindow.open(map,marker);
			tmpmarkers.push(marker);
			google.maps.event.addListener(map,"click", function() {
				for (var i=0; i<tmpmarkers.length; i++) {
					tmpInfoWindow.close();
				}
			});
			var p1 = new google.maps.LatLng(39.359785,22.930802);
			var p2 = lastmarker.getPosition();
			var service = new google.maps.DistanceMatrixService();
			service.getDistanceMatrix({
				origins: [p1],
				destinations: [p2],
				travelMode: google.maps.TravelMode.DRIVING,
				unitSystem: google.maps.UnitSystem.METRIC,
				avoidHighways: false,
				avoidTolls: false
			}, callback);
			
			function callback(response, status) {
				if (status == google.maps.DistanceMatrixStatus.OK) {
					var origins = response.originAddresses;
					var destinations = response.destinationAddresses;
					for (var i = 0; i < origins.length; i++) {
						var results = response.rows[i].elements;
						for (var j = 0; j < results.length; j++) {
							var element = results[j];
							var distance = element.distance.text;
							var duration = element.duration.text;
							var from = origins[i];
							var to = destinations[j];
							generateArray(distance, duration);
						}
					}
				}
			}
			
			function generateArray(dis, dur){
				passenger_distance.push(dis);
				passenger_distance.push(dur);
            }
			return marker;
		}
		
		function process1 (facebook,ddate,hour,people,details,direction,radius) {
			var dis = driver_distance[0];
			var dur = driver_distance[1];		
			var lat = lastmarker.getPosition().lat();
			var lng = lastmarker.getPosition().lng();
			var errors = '';
            var driver_id = null;
			var status = "Active!";
			
			var ddate = $("#driver_details [name='ddate']").val();
		    if ((ddate == "ΕΕΕΕ-MM-ΗΗ") || (ddate == "")) {
				errors += '- Παρακαλούμε επιλέξτε ημερομηνία αναχώρησης\n';
		    }
			var hour = $("#driver_details [name='hour']").val();
		    if (hour == "sel3") {
				errors += '- Παρακαλούμε επιλέξτε ώρα αναχώρησης\n';
		    }
			var people = $("#driver_details [name='people']").val();
		    if (people == "choice") {
				errors += '- Παρακαλούμε επιλέξτε τον αριθμό των ατόμων που μπορείτε να πάρετε μαζί σας\n';
		    }
			var direction = $("#driver_details [name='direction']").val();
		    if (direction == "choice2") {
				errors += '- Παρακαλούμε επιλέξτε κατεύθυνση\n';
		    }
			var radius = $("#driver_details [name='radius']").val();
		    if (radius == "choice3") {
				errors += '- Παρακαλούμε επιλέξτε εμβέλεια\n';
		    }
			var facebook = $("#driver_details [name='facebook']").val();
			var details = $("#driver_details [name='details']").val();
		    if (!details) {
				errors += '- Παρακαλούμε συμπληρώστε λεπτομέρειες\n';
		    }	
			if (errors) {
				errors = 'Διαπιστώθηκαν τα παρακάτω σφάλματα: \n' + errors;
				alert(errors);
				return false;
			}
			else {
				var url = "php/process1.php?driver_id=" +driver_id+ "&uthname=" +uthname+ "&fullname=" +fullname+ "&useremail=" +useremail+ "&facebook=" +facebook+ "&ddate=" +ddate+ "&hour=" +hour+ "&people=" +people+ "&details=" +details+ "&lat=" +lat+ "&lng=" +lng+ "&status=" +status+ "&direction=" +direction+ "&dis=" +dis+ "&dur=" +dur+ "&radius=" +radius;
				$.ajax({
					url: url,
					type: "POST",
					dataType: 'json',
					success: function(){
						showResult1("ok");
					}
				});
				driver_distance = [];
				InfoWindow.close();
				tmpInfoWindow.close();
				var marker = createMarker1(lastmarker.getPosition(),fullname,useremail,facebook,ddate,hour,people,details,status,direction);
				google.maps.event.trigger(marker,"mouseover");
			}
		}
		
		function process2(facebook,ddate,hour,people,details,direction,radius) {
			var dis = passenger_distance[0];
			var dur = passenger_distance[1];
			var lat = lastmarker.getPosition().lat();
			var lng = lastmarker.getPosition().lng();
			var errors = '';
            var passenger_id = null;
			var status = "Active!";
			var ddate = $("#passenger_details [name='ddate']").val();
		    if ((ddate == "ΕΕΕΕ-MM-ΗΗ") || (ddate == "")) {
				errors += '- Παρακαλούμε επιλέξτε ημερομηνία αναχώρησης\n';
		    }	
			var hour = $("#passenger_details [name='hour']").val();
		    if (hour == "sel3") {
				errors += '- Παρακαλούμε επιλέξτε ώρα αναχώρησης\n';
		    }
			var people = $("#passenger_details [name='people']").val();
		    if (people == "choice") {
				errors += '- Παρακαλούμε επιλέξτε τον αριθμό των ατόμων που μπορείτε να πάρετε μαζί σας\n';
		    }
			var direction = $("#passenger_details [name='direction']").val();
		    if (direction == "choice2") {
				errors += '- Παρακαλούμε επιλέξτε κατεύθυνση\n';
		    }
			var radius = $("#passenger_details [name='radius']").val();
		    if (radius == "choice3") {
				errors += '- Παρακαλούμε επιλέξτε εμβέλεια\n';
		    }
			var details = $("#passenger_details [name='details']").val();
		    if (!details) {
				errors += '- Παρακαλούμε συμπληρώστε λεπτομέρειες\n';
		    }
			var facebook = $("#passenger_details [name='facebook']").val();
			if (errors) {
				errors = 'Διαπιστώθηκαν τα παρακάτω σφάλματα: \n' + errors;
				alert(errors);
				return false;
			}
			else {
				var url = "php/process2.php?passenger_id=" +passenger_id+ "&uthname=" +uthname+ "&fullname=" +fullname+ "&useremail=" +useremail+ "&facebook=" +facebook+ "&ddate=" +ddate+ "&hour=" +hour+ "&people=" +people+ "&details=" +details+ "&lat=" +lat+ "&lng=" +lng+ "&status=" +status+ "&direction=" +direction+ "&dis=" +dis+ "&dur=" +dur+ "&radius=" +radius;
				$.ajax({
					url: url,
					type: "POST",
					dataType: 'json',
					success: function(){
						showResult2("ok");
					}
				});
				passenger_distance = [];
				InfoWindow.close();
				tmpInfoWindow.close();
				var marker = createMarker2(lastmarker.getPosition(),fullname,useremail,facebook,ddate,hour,people,details,status,direction);
				google.maps.event.trigger(marker,"mouseover");	
			}
		}
		
		function booking1(driver_id,lat,lng) {
			downloadUrl("php/quote1.php?driver_id=" +driver_id, function(data) {
				var data = new XMLHttpRequest(); 
				data.open("GET", "php/quote1.php?driver_id=" +driver_id, false); 
				data.overrideMimeType("text/xml");
				data.send(null);
				var xml = data.responseXML;
				var quotes = xml.documentElement.getElementsByTagName("quote");
				for (var i = 0; i < quotes.length; i++) {
					var q = quotes[i].getAttribute("email");
				}
				var iwform3 =   ' <form id="pass_details" method="post" action="php/process3.php">'
				  + '   <fieldset>'
				  + '   <legend>Στοιχεία ενδιαφερόμενου</legend>'
				  + '   <label for="this_email" style="padding-left:3px;">Email οδηγού:</label>'
				  + '   <input disabled type="text" size="30" name="this_email" value="'+q+'"/><br>'
				  + '   <label for="communicate" style="padding-left:3px;">Facebook username (*προαιρετικό):</label><br>'
				  + '   <img type="image" src="images/facebook_logo.jpg" name="image" width="26px" height="22px">:'
				  + '   www.facebook.com/<input type="text" id="p_facebook" name="p_facebook"/><br>'
				  + '   <label for="p_details" style="padding-left:3px;">Σχόλια:</label>'
				  + '   <textarea name="p_details" rows="3" cols="40"></textarea><br><br>'
				  + '   <button type="button" name="submit" onclick="process3(p_facebook.value,form.p_details.value,'+driver_id+'); return false">Καταχώρηση</button>'
				  + ' 	</fieldset>'
				  + ' </form>'
				InfoWindow.setContent(iwform3);
			});
			function downloadUrl(url, callback) {
				var request = window.ActiveXObject ?
				new ActiveXObject('Microsoft.XMLHTTP') :
				new XMLHttpRequest;

				request.onreadystatechange = function() {
					if (request.readyState == 4) {
						request.onreadystatechange = doNothing;
						callback(request, request.status);
					}
				};
				request.open('GET', url, true);
				request.send(null);
			}
			function doNothing() {}
		}
		
		function process3(p_facebook,p_details,driver_id,q) {
			var errors = '';		
            var p_username = fullname;
			var p_email = useremail;
			var p_facebook = $("#pass_details [name='p_facebook']").val();
			var q = jQuery("#pass_details [name='this_email']").val();
			var p_details = $("#pass_details [name='p_details']").val();
			if (!p_details) {
				errors += '- Παρακαλούμε εισάγετε τα σχόλια σας\n';
		    }
			if (errors) {
				errors = 'The following error occurred: \n' + errors;
				alert(errors);
				return false;
			}
			else {
				var url = "php/process3.php?p_username=" +p_username+ "&p_email=" +p_email+ "&p_facebook=" +p_facebook+ "&p_details=" +p_details+ "&driver_id=" +driver_id+ "&q=" +q;
				$.ajax({
					url: url,
					type: "POST",
					success: function(){
					}
				});
				var url = "php/booking1.php?driver_id=" +driver_id;
				$.ajax({
					url: url,
					type: "GET",
					success: function(){
						showResult5("ok");
					}
				});
			}
		}
		
		function booking2(passenger_id) {
			downloadUrl("php/quote2.php?passenger_id=" +passenger_id, function(data) {
				var data = new XMLHttpRequest(); 
				data.open("GET", "php/quote2.php?passenger_id=" +passenger_id, false); 
				data.overrideMimeType("text/xml");
				data.send(null);
				var xml = data.responseXML;
				var quotes = xml.documentElement.getElementsByTagName("quote");
				for (var i = 0; i < quotes.length; i++) {
					var q = quotes[i].getAttribute("email");
				}
				var iwform4 =   ' <form id="dr_details" method="post" action="php/process4.php">'
				  + '   <fieldset>'
				  + '   <legend>Στοιχεία ενδιαφερόμενου</legend>'
				  + '   <label for="this_email" style="padding-left:3px;">Email συνεπιβάτη:</label>'
				  + '   <input disabled type="text" size="30" name="this_email" value="'+q+'"/><br>'
				  + '   <label for="communicate" style="padding-left:3px;">Facebook username (*προαιρετικό):</label><br>'
				  + '   <img type="image" src="images/facebook_logo.jpg" name="image" width="26px" height="22px">:'
				  + '   www.facebook.com/<input type="text" id="d_facebook" name="d_facebook"/><br>'
				  + '   <label for="d_details" style="padding-left:3px;">Σχόλια:</label>'
				  + '   <textarea name="d_details" rows="3" cols="40"></textarea><br><br>'
				  + '   <button type="button" name="submit" onclick="process4(d_facebook.value,form.d_details.value,'+passenger_id+'); return false">Καταχώρηση</button>'
				  + ' 	</fieldset>'
				  + ' </form>'
				InfoWindow.setContent(iwform4);
			});
			function downloadUrl(url, callback) {
				var request = window.ActiveXObject ?
				new ActiveXObject('Microsoft.XMLHTTP') :
				new XMLHttpRequest;

				request.onreadystatechange = function() {
					if (request.readyState == 4) {
						request.onreadystatechange = doNothing;
						callback(request, request.status);
					}
				};
				
				request.open('GET', url, true);
				request.send(null);
			}
			function doNothing() {}  
		}
		
		function process4(d_facebook,d_details,passenger_id) {
			var errors = '';		
            var d_username = fullname;
			var d_email = useremail;
			var d_facebook = $("#dr_details [name='d_facebook']").val();
			var q = jQuery("#dr_details [name='this_email']").val();
			var d_details = $("#dr_details [name='d_details']").val();
			if (!d_details) {
				errors += '- Παρακαλούμε εισάγετε τα σχόλια σας\n';
		    }
			if (errors) {
				errors = 'The following error occurred: \n' + errors;
				alert(errors);
				return false;
			}
			else {
				var url = "php/process4.php?d_username=" +d_username+ "&d_email=" +d_email+ "&d_facebook=" +d_facebook+ "&d_details=" +d_details+ "&passenger_id=" +passenger_id+ "&q=" +q;
				$.ajax({
					url: url,
					type: "POST",
					success: function(){
					}
				});
				var url = "php/booking2.php?passenger_id=" +passenger_id;
				$.ajax({
					url: url,
					type: "GET",
					success: function(){
						showResult6("ok");
					}
				});
			}
		}
		
		function showResult1(data) {
			$("#driver_details").clearForm().clearFields().resetForm();
			return false;
		}
		
		function showResult2(data) {
			$("#passenger_details").clearForm().clearFields().resetForm();
			return false;
		}
		
		function showResult3(data) {
			$("#dr_details").clearForm().clearFields().resetForm();
			return false;
		}
		
		function showResult4(data) {
			$("#pass_details").clearForm().clearFields().resetForm();
			return false;
		}
		
		function showResult5(data) {
			$("#pass_details").clearForm().clearFields().resetForm();
			for (var i=0; i<show1markers.length; i++) {
				show1markers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<show2markers.length; i++) {
				show2markers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<tmpmarkers.length; i++) {
				tmpmarkers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<passengermarkers.length; i++) {
				passengermarkers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<drivermarkers.length; i++) {
				drivermarkers[i].setVisible(false);
				InfoWindow.close();
			}
			InfoWindow.close();
			load2();
			return false;
		}

		function showResult6(data) {
			$("#dr_details").clearForm().clearFields().resetForm();
			for (var i=0; i<show1markers.length; i++) {
				show1markers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<show2markers.length; i++) {
				show2markers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<tmpmarkers.length; i++) {
				tmpmarkers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<passengermarkers.length; i++) {
				passengermarkers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<drivermarkers.length; i++) {
				drivermarkers[i].setVisible(false);
				InfoWindow.close();
			}
			InfoWindow.close();
			load1();
			return false;
		}
		
		function showResult7(data) {
			$("#dr_details").clearForm().clearFields().resetForm();
			return false;
		}
		
		function showResult8(data) {
			$("#pass_details").clearForm().clearFields().resetForm();
			return false;
		}
		
		function showResult9(data) {
			for (var i=0; i<tmpmarkers.length; i++) {
				tmpmarkers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<show1markers.length; i++) {
				show1markers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<show2markers.length; i++) {
				show2markers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<drivermarkers.length; i++) {
				drivermarkers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<passengermarkers.length; i++) {
				passengermarkers[i].setVisible(false);
				InfoWindow.close();
			}
			InfoWindow.close();
			return false;
		}
		
		function showResult10(data) {
			$("#in_details").clearForm().clearFields().resetForm();
			return false;
		}
		
		function showResult11(data) {
			$("#in_details2").clearForm().clearFields().resetForm();
			return false;
		}
		
		function createMarker1(point,fullname,useremail,facebook,ddate,hour,people,text,status,direction) {
			for (var i=0; i<tmpmarkers.length; i++) {
				tmpmarkers[i].setVisible(false);
				InfoWindow.close();
			}
			var marker = new google.maps.Marker({
				position: point,
				animation: google.maps.Animation.DROP
			});
			if (direction == "From Volos") {
				direction = "Από Βόλο";
			}
			else if (direction == "To Volos") {
				direction = "Προς Βόλο";
			}
			else if (direction == "From Larisa") {
				direction = "Από Λάρισα";
			}
			else if (direction == "To Larisa") {
				direction = "Προς Λάρισα";
			}
			else if (direction == "From Trikala") {
				direction = "Από Τρίκαλα";
			}
			else if (direction == "To Trikala") {
				direction = "Προς Τρίκαλα";
			}
			else if (direction == "From Karditsa") {
				direction = "Από Καρδίτσα";
			}
			else if (direction == "To Karditsa") {
				direction = "Προς Καρδίτσα";
			}
			else if (direction == "From Lamia") {
				direction = "Από Λαμία";
			}
			else if (direction == "To Lamia") {
				direction = "Προς Λαμία";
			}
			if(facebook == "" ) {
				var txt = '<u><b>Όνομα Χρήστη</b></u>' + ': ' + fullname + '<br>' + '<u><b>E-mail</b></u>' + ': ' + useremail + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Έχω χώρο για άτομα</b></u>' + ': ' + people + '<br>' + '<u><b>Κατεύθυνση</b></u>' + ': ' + direction  + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + text;
			}
			else {
				var txt = '<u><b>Όνομα Χρήστη</b></u>' + ': ' + fullname + '<br>' + '<u><b>E-mail</b></u>' + ': ' + useremail + '<br>' + '<u><b>Facebook</b></u>' + ': ' + '<a href="http://www.facebook.com/'+facebook+'" target="_blank">'+facebook+'</a>' + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Έχω χώρο για άτομα</b></u>' + ': ' + people + '<br>' + '<u><b>Κατεύθυνση</b></u>' + ': ' + direction  + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + text;
			}
			if((direction == "Από Βόλο") || (direction == "Από Λάρισα") || (direction == "Από Τρίκαλα") || (direction == "Από Καρδίτσα") || (direction == "Από Λαμία")) {				
				google.maps.event.addListener(marker,"mouseover", function() {
					marker.setIcon('images/blue_Marker_new2.png');
					InfoWindow.setContent(txt);
					InfoWindow.open(map,marker);
				});
				google.maps.event.addListener(marker,"click", function() {
					marker.setIcon('images/blue_Marker_new2.png');
					InfoWindow.setContent(txt);
					InfoWindow.open(map,marker);
				});
				marker.setMap(map);
				drivermarkers.push(marker);
				google.maps.event.addListener(map,"click", function() {
					for (var i=0; i<drivermarkers.length; i++) {
						InfoWindow.close();
					}
				});
				return marker;
			}
			else {					
				google.maps.event.addListener(marker,"mouseover", function() {
					marker.setIcon('images/blue_Marker_new3.png');
					InfoWindow.setContent(txt);
					InfoWindow.open(map,marker);
				});
				google.maps.event.addListener(marker,"click", function() {
					marker.setIcon('images/blue_Marker_new3.png');
					InfoWindow.setContent(txt);
					InfoWindow.open(map,marker);
				});
				marker.setMap(map);
				drivermarkers.push(marker);
				google.maps.event.addListener(map,"click", function() {
					for (var i=0; i<drivermarkers.length; i++) {
						InfoWindow.close();
					}
				});
				return marker;
			}
		}
		
		function createMarker2(point,fullname,useremail,facebook,ddate,hour,people,text,status,direction) {
			for (var i=0; i<tmpmarkers.length; i++) {
				tmpmarkers[i].setVisible(false);
				InfoWindow.close();
			}
			var marker = new google.maps.Marker({
				position: point,
				animation: google.maps.Animation.DROP
			});
			if (direction == "From Volos") {
				direction = "Από Βόλο";
			}
			else if (direction == "To Volos") {
				direction = "Προς Βόλο";
			}
			else if (direction == "From Larisa") {
				direction = "Από Λάρισα";
			}
			else if (direction == "To Larisa") {
				direction = "Προς Λάρισα";
			}
			else if (direction == "From Trikala") {
				direction = "Από Τρίκαλα";
			}
			else if (direction == "To Trikala") {
				direction = "Προς Τρίκαλα";
			}
			else if (direction == "From Karditsa") {
				direction = "Από Καρδίτσα";
			}
			else if (direction == "To Karditsa") {
				direction = "Προς Καρδίτσα";
			}
			else if (direction == "From Lamia") {
				direction = "Από Λαμία";
			}
			else if (direction == "To Lamia") {
				direction = "Προς Λαμία";
			}
			if(facebook == "" ) {
				var txt = '<u><b>Όνομα Χρήστη</b></u>' + ': ' + fullname + '<br>' + '<u><b>E-mail</b></u>' + ': ' + useremail + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Άτομα</b></u>' + ': ' + people + '<br>' + '<u><b>Κατεύθυνση</b></u>' + ': ' + direction  + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + text;
			}
			else {
				var txt = '<u><b>Όνομα Χρήστη</b></u>' + ': ' + fullname + '<br>' + '<u><b>E-mail</b></u>' + ': ' + useremail + '<br>' + '<u><b>Facebook</b></u>' + ': ' + '<a href="http://www.facebook.com/'+facebook+'" target="_blank">'+facebook+'</a>' + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Άτομα</b></u>' + ': ' + people + '<br>' + '<u><b>Κατεύθυνση</b></u>' + ': ' + direction  + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + text;
			}
			if((direction == "Από Βόλο") || (direction == "Από Λάρισα") || (direction == "Από Τρίκαλα") || (direction == "Από Καρδίτσα") || (direction == "Από Λαμία")) {				
				google.maps.event.addListener(marker,"mouseover", function() {
					marker.setIcon('images/marker_red2.png');
					InfoWindow.setContent(txt);
					InfoWindow.open(map,marker);
				});
				google.maps.event.addListener(marker,"click", function() {
					marker.setIcon('images/marker_red2.png');
					InfoWindow.setContent(txt);
					InfoWindow.open(map,marker);
				});
				marker.setMap(map);
				passengermarkers.push(marker);
				google.maps.event.addListener(map,"click", function() {
					for (var i=0; i<passengermarkers.length; i++) {
						InfoWindow.close();
					}
				});
				return marker;
			}
			else {				
				google.maps.event.addListener(marker,"mouseover", function() {
					marker.setIcon('images/marker_red3.png');
					InfoWindow.setContent(txt);
					InfoWindow.open(map,marker);
				});
				google.maps.event.addListener(marker,"click", function() {
					marker.setIcon('images/marker_red3.png');
					InfoWindow.setContent(txt);
					InfoWindow.open(map,marker);
				});
				marker.setMap(map);
				passengermarkers.push(marker);
				google.maps.event.addListener(map,"click", function() {
					for (var i=0; i<passengermarkers.length; i++) {
						InfoWindow.close();
					}
				});
				return marker;
			}
		}
		
		function createMarker3(driver_id,name,username,email,facebook,ddate,hour,people,text,point,status,distance,duration,radius,p_username,p_email,p_facebook,p_details,direction) {	
			var marker = new google.maps.Marker({
				position: point,
				animation: google.maps.Animation.DROP
			});
			var rad = radius * 1000;
			var options = {
				strokeColor: '#FF0000',
				strokeOpacity: 0.8,
				strokeWeight: 2,
				fillColor: '#FF0000',
				fillOpacity: 0.35,
				map: map,
				center: point,
				radius: rad
			};
			if (p_facebook == "") {
				p_facebook = "-";
			}			
			var lat = marker.getPosition().lat();
			var lng = marker.getPosition().lng();
			var rd;
			if (direction == "From Volos") {
				direction = "Από Βόλο";
				home = home1;
			}
			else if (direction == "To Volos") {
				direction = "Προς Βόλο";
				home = home1;
			}
			else if (direction == "From Larisa") {
				direction = "Από Λάρισα";
				home = home2;
			}
			else if (direction == "To Larisa") {
				direction = "Προς Λάρισα";
				home = home2;
			}
			else if (direction == "From Trikala") {
				direction = "Από Τρίκαλα";
				home = home3;
			}
			else if (direction == "To Trikala") {
				direction = "Προς Τρίκαλα";
				home = home3;
			}
			else if (direction == "From Karditsa") {
				direction = "Από Καρδίτσα";
				home = home4;
			}
			else if (direction == "To Karditsa") {
				direction = "Προς Καρδίτσα";
				home = home4;
			}
			else if (direction == "From Lamia") {
				direction = "Από Λαμία";
				home = home5;
			}
			else if (direction == "To Lamia") {
				direction = "Προς Λαμία";
				home = home5;
			}
			var request = {
				origin:home,
				destination:point,
				travelMode: google.maps.TravelMode.DRIVING
			};
			if((direction == "Από Βόλο") || (direction == "Από Λάρισα") || (direction == "Από Τρίκαλα") || (direction == "Από Καρδίτσα") || (direction == "Από Λαμία")) {
				rd = '<u><b>Eμβέλεια αποβίβασης</b></u>' + '<br>' + radius;
			}
			else {
				rd = '<u><b>Eμβέλεια επιβίβασης</b></u>' + '<br>' + radius;
			}
			if (username == fullname) {
				var edit = '<a href="#" onclick="edit1('+ driver_id +')" id="edit1">Επεξεργασία δρομολογίου</a>';
				var del  = '<a href="#" onclick="del1('+ driver_id +')" id="del1">Διαγραφή δρομολογίου</a>';
			}
			if (facebook == "" && status == "Active!" && username == fullname) {
				var txt = '<u><b>Όνομα Χρήστη</b></u>' + ': ' + '<a href="#" onclick="profil(\''+username+'\')" id="profil">'+username+'</a>' + '<br>' + '<u><b>E-mail</b></u>' + ': ' + email + '<br>' + '<u><b>Κατεύθυνση</b></u>' + ': ' + direction  + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Έχω χώρο για άτομα</b></u>' + ': ' + people + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + text + '<br>' + '<u><b>Προσεγγιστική απόσταση από Βόλο</b></u>' + '<br>' + distance  + '<br>' + '<u><b>Εκτιμώμενη διάρκεια ταξιδιού</b></u>' + '<br>' + duration + '<br>' + rd + ' χλμ' + '<br>' + '<br>' + '<form id="booking_details" method="get" action="php/booking1.php"><div style="padding-left:110px"><button type="button" name="submit" onclick="booking1('+ driver_id +','+ lat +','+ lng +')">Ενδιαφέρομαι!</button></div></form>' + '<a href="#" onclick="quote1('+ driver_id +')" id="quote1">Επικοινωνήστε με τον οδηγό</a>' + ' | ' + edit + ' | ' + del;
			}
			else if (facebook == "" && status == "Active!" && username != fullname) {
				var txt = '<u><b>Όνομα Χρήστη</b></u>' + ': ' + '<a href="#" onclick="profil(\''+username+'\')" id="profil">'+username+'</a>' + '<br>' + '<u><b>E-mail</b></u>' + ': ' + email + '<br>' + '<u><b>Κατεύθυνση</b></u>' + ': ' + direction  + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Έχω χώρο για άτομα</b></u>' + ': ' + people + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + text + '<br>' + '<u><b>Προσεγγιστική απόσταση από Βόλο</b></u>' + '<br>' + distance  + '<br>' + '<u><b>Εκτιμώμενη διάρκεια ταξιδιού</b></u>' + '<br>' + duration + '<br>' + rd + ' χλμ' + '<br>' + '<br>' + '<form id="booking_details" method="get" action="php/booking1.php"><div style="padding-left:110px"><button type="button" name="submit" onclick="booking1('+ driver_id +','+ lat +','+ lng +')">Ενδιαφέρομαι!</button></div></form>' + '<a href="#" onclick="quote1('+ driver_id +')" id="quote1">Επικοινωνήστε με τον οδηγό</a>';
			}
			else if (facebook != "" && status == "Inactive..." && username == fullname) {
				var txt = '<u><b>Όνομα Χρήστη</b></u>' + ': ' + '<a href="#" onclick="profil(\''+username+'\')" id="profil">'+username+'</a>' + '<br>' + '<u><b>E-mail</b></u>' + ': ' + email + '<br>' + '<u><b>Facebook</b></u>' + ': ' + '<a href="http://www.facebook.com/'+facebook+'" target="_blank">'+facebook+'</a>' + '<br>' + '<u><b>Κατεύθυνση</b></u>' + ': ' + direction  + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Έχω χώρο για άτομα</b></u>' + ': ' + people + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + text + '<br>' + '<u><b>Προσεγγιστική απόσταση από Βόλο</b></u>' + '<br>' + distance + '<br>' + '<u><b>Εκτιμώμενη διάρκεια ταξιδιού</b></u>' + '<br>' + duration + '<br>' + rd + ' χλμ' + '<br><br>' + '<span style="color:red; font-size:11pt"><u><b>ΠΡΟΦΙΛ ΕΝΔΙΑΦΕΡΟΜΕΝΟΥ</b></u></span>' + '<br>' + '<b>Όνομα Χρήστη</b>' + ': ' + '<a href="#" onclick="profil(\''+p_username+'\')" id="profil">'+p_username+'</a>' + '<br>' + '<b>E-mail: </b>' + p_email + '<br>' + '<b>Facebook</b>' + ': ' + '<a href="http://www.facebook.com/'+p_facebook+'" target="_blank">'+p_facebook+'</a>' + '<br>' + '<b>Σχόλια: </b>' + p_details + '<br><br><a href="#" onclick="quote1('+ driver_id +')" id="quote1">Επικοινωνήστε με τον οδηγό</a>' + ' | ' + edit + ' | ' + del;
			}
			else if (facebook != "" && status == "Inactive..." && username != fullname) {
				var txt = '<u><b>Όνομα Χρήστη</b></u>' + ': ' + '<a href="#" onclick="profil(\''+username+'\')" id="profil">'+username+'</a>' + '<br>' + '<u><b>E-mail</b></u>' + ': ' + email + '<br>' + '<u><b>Facebook</b></u>' + ': ' + '<a href="http://www.facebook.com/'+facebook+'" target="_blank">'+facebook+'</a>' + '<br>' + '<u><b>Κατεύθυνση</b></u>' + ': ' + direction  + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Έχω χώρο για άτομα</b></u>' + ': ' + people + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + text + '<br>' + '<u><b>Προσεγγιστική απόσταση από Βόλο</b></u>' + '<br>' + distance + '<br>' + '<u><b>Εκτιμώμενη διάρκεια ταξιδιού</b></u>' + '<br>' + duration + '<br>' + rd + ' χλμ' + '<br><br>' + '<span style="color:red; font-size:11pt"><u><b>ΠΡΟΦΙΛ ΕΝΔΙΑΦΕΡΟΜΕΝΟΥ</b></u></span>' + '<br>' + '<b>Όνομα Χρήστη</b>' + ': ' + '<a href="#" onclick="profil(\''+p_username+'\')" id="profil">'+p_username+'</a>' + '<br>' + '<b>E-mail: </b>' + p_email + '<br>' + '<b>Facebook</b>' + ': ' + '<a href="http://www.facebook.com/'+p_facebook+'" target="_blank">'+p_facebook+'</a>' + '<br>' + '<b>Σχόλια: </b>' + p_details + '<br><br><a href="#" onclick="quote1('+ driver_id +')" id="quote1">Επικοινωνήστε με τον οδηγό</a>';
			}
			else if (facebook == "" && status == "Inactive..." && username == fullname) {
				var txt = '<u><b>Όνομα Χρήστη</b></u>' + ': ' + '<a href="#" onclick="profil(\''+username+'\')" id="profil">'+username+'</a>' + '<br>' + '<u><b>E-mail</b></u>' + ': ' + email + '<br>' + '<u><b>Κατεύθυνση</b></u>' + ': ' + direction  + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Έχω χώρο για άτομα</b></u>' + ': ' + people + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + text + '<br>' + '<u><b>Προσεγγιστική απόσταση από Βόλο</b></u>' + '<br>' + distance + '<br>' + '<u><b>Εκτιμώμενη διάρκεια ταξιδιού</b></u>' + '<br>' + duration + '<br>' + rd + ' χλμ' + '<br><br>' + '<span style="color:red; font-size:11pt"><u><b>ΠΡΟΦΙΛ ΕΝΔΙΑΦΕΡΟΜΕΝΟΥ</b></u></span>' + '<br>' + '<b>Όνομα Χρήστη</b>' + ': ' + '<a href="#" onclick="profil(\''+p_username+'\')" id="profil">'+p_username+'</a>' + '<br>' + '<b>E-mail: </b>' + p_email + '<br>' + '<b>Facebook</b>' + ': ' + '<a href="http://www.facebook.com/'+p_facebook+'" target="_blank">'+p_facebook+'</a>' + '<br>' + '<b>Σχόλια: </b>' + p_details + '<br><br><a href="#" onclick="quote1('+ driver_id +')" id="quote1">Επικοινωνήστε με τον οδηγό</a>' + ' | ' + edit + ' | ' + del;
			}
			else if (facebook == "" && status == "Inactive..." && username != fullname) {
				var txt = '<u><b>Όνομα Χρήστη</b></u>' + ': ' + '<a href="#" onclick="profil(\''+username+'\')" id="profil">'+username+'</a>' + '<br>' + '<u><b>E-mail</b></u>' + ': ' + email + '<br>' + '<u><b>Κατεύθυνση</b></u>' + ': ' + direction  + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Έχω χώρο για άτομα</b></u>' + ': ' + people + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + text + '<br>' + '<u><b>Προσεγγιστική απόσταση από Βόλο</b></u>' + '<br>' + distance + '<br>' + '<u><b>Εκτιμώμενη διάρκεια ταξιδιού</b></u>' + '<br>' + duration + '<br>' + rd + ' χλμ' + '<br><br>' + '<span style="color:red; font-size:11pt"><u><b>ΠΡΟΦΙΛ ΕΝΔΙΑΦΕΡΟΜΕΝΟΥ</b></u></span>' + '<br>' + '<b>Όνομα Χρήστη</b>' + ': ' + '<a href="#" onclick="profil(\''+p_username+'\')" id="profil">'+p_username+'</a>' + '<br>' + '<b>E-mail: </b>' + p_email + '<br>' + '<b>Facebook</b>' + ': ' + '<a href="http://www.facebook.com/'+p_facebook+'" target="_blank">'+p_facebook+'</a>' + '<br>' + '<b>Σχόλια: </b>' + p_details + '<br><br><a href="#" onclick="quote1('+ driver_id +')" id="quote1">Επικοινωνήστε με τον οδηγό</a>';
			}
			else if (facebook != "" && status == "Active!" && username == fullname) {
				var txt = '<u><b>Όνομα Χρήστη</b></u>' + ': ' + '<a href="#" onclick="profil(\''+username+'\')" id="profil">'+username+'</a>' + '<br>' + '<u><b>E-mail</b></u>' + ': ' + email + '<br>' + '<u><b>Facebook</b></u>' + ': ' + '<a href="http://www.facebook.com/'+facebook+'" target="_blank">'+facebook+'</a>' + '<br>' + '<u><b>Κατεύθυνση</b></u>' + ': ' + direction  + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Έχω χώρο για άτομα</b></u>' + ': ' + people + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + text + '<br>' + '<u><b>Προσεγγιστική απόσταση από Βόλο</b></u>' + '<br>' + distance + '<br>' + '<u><b>Εκτιμώμενη διάρκεια ταξιδιού</b></u>' + '<br>' + duration + '<br>' + rd + ' χλμ' + '<br><br>' + '<form id="booking_details" method="get" action="php/booking1.php"><div style="padding-left:110px"><button type="button" name="submit" onclick="booking1('+driver_id+','+lat+','+lng+')">Ενδιαφέρομαι!</button></div></form>' + '<a href="#" onclick="quote1('+ driver_id +')" id="quote1">Επικοινωνήστε με τον οδηγό</a>' + ' | ' + edit + ' | ' + del;
			}
			else if (facebook != "" && status == "Active!" && username != fullname) {
				var txt = '<u><b>Όνομα Χρήστη</b></u>' + ': ' + '<a href="#" onclick="profil(\''+username+'\')" id="profil">'+username+'</a>' + '<br>' + '<u><b>E-mail</b></u>' + ': ' + email + '<br>' + '<u><b>Facebook</b></u>' + ': ' + '<a href="http://www.facebook.com/'+facebook+'" target="_blank">'+facebook+'</a>' + '<br>' + '<u><b>Κατεύθυνση</b></u>' + ': ' + direction  + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Έχω χώρο για άτομα</b></u>' + ': ' + people + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + text + '<br>' + '<u><b>Προσεγγιστική απόσταση από Βόλο</b></u>' + '<br>' + distance + '<br>' + '<u><b>Εκτιμώμενη διάρκεια ταξιδιού</b></u>' + '<br>' + duration + '<br>' + rd + ' χλμ' + '<br><br>' + '<form id="booking_details" method="get" action="php/booking1.php"><div style="padding-left:110px"><button type="button" name="submit" onclick="booking1('+driver_id+','+lat+','+lng+')">Ενδιαφέρομαι!</button></div></form>' + '<a href="#" onclick="quote1('+ driver_id +')" id="quote1">Επικοινωνήστε με τον οδηγό</a>';
			}
			if (status == "Inactive...") {
				if((direction == "Από Βόλο") || (direction == "Από Λάρισα") || (direction == "Από Τρίκαλα") || (direction == "Από Καρδίτσα") || (direction == "Από Λαμία")) {
					marker.setIcon("images/blue_Marker_new2.png");
					Circle.setMap(null);
					directionsDisplay.setMap(null);
					google.maps.event.addListener(marker,"mouseover", function() {
						Circle = new google.maps.Circle(options);
						InfoWindow.setContent(txt);
						InfoWindow.open(map,marker);
					});
					google.maps.event.addListener(marker,"mouseout", function() {
						Circle.setMap(null);
					});
					google.maps.event.addListener(marker,"click", function() {
						InfoWindow.setContent(txt);
						InfoWindow.open(map,marker);
						directionsService.route(request, function(response, status) {
							if (status == google.maps.DirectionsStatus.OK) {
								directionsDisplay.setDirections(response);
							}
						});
						directionsDisplay.setMap(map);
					});
					google.maps.event.addListener(map,"click", function() {
						directionsDisplay.setMap(null);
						for (var i=0; i<show2markers.length; i++) {
							InfoWindow.close();
						}
					});
					marker.setMap(map);
					show2markers.push(marker);
					return marker;
				}
				else {
					directionsDisplay.setMap(null);
					marker.setIcon("images/blue_Marker_new3.png");
					Circle.setMap(null);
					google.maps.event.addListener(marker,"mouseover", function() {
						Circle = new google.maps.Circle(options);
						InfoWindow.setContent(txt);
						InfoWindow.open(map,marker);
					});
					google.maps.event.addListener(marker,"mouseout", function() {
						Circle.setMap(null);
					});
					google.maps.event.addListener(marker,"click", function() {
						InfoWindow.setContent(txt);
						InfoWindow.open(map,marker);
						directionsService.route(request, function(response, status) {
							if (status == google.maps.DirectionsStatus.OK) {
								directionsDisplay.setDirections(response);
							}
						});
						directionsDisplay.setMap(map);
					});
					marker.setMap(map);
					show2markers.push(marker);
					google.maps.event.addListener(map,"click", function() {
						directionsDisplay.setMap(null);
						for (var i=0; i<show2markers.length; i++) {
							InfoWindow.close();
						}
					});
					return marker;
				}
			}
			else {
				if((direction == "Από Βόλο") || (direction == "Από Λάρισα") || (direction == "Από Τρίκαλα") || (direction == "Από Καρδίτσα") || (direction == "Από Λαμία")) {
					directionsDisplay.setMap(null);
					marker.setIcon("images/blue_Marker_new2.png");
					Circle.setMap(null);
					google.maps.event.addListener(marker,"mouseover", function() {
						Circle = new google.maps.Circle(options);
						InfoWindow.setContent(txt);
						InfoWindow.open(map,marker);
					});
					google.maps.event.addListener(marker,"mouseout", function() {
						Circle.setMap(null);
					});
					google.maps.event.addListener(marker,"click", function() {
						InfoWindow.setContent(txt);
						InfoWindow.open(map,marker);
						directionsService.route(request, function(response, status) {
							if (status == google.maps.DirectionsStatus.OK) {
								directionsDisplay.setDirections(response);
							}
						});
						directionsDisplay.setMap(map);
					});
					marker.setMap(map);
					show1markers.push(marker);
					google.maps.event.addListener(map,"click", function() {
						directionsDisplay.setMap(null);
						for (var i=0; i<show1markers.length; i++) {
							InfoWindow.close();
						}
					});
					return marker;
				}
				else {
					directionsDisplay.setMap(null);
					marker.setIcon("images/blue_Marker_new3.png");
					Circle.setMap(null);
					google.maps.event.addListener(marker,"mouseover", function() {
						Circle = new google.maps.Circle(options);
						InfoWindow.setContent(txt);
						InfoWindow.open(map,marker);
					});
					google.maps.event.addListener(marker,"mouseout", function() {
						Circle.setMap(null);
					});
					google.maps.event.addListener(marker,"click", function() {
						InfoWindow.setContent(txt);
						InfoWindow.open(map,marker);
						directionsService.route(request, function(response, status) {
							if (status == google.maps.DirectionsStatus.OK) {
								directionsDisplay.setDirections(response);
							}
						});
						directionsDisplay.setMap(map);
					});
					marker.setMap(map);
					show1markers.push(marker);
					google.maps.event.addListener(map,"click", function() {
						directionsDisplay.setMap(null);
						for (var i=0; i<show1markers.length; i++) {
							InfoWindow.close();
						}
					});
					return marker;
				}
			}
		}
		
		function createMarker4(passenger_id,name,username,email,facebook,ddate,hour,people,text,point,status,distance,duration,radius,d_username,d_email,d_facebook,d_details,direction) {
			var marker = new google.maps.Marker({
				position: point,
				animation: google.maps.Animation.DROP
			});
			var rad = radius * 1000;
			var options = {
				strokeColor: 'blue',
				strokeOpacity: 0.8,
				strokeWeight: 2,
				fillColor: 'blue',
				fillOpacity: 0.35,
				map: map,
				center: point,
				radius: rad
			};
			if (d_facebook == "") {
				d_facebook = "-";
			}
			var lat = marker.getPosition().lat();
			var lng = marker.getPosition().lng();
			var rd;
			if (direction == "From Volos") {
				direction = "Από Βόλο";
				home = home1;
			}
			else if (direction == "To Volos") {
				direction = "Προς Βόλο";
				home = home1;
			}
			else if (direction == "From Larisa") {
				direction = "Από Λάρισα";
				home = home2;
			}
			else if (direction == "To Larisa") {
				direction = "Προς Λάρισα";
				home = home2;
			}
			else if (direction == "From Trikala") {
				direction = "Από Τρίκαλα";
				home = home3;
			}
			else if (direction == "To Trikala") {
				direction = "Προς Τρίκαλα";
				home = home3;
			}
			else if (direction == "From Karditsa") {
				direction = "Από Καρδίτσα";
				home = home4;
			}
			else if (direction == "To Karditsa") {
				direction = "Προς Καρδίτσα";
				home = home4;
			}
			else if (direction == "From Lamia") {
				direction = "Από Λαμία";
				home = home5;
			}
			else if (direction == "To Lamia") {
				direction = "Προς Λαμία";
				home = home5;
			}
			var request = {
				origin:home,
				destination:point,
				travelMode: google.maps.TravelMode.DRIVING
			};
			if((direction == "Από Βόλο") || (direction == "Από Λάρισα") || (direction == "Από Τρίκαλα") || (direction == "Από Καρδίτσα") || (direction == "Από Λαμία")) {
				rd = '<u><b>Eμβέλεια αποβίβασης</b></u>' + '<br>' + radius;
			}
			else {
				rd = '<u><b>Eμβέλεια επιβίβασης</b></u>' + '<br>' + radius;
			}
			if (username == fullname) {
				var edit = '<a href="#" onclick="edit2('+ passenger_id +')" id="edit2">Επεξεργασία δρομολογίου</a>';
				var del  = '<a href="#" onclick="del2('+ passenger_id +')" id="del2">Διαγραφή δρομολογίου</a>';
			}
			if (facebook == "" && status == "Active!" && username == fullname) {
				var txt = '<u><b>Όνομα Χρήστη</b></u>' + ': ' + '<a href="#" onclick="profil(\''+username+'\')" id="profil">'+username+'</a>' + '<br>' + '<u><b>E-mail</b></u>' + ': ' + email + '<br>' + '<u><b>Κατεύθυνση</b></u>' + ': ' + direction  + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Άτομα</b></u>' + ': ' + people + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + text + '<br>' + '<u><b>Προσεγγιστική απόσταση από Βόλο</b></u>' + '<br>' + distance + '<br>' + '<u><b>Εκτιμώμενη διάρκεια ταξιδιού</b></u>' + '<br>' + duration + '<br>' + rd + ' χλμ' + '<br>' + '<br>' + '<form id="booking_details" method="get" action="php/booking1.php"><div style="padding-left:110px"><button type="button" name="submit" onclick="booking2('+ passenger_id +','+ lat +','+ lng +')">Ενδιαφέρομαι!</button></div></form>' + '<div align="center"><a href="#" onclick="quote2('+ passenger_id +')" id="quote2">Επικοινωνήστε με το συνεπιβάτη</a></div>' + ' | ' + edit + ' | ' + del;
			}
			else if (facebook == "" && status == "Active!" && username != fullname) {
				var txt = '<u><b>Όνομα Χρήστη</b></u>' + ': ' + '<a href="#" onclick="profil(\''+username+'\')" id="profil">'+username+'</a>' + '<br>' + '<u><b>E-mail</b></u>' + ': ' + email + '<br>' + '<u><b>Κατεύθυνση</b></u>' + ': ' + direction  + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Άτομα</b></u>' + ': ' + people + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + text + '<br>' + '<u><b>Προσεγγιστική απόσταση από Βόλο</b></u>' + '<br>' + distance + '<br>' + '<u><b>Εκτιμώμενη διάρκεια ταξιδιού</b></u>' + '<br>' + duration + '<br>' + rd + ' χλμ' + '<br>' + '<br>' + '<form id="booking_details" method="get" action="php/booking1.php"><div style="padding-left:110px"><button type="button" name="submit" onclick="booking2('+ passenger_id +','+ lat +','+ lng +')">Ενδιαφέρομαι!</button></div></form>' + '<div align="center"><a href="#" onclick="quote2('+ passenger_id +')" id="quote2">Επικοινωνήστε με το συνεπιβάτη</a></div>';
			}
			else if (facebook != "" && status == "Inactive..." && username == fullname) {
				var txt = '<u><b>Όνομα Χρήστη</b></u>' + ': ' + '<a href="#" onclick="profil(\''+username+'\')" id="profil">'+username+'</a>' + '<br>' + '<u><b>E-mail</b></u>' + ': ' + email + '<br>' + '<u><b>Facebook</b></u>' + ': ' + '<a href="http://www.facebook.com/'+facebook+'" target="_blank">'+facebook+'</a>' + '<br>' + '<u><b>Κατεύθυνση</b></u>' + ': ' + direction  + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Άτομα</b></u>' + ': ' + people + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + text + '<br>' + '<u><b>Προσεγγιστική απόσταση από Βόλο</b></u>' + '<br>' + distance + '<br>' + '<u><b>Εκτιμώμενη διάρκεια ταξιδιού</b></u>' + '<br>' + duration + '<br>' + rd + ' χλμ' + '<br><br>' + '<span style="color:blue; font-size:11pt"><u><b>ΠΡΟΦΙΛ ΕΝΔΙΑΦΕΡΟΜΕΝΟΥ</b></u></span>' + '<br>' + '<b>Όνομα Χρήστη</b>' + ': ' + '<a href="#" onclick="profil(\''+d_username+'\')" id="profil">'+d_username+'</a>' + '<br>' + '<b>E-mail: </b>' + d_email + '<br>' + '<b>Facebook</b>' + ': ' + '<a href="http://www.facebook.com/'+d_facebook+'" target="_blank">'+d_facebook+'</a>' + '<br>' + '<b>Σχόλια: </b>' + d_details + '<br><br><a href="#" onclick="quote2('+ passenger_id +')" id="quote2">Επικοινωνήστε με το συνεπιβάτη</a>' + ' | ' + edit + ' | ' + del;
			}
			else if (facebook != "" && status == "Inactive..." && username != fullname) {
				var txt = '<u><b>Όνομα Χρήστη</b></u>' + ': ' + '<a href="#" onclick="profil(\''+username+'\')" id="profil">'+username+'</a>' + '<br>' + '<u><b>E-mail</b></u>' + ': ' + email + '<br>' + '<u><b>Facebook</b></u>' + ': ' + '<a href="http://www.facebook.com/'+facebook+'" target="_blank">'+facebook+'</a>' + '<br>' + '<u><b>Κατεύθυνση</b></u>' + ': ' + direction  + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Άτομα</b></u>' + ': ' + people + '<br>' + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + text + '<br>' + '<u><b>Προσεγγιστική απόσταση από Βόλο</b></u>' + '<br>' + distance + '<br>' + '<u><b>Εκτιμώμενη διάρκεια ταξιδιού</b></u>' + '<br>' + duration + '<br>' + rd + ' χλμ' + '<br><br>' + '<span style="color:blue; font-size:11pt"><u><b>ΠΡΟΦΙΛ ΕΝΔΙΑΦΕΡΟΜΕΝΟΥ</b></u></span>' + '<br>' + '<b>Όνομα Χρήστη</b>' + ': ' + '<a href="#" onclick="profil(\''+d_username+'\')" id="profil">'+d_username+'</a>' + '<br>' + '<b>E-mail: </b>' + d_email + '<br>' + '<b>Facebook</b>' + ': ' + '<a href="http://www.facebook.com/'+d_facebook+'" target="_blank">'+d_facebook+'</a>' + '<br>' + '<b>Σχόλια: </b>' + d_details + '<br><br><a href="#" onclick="quote2('+ passenger_id +')" id="quote2">Επικοινωνήστε με το συνεπιβάτη</a>';
			}
			else if (facebook == "" && status == "Inactive..." && username == fullname) {
				var txt = '<u><b>Όνομα Χρήστη</b></u>' + ': ' + '<a href="#" onclick="profil(\''+username+'\')" id="profil">'+username+'</a>' + '<br>' + '<u><b>E-mail</b></u>' + ': ' + email + '<br>' + '<u><b>Κατεύθυνση</b></u>' + ': ' + direction  + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Άτομα</b></u>' + ': ' + people + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + text + '<br>' + '<u><b>Προσεγγιστική απόσταση από Βόλο</b></u>' + '<br>' + distance + '<br>' + '<u><b>Εκτιμώμενη διάρκεια ταξιδιού</b></u>' + '<br>' + duration + '<br>' + rd + ' χλμ' + '<br><br>' + '<span style="color:blue; font-size:11pt"><u><b>ΠΡΟΦΙΛ ΕΝΔΙΑΦΕΡΟΜΕΝΟΥ</b></u></span>' + '<br>' + '<b>Όνομα Χρήστη</b>' + ': ' + '<a href="#" onclick="profil(\''+d_username+'\')" id="profil">'+d_username+'</a>' + '<br>' + '<b>E-mail: </b>' + d_email + '<br>' + '<b>Facebook</b>' + ': ' + '<a href="http://www.facebook.com/'+d_facebook+'" target="_blank">'+d_facebook+'</a>' + '<br>' + '<b>Σχόλια: </b>' + d_details + '<br><br><a href="#" onclick="quote2('+ passenger_id +')" id="quote2">Επικοινωνήστε με το συνεπιβάτη</a>' + ' | ' + edit + ' | ' + del;
			}
			else if (facebook == "" && status == "Inactive..." && username != fullname) {
				var txt = '<u><b>Όνομα Χρήστη</b></u>' + ': ' + '<a href="#" onclick="profil(\''+username+'\')" id="profil">'+username+'</a>' + '<br>' + '<u><b>E-mail</b></u>' + ': ' + email + '<br>' + '<u><b>Κατεύθυνση</b></u>' + ': ' + direction  + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Άτομα</b></u>' + ': ' + people + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + text + '<br>' + '<u><b>Προσεγγιστική απόσταση από Βόλο</b></u>' + '<br>' + distance + '<br>' + '<u><b>Εκτιμώμενη διάρκεια ταξιδιού</b></u>' + '<br>' + duration + '<br>' + rd + ' χλμ' + '<br><br>' + '<span style="color:blue; font-size:11pt"><u><b>ΠΡΟΦΙΛ ΕΝΔΙΑΦΕΡΟΜΕΝΟΥ</b></u></span>' + '<br>' + '<b>Όνομα Χρήστη</b>' + ': ' + '<a href="#" onclick="profil(\''+d_username+'\')" id="profil">'+d_username+'</a>' + '<br>' + '<b>E-mail: </b>' + d_email + '<br>' + '<b>Facebook</b>' + ': ' + '<a href="http://www.facebook.com/'+d_facebook+'" target="_blank">'+d_facebook+'</a>' + '<br>' + '<b>Σχόλια: </b>' + d_details + '<br><br><a href="#" onclick="quote2('+ passenger_id +')" id="quote2">Επικοινωνήστε με το συνεπιβάτη</a>';
			}
			else if (facebook != "" && status == "Active!" && username == fullname) {
				var txt = '<u><b>Όνομα Χρήστη</b></u>' + ': ' + '<a href="#" onclick="profil(\''+username+'\')" id="profil">'+username+'</a>' + '<br>' + '<u><b>E-mail</b></u>' + ': ' + email + '<br>' + '<u><b>Facebook</b></u>' + ': ' + '<a href="http://www.facebook.com/'+facebook+'" target="_blank">'+facebook+'</a>' + '<br>' + '<u><b>Κατεύθυνση</b></u>' + ': ' + direction  + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Άτομα</b></u>' + ': ' + people + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + text + '<br>' + '<u><b>Προσεγγιστική απόσταση από Βόλο</b></u>' + '<br>' + distance + '<br>' + '<u><b>Εκτιμώμενη διάρκεια ταξιδιού</b></u>' + '<br>' + duration + '<br>' + rd + ' χλμ' + '<br><br>' + '<form id="booking_details" method="get" action="php/booking1.php"><div style="padding-left:110px"><button type="button" name="submit" onclick="booking2('+passenger_id+','+lat+','+lng+')">Ενδιαφέρομαι!</button></div></form>' + '<a href="#" onclick="quote2('+ passenger_id +')" id="quote2">Επικοινωνήστε με το συνεπιβάτη</a>' + ' | ' + edit + ' | ' + del;
			}
			else if (facebook != "" && status == "Active!" && username != fullname) {
				var txt = '<u><b>Όνομα Χρήστη</b></u>' + ': ' + '<a href="#" onclick="profil(\''+username+'\')" id="profil">'+username+'</a>' + '<br>' + '<u><b>E-mail</b></u>' + ': ' + email + '<br>' + '<u><b>Facebook</b></u>' + ': ' + '<a href="http://www.facebook.com/'+facebook+'" target="_blank">'+facebook+'</a>' + '<br>' + '<u><b>Κατεύθυνση</b></u>' + ': ' + direction  + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Άτομα</b></u>' + ': ' + people + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + text + '<br>' + '<u><b>Προσεγγιστική απόσταση από Βόλο</b></u>' + '<br>' + distance + '<br>' + '<u><b>Εκτιμώμενη διάρκεια ταξιδιού</b></u>' + '<br>' + duration + '<br>' + rd + ' χλμ' + '<br><br>' + '<form id="booking_details" method="get" action="php/booking1.php"><div style="padding-left:110px"><button type="button" name="submit" onclick="booking2('+passenger_id+','+lat+','+lng+')">Ενδιαφέρομαι!</button></div></form>' + '<a href="#" onclick="quote2('+ passenger_id +')" id="quote2">Επικοινωνήστε με το συνεπιβάτη</a>';
			}
			if (status == "Inactive...") {
				if((direction == "Από Βόλο") || (direction == "Από Λάρισα") || (direction == "Από Τρίκαλα") || (direction == "Από Καρδίτσα") || (direction == "Από Λαμία")) {
					directionsDisplay.setMap(null);
					marker.setIcon("images/marker_red2.png");
					Circle.setMap(null);
					google.maps.event.addListener(marker,"mouseover", function() {
						Circle = new google.maps.Circle(options);
						InfoWindow.setContent(txt);
						InfoWindow.open(map,marker);
					});
					google.maps.event.addListener(marker,"mouseout", function() {
						Circle.setMap(null);
					});
					google.maps.event.addListener(marker,"click", function() {
						InfoWindow.setContent(txt);
						InfoWindow.open(map,marker);
						directionsService.route(request, function(response, status) {
							if (status == google.maps.DirectionsStatus.OK) {
								directionsDisplay.setDirections(response);
							}
						});
						directionsDisplay.setMap(map);
					});
					marker.setMap(map);
					show2markers.push(marker);
					google.maps.event.addListener(map,"click", function() {
						directionsDisplay.setMap(null);
						for (var i=0; i<show2markers.length; i++) {
							InfoWindow.close();
						}
					});
					return marker;
				}
				else {
					directionsDisplay.setMap(null);
					marker.setIcon("images/marker_red3.png");
					Circle.setMap(null);
					google.maps.event.addListener(marker,"mouseover", function() {
						Circle = new google.maps.Circle(options);
						InfoWindow.setContent(txt);
						InfoWindow.open(map,marker);
					});
					google.maps.event.addListener(marker,"mouseout", function() {
						Circle.setMap(null);
					});
					google.maps.event.addListener(marker,"click", function() {
						InfoWindow.setContent(txt);
						InfoWindow.open(map,marker);
						directionsService.route(request, function(response, status) {
							if (status == google.maps.DirectionsStatus.OK) {
								directionsDisplay.setDirections(response);
							}
						});
						directionsDisplay.setMap(map);
					});
					marker.setMap(map);
					show2markers.push(marker);
					google.maps.event.addListener(map,"click", function() {
						directionsDisplay.setMap(null);
						for (var i=0; i<show2markers.length; i++) {
							InfoWindow.close();
						}
					});
					return marker;
				}
			}
			else {
				if((direction == "Από Βόλο") || (direction == "Από Λάρισα") || (direction == "Από Τρίκαλα") || (direction == "Από Καρδίτσα") || (direction == "Από Λαμία")) {
					directionsDisplay.setMap(null);
					marker.setIcon("images/marker_red2.png");
					Circle.setMap(null);
					google.maps.event.addListener(marker,"mouseover", function() {
						Circle = new google.maps.Circle(options);
						InfoWindow.setContent(txt);
						InfoWindow.open(map,marker);
					});
					google.maps.event.addListener(marker,"mouseout", function() {
						Circle.setMap(null);
					});
					google.maps.event.addListener(marker,"click", function() {
						InfoWindow.setContent(txt);
						InfoWindow.open(map,marker);
						directionsService.route(request, function(response, status) {
							if (status == google.maps.DirectionsStatus.OK) {
								directionsDisplay.setDirections(response);
							}
						});
						directionsDisplay.setMap(map);
					});
					marker.setMap(map);
					show1markers.push(marker);
					google.maps.event.addListener(map,"click", function() {
						directionsDisplay.setMap(null);
						for (var i=0; i<show1markers.length; i++) {
							InfoWindow.close();
						}
					});
					return marker;
				}
				else {
					directionsDisplay.setMap(null);
					marker.setIcon("images/marker_red3.png");
					Circle.setMap(null);
					google.maps.event.addListener(marker,"mouseover", function() {
						Circle = new google.maps.Circle(options);
						InfoWindow.setContent(txt);
						InfoWindow.open(map,marker);
					});
					google.maps.event.addListener(marker,"mouseout", function() {
						Circle.setMap(null);
					});
					google.maps.event.addListener(marker,"click", function() {
						InfoWindow.setContent(txt);
						InfoWindow.open(map,marker);
						directionsService.route(request, function(response, status) {
							if (status == google.maps.DirectionsStatus.OK) {
								directionsDisplay.setDirections(response);
							}
						});
						directionsDisplay.setMap(map);
					});
					marker.setMap(map);
					show1markers.push(marker);
					google.maps.event.addListener(map,"click", function() {
						directionsDisplay.setMap(null);
						for (var i=0; i<show1markers.length; i++) {
							InfoWindow.close();
						}
					});	
					return marker;
				}
			}
		}
		
		function createMarker5(id,username,email,facebook,ddate,hour,people,direction,details,point1,point2,status,radius,name,everyday) {
			var marker1 = new google.maps.Marker({
				position: point1,
				animation: google.maps.Animation.DROP
			});
			var marker2 = new google.maps.Marker({
				position: point2,
				animation: google.maps.Animation.DROP
			});
			var request = {
				origin:point1,
				destination:point2,
				travelMode: google.maps.TravelMode.DRIVING
			};
			var rad = radius * 1000;
			var lat1 = marker1.getPosition().lat();
			var lng1 = marker1.getPosition().lng();
			var lat2 = marker2.getPosition().lat();
			var lng2 = marker2.getPosition().lng();
			var rd;
			if (direction == "Driver") {
				direction = "Οδηγός";
				var options = {
					strokeColor: 'red',
					strokeOpacity: 0.8,
					strokeWeight: 2,
					fillColor: 'red',
					fillOpacity: 0.35,
					map: map,
					center: point2,
					radius: rad
				};
				rd = '<u><b>Eμβέλεια αποβίβασης</b></u>' + '<br>' + radius;
			}
			else {
				direction = "Συνεπιβάτης";
				var options = {
					strokeColor: 'blue',
					strokeOpacity: 0.8,
					strokeWeight: 2,
					fillColor: 'blue',
					fillOpacity: 0.35,
					map: map,
					center: point2,
					radius: rad
				};
				rd = '<u><b>Eμβέλεια αποβίβασης</b></u>' + '<br>' + radius;
			}
			if (username == fullname) {
				var edit = '<a href="#" onclick="edit3('+ id +')" id="edit3">Επεξεργασία δρομολογίου</a>';
				var del  = '<a href="#" onclick="del3('+ id +', \''+direction+'\')" id="del3">Διαγραφή δρομολογίου</a>';
			}
			if (facebook == "" && status == "Active!" && username == fullname) {
				var txt = '<u><b>Όνομα Χρήστη</b></u>' + ': ' + '<a href="#" onclick="profil(\''+username+'\')" id="profil">'+username+'</a>' + '<br>' + '<u><b>Είμαι</b></u>' + ': ' + direction  + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Άτομα</b></u>' + ': ' + people + '<br>' + '<u><b>E-mail</b></u>' + ': ' + email + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + details + '<br>' + rd + ' χλμ' + '<br>' + '<br>' + '<div align="center"><a href="#" onclick="quote3('+ id +')" id="quote3">Επικοινώνησε μαζί μου</a></div>' + ' | ' + edit + ' | ' + del;
			}
			else if (facebook == "" && status == "Active!" && username != fullname) {
				var txt = '<u><b>Όνομα Χρήστη</b></u>' + ': ' + '<a href="#" onclick="profil(\''+username+'\')" id="profil">'+username+'</a>' + '<br>' + '<u><b>Είμαι</b></u>' + ': ' + direction  + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Άτομα</b></u>' + ': ' + people + '<br>' +'<u><b>E-mail</b></u>' + ': ' + email + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + details + '<br>' + rd + ' χλμ' + '<br>' + '<br>' + '<div align="center"><a href="#" onclick="quote3('+ id +')" id="quote3">Επικοινώνησε μαζί μου</a></div>';
			}
			else if (facebook != "" && status == "Inactive..." && username == fullname) {
				var txt = '<u><b>Όνομα Χρήστη</b></u>' + ': ' + '<a href="#" onclick="profil(\''+username+'\')" id="profil">'+username+'</a>' + '<br>' + '<u><b>Είμαι</b></u>' + ': ' + direction  + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Άτομα</b></u>' + ': ' + people + '<br>' +'<u><b>E-mail</b></u>' + ': ' + email + '<br>' + '<u><b>Facebook</b></u>' + ': ' + '<a href="http://www.facebook.com/'+facebook+'" target="_blank">'+facebook+'</a>' + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + details + '<br>' + rd + ' χλμ' + '<br><br><a href="#" onclick="quote3('+ id +')" id="quote3">Επικοινώνησε μαζί μου</a>' + ' | ' + edit + ' | ' + del;
			}
			else if (facebook != "" && status == "Inactive..." && username != fullname) {
				var txt = '<u><b>Όνομα Χρήστη</b></u>' + ': ' + '<a href="#" onclick="profil(\''+username+'\')" id="profil">'+username+'</a>' + '<br>' + '<u><b>Είμαι</b></u>' + ': ' + direction  + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Άτομα</b></u>' + ': ' + people + '<br>' +'<u><b>E-mail</b></u>' + ': ' + email + '<br>' + '<u><b>Facebook</b></u>' + ': ' + '<a href="http://www.facebook.com/'+facebook+'" target="_blank">'+facebook+'</a>' + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + details + '<br>' + rd + ' χλμ' + '<br><br><a href="#" onclick="quote3('+ id +')" id="quote3">Επικοινώνησε μαζί μου</a>';
			}
			else if (facebook == "" && status == "Inactive..." && username == fullname) {
				var txt = '<u><b>Όνομα Χρήστη</b></u>' + ': ' + '<a href="#" onclick="profil(\''+username+'\')" id="profil">'+username+'</a>' + '<br>' + '<u><b>Είμαι</b></u>' + ': ' + direction  + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Άτομα</b></u>' + ': ' + people + '<br>' +'<u><b>E-mail</b></u>' + ': ' + email + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + details + '<br>' + rd + ' χλμ' + '<br><br><a href="#" onclick="quote3('+ id +')" id="quote3">Επικοινώνησε μαζί μου</a>' + ' | ' + edit + ' | ' + del;
			}
			else if (facebook == "" && status == "Inactive..." && username != fullname) {
				var txt = '<u><b>Όνομα Χρήστη</b></u>' + ': ' + '<a href="#" onclick="profil(\''+username+'\')" id="profil">'+username+'</a>' + '<br>' + '<u><b>Είμαι</b></u>' + ': ' + direction  + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Άτομα</b></u>' + ': ' + people + '<br>' +'<u><b>E-mail</b></u>' + ': ' + email + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + details + '<br>' + rd + ' χλμ' + '<br><br><a href="#" onclick="quote3('+ id +')" id="quote3">Επικοινώνησε μαζί μου</a>';
			}
			else if (facebook != "" && status == "Active!" && username == fullname) {
				var txt = '<u><b>Όνομα Χρήστη</b></u>' + ': ' + '<a href="#" onclick="profil(\''+username+'\')" id="profil">'+username+'</a>' + '<br>' + '<u><b>Είμαι</b></u>' + ': ' + direction  + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Άτομα</b></u>' + ': ' + people + '<br>' +'<u><b>E-mail</b></u>' + ': ' + email + '<br>' + '<u><b>Facebook</b></u>' + ': ' + '<a href="http://www.facebook.com/'+facebook+'" target="_blank">'+facebook+'</a>' + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + details + '<br>' + rd + ' χλμ' + '<br><br>' + '<a href="#" onclick="quote3('+ id +')" id="quote3">Επικοινώνησε μαζί μου</a>' + ' | ' + edit + ' | ' + del;
			}
			else if (facebook != "" && status == "Active!" && username != fullname) {
				var txt = '<u><b>Όνομα Χρήστη</b></u>' + ': ' + '<a href="#" onclick="profil(\''+username+'\')" id="profil">'+username+'</a>' + '<br>' + '<u><b>Είμαι</b></u>' + ': ' + direction  + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Άτομα</b></u>' + ': ' + people + '<br>' +'<u><b>E-mail</b></u>' + ': ' + email + '<br>' + '<u><b>Facebook</b></u>' + ': ' + '<a href="http://www.facebook.com/'+facebook+'" target="_blank">'+facebook+'</a>' + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + details + '<br>' + rd + ' χλμ' + '<br><br>' + '<a href="#" onclick="quote3('+ id +')" id="quote3">Επικοινώνησε μαζί μου</a>';
			}
			if (everyday == "true") {
				txt = '<div style="font-size:8pt; font-weight:bold" align="center">*Αριστερό κλικ στο εικονίδιο για σχεδίαση διαδρομής</div><div style="font-weight:bold" align="center"><u><b>Καθημερινό δρομολόγιο</b></u></div>' + txt;
			}
			else {
				txt = '<div style="font-size:8pt; font-weight:bold" align="center">*Αριστερό κλικ στο εικονίδιο για σχεδίαση διαδρομής</div>' + txt;
			}
			if(direction == "Οδηγός") {
				directionsDisplay.setMap(null);
				marker1.setIcon("images/dd-start.png");
				marker2.setIcon("images/dd-end.png");
				Circle.setMap(null);
				google.maps.event.addListener(marker2,"mouseover", function() {
					Circle = new google.maps.Circle(options);
					InfoWindow.setContent(txt);
					InfoWindow.open(map,marker2);
				});
				google.maps.event.addListener(marker2,"mouseout", function() {
					Circle.setMap(null);
				});
				google.maps.event.addListener(marker2,"click", function() {
					InfoWindow.setContent(txt);
					InfoWindow.open(map,marker2);
					directionsService.route(request, function(response, status) {
						if (status == google.maps.DirectionsStatus.OK) {
							directionsDisplay.setDirections(response);
						}
					});
					directionsDisplay.setMap(map);
					marker1.setMap(map);
					for (var i=0; i<tmpmarkers.length; i++) {
						tmpmarkers[i].setMap(null);
					}
					state = 0;
					flag = 1;
				});
				marker2.setMap(map);
				show3markers.push(marker1);
				show4markers.push(marker2);
				google.maps.event.addListener(map,"click", function() {
					directionsDisplay.setMap(null);
					marker1.setMap(null);
					for (var i=0; i<show3markers.length; i++) {
						InfoWindow.close();
					}
					for (var i=0; i<show4markers.length; i++) {
						InfoWindow.close();
					}
				});
				return marker2;
			}
			else {
				directionsDisplay.setMap(null);
				marker1.setIcon("images/dd-start.png");
				marker2.setIcon("images/dd-end.png");
				Circle.setMap(null);
				google.maps.event.addListener(marker2,"mouseover", function() {
					Circle = new google.maps.Circle(options);
					InfoWindow.setContent(txt);
					InfoWindow.open(map,marker2);
				});
				google.maps.event.addListener(marker2,"mouseout", function() {
					Circle.setMap(null);
				});
				google.maps.event.addListener(marker2,"click", function() {
					InfoWindow.setContent(txt);
					InfoWindow.open(map,marker2);
					directionsService.route(request, function(response, status) {
						if (status == google.maps.DirectionsStatus.OK) {
							directionsDisplay.setDirections(response);
						}
					});
					directionsDisplay.setMap(map);
					marker1.setMap(map);
					for (var i=0; i<tmpmarkers.length; i++) {
						tmpmarkers[i].setMap(null);
					}
					state = 0;
					flag = 1;
				});
				marker2.setMap(map);
				show3markers.push(marker1);
				show4markers.push(marker2);
				google.maps.event.addListener(map,"click", function() {
					directionsDisplay.setMap(null);
					marker1.setMap(null);
					for (var i=0; i<show3markers.length; i++) {
						InfoWindow.close();
					}
					for (var i=0; i<show4markers.length; i++) {
						InfoWindow.close();
					}
				});
				return marker2;
			}
		}
		
		function profil(user) {
			downloadUrl("ldaputh.php?user=" +user, function(data) {
				var data = new XMLHttpRequest(); 
				data.open("GET", "ldaputh.php?user=" +user, false); 
				data.overrideMimeType("text/xml");
				data.send(null);
				var xml = data.responseXML;
				var usr = xml.documentElement.getElementsByTagName("user");
				for (var i = 0; i < usr.length; i++) {
					var uname = usr[i].getAttribute("uname");
					var name = usr[i].getAttribute("name");
					var affiliation = usr[i].getAttribute("affiliation");
					var unit = usr[i].getAttribute("unit");
				}
				if (affiliation == "student") {
					affiliation = "Φοιτητής";
				}
				else if (affiliation == "faculty") {
					affiliation = "Καθηγητικό σώμα";
				}
				else {
					affiliation = "Προσωπικό";
				}
				if (unit == "ou=ece") {
					unit = "Παιδαγωγικό Τμήμα Προσχολικής Εκπαίδευσης";
				}
				else if (unit == "ou=sed") {
					unit = "Παιδαγωγικό Τμήμα Ειδικής Αγωγής";
				}
				else if (unit == "ou=ha") {
					unit = "Τμήμα Ιστορίας, Αρχαιολογίας και Κοινωνικής Ανθρωπολογίας";
				}
				else if (unit == "ou=econ") {
					unit = "Τμήμα Οικονομικών Επιστημών";
				}
				else if (unit == "ou=agr") {
					unit = "Τμήμα Γεωπονίας Φυτικής Παραγωγής και Αγροτικού Περιβάλλοντος";
				}
				else if (unit == "ou=apae") {
					unit = "Τμήμα Γεωπονίας Ιχθυολογίας & Υδάτινου Περιβάλλοντος";
				}
				else if (unit == "ou=mie") {
					unit = "Τμήμα Μηχανολόγων Μηχανικών";
				}
				else if (unit == "ou=prd") {
					unit = "Τμήμα Μηχανικών Χωροταξίας, Πολεοδομίας και Περιφερειακής Ανάπτυξης";
				}
				else if (unit == "ou=civ") {
					unit = "Τμήμα Πολιτικών Μηχανικών";
				}
				else if (unit == "ou=arch") {
					unit = "Τμήμα Αρχιτεκτονικής";
				}
				else if (unit == "ou=inf") {
					unit = "Τμήμα Ηλεκτρολόγων Μηχανικών και Μηχανικών Υπολογιστών";
				}
				else if (unit == "ou=med") {
					unit = "Τμήμα Ιατρικής";
				}
				else if (unit == "ou=vet") {
					unit = "Τμήμα Κτηνιατρικής";
				}
				else if (unit == "ou=bio") {
					unit = "Τμήμα Βιοχημεία και Βιοτεχνολογίας";
				}
				else if (unit == "ou=cs") {
					unit = "Τμήμα Πληροφορικής";
				}
				else if (unit == "ou=dib") {
					unit = "Τμήμα Πληροφορικής με εφαρμογές στη Βιοϊατρική";
				}
				else if (unit == "ou=pe") {
					unit = "Τμήμα Επιστήμης Φυσικής Αγωγής και Αθλητισμού";
				}
				else if (unit == "ou=pre") {
					unit = "Παιδαγωγικό Τμήμα Δημοτικής Εκπαίδευσης";
				}
				var uth_user = "<b>Όνομα χρήστη</b>: " + uname + "<br>" + "<b>Ονοματεπώνυμο</b>: " + name + "<br>" + "<b>Απασχόληση</b>: " + affiliation + "<br>" + "<b>Σχολή</b>: " + unit;
				$("#recent_posts span").html(uth_user);
			});
			uth_user();
			function downloadUrl(url, callback) {
				var request = window.ActiveXObject ?
				new ActiveXObject('Microsoft.XMLHTTP') :
				new XMLHttpRequest;
				request.onreadystatechange = function() {
					if (request.readyState == 4) {
						request.onreadystatechange = doNothing;
						callback(request, request.status);
					}
				};
				request.open('GET', url, true);
				request.send(null);
			}
			function doNothing() {}
		}
		
		function uth_user() {
			$("#recent_posts").fadeIn(10);
			$("#help").fadeOut(10);
			$("#admin").fadeOut(10);
			$("#face").fadeOut(10);
			return false;
		}
		
		function quote1(driver_id) {
			downloadUrl("php/quote1.php?driver_id=" +driver_id, function(data) {
				var data = new XMLHttpRequest(); 
				data.open("GET", "php/quote1.php?driver_id=" +driver_id, false); 
				data.overrideMimeType("text/xml");
				data.send(null);
				var xml = data.responseXML;
				var quotes = xml.documentElement.getElementsByTagName("quote");
				for (var i = 0; i < quotes.length; i++) {
					var q = quotes[i].getAttribute("email");
				}
				var email =   ' <form id="visitor_details" method="post">'
				  + '   <fieldset>'
				  + '   <legend>Επικοινωνία με τον οδηγό</legend>'
				  + '   <label for="p_email" style="padding-left:3px;">Email οδηγού:</label>'
				  + '   <input disabled type="text" size="30" name="p_email" value="'+q+'"/><br>'
				  + '   <label for="y_email" style="padding-left:3px;">Το email σου:</label>'
				  + '   <input disabled type="text" size="30" name="y_email" value="'+useremail+'"/><br>'
				  + '   <label for="y_details" style="padding-left:3px;">Σχόλια:</label>'
				  + '   <textarea name="y_details" rows="3" cols="40"></textarea><br><br>'
				  + '   <button type="button" name="submit" onclick="email('+driver_id+'); return false">Αποστολή</button>'
				  + ' 	</fieldset>'
				  + ' </form>'
				InfoWindow.setContent(email);
			});
			function downloadUrl(url, callback) {
				var request = window.ActiveXObject ?
				new ActiveXObject('Microsoft.XMLHTTP') :
				new XMLHttpRequest;

				request.onreadystatechange = function() {
					if (request.readyState == 4) {
						request.onreadystatechange = doNothing;
						callback(request, request.status);
					}
				};
				request.open('GET', url, true);
				request.send(null);
			}
			function doNothing() {}						
		}
		
		function quote2(passenger_id) {
			downloadUrl("php/quote2.php?passenger_id=" +passenger_id, function(data) {
				var data = new XMLHttpRequest(); 
				data.open("GET", "php/quote2.php?passenger_id=" +passenger_id, false); 
				data.overrideMimeType("text/xml");
				data.send(null);
				var xml = data.responseXML;
				var quotes = xml.documentElement.getElementsByTagName("quote");
				for (var i = 0; i < quotes.length; i++) {
					var q = quotes[i].getAttribute("email");
				}
				var email =   ' <form id="visitor_details" method="post">'
				  + '   <fieldset>'
				  + '   <legend>Επικοινωνία με το συνεπιβάτη</legend>'
				  + '   <label for="p_email" style="padding-left:3px;">Email συνεπιβάτη:</label>'
				  + '   <input disabled type="text" size="30" name="p_email" value="'+q+'"/><br>'
				  + '   <label for="y_email" style="padding-left:3px;">Το email σου:</label>'
				  + '   <input disabled type="text" size="30" name="y_email" value="'+useremail+'"/><br>'
				  + '   <label for="y_details" style="padding-left:3px;">Σχόλια:</label>'
				  + '   <textarea name="y_details" rows="3" cols="40"></textarea><br><br>'
				  + '   <button type="button" name="submit" onclick="email('+passenger_id+'); return false">Send</button>'
				  + ' 	</fieldset>'
				  + ' </form>'
				InfoWindow.setContent(email);
			});
			function downloadUrl(url, callback) {
				var request = window.ActiveXObject ?
				new ActiveXObject('Microsoft.XMLHTTP') :
				new XMLHttpRequest;
				request.onreadystatechange = function() {
					if (request.readyState == 4) {
						request.onreadystatechange = doNothing;
						callback(request, request.status);
					}
				};
				request.open('GET', url, true);
				request.send(null);
			}
			function doNothing() {}						
		}
		
		function quote3(id) {
			downloadUrl("php/quote3.php?id=" +id, function(data) {
				var data = new XMLHttpRequest(); 
				data.open("GET", "php/quote3.php?id=" +id, false); 
				data.overrideMimeType("text/xml");
				data.send(null);
				var xml = data.responseXML;
				var quotes = xml.documentElement.getElementsByTagName("quote");
				for (var i = 0; i < quotes.length; i++) {
					var q = quotes[i].getAttribute("email");
				}
				var email =   ' <form id="visitor_details" method="post">'
				  + '   <fieldset>'
				  + '   <legend>Επικοινωνία με το συνεπιβάτη</legend>'
				  + '   <label for="p_email" style="padding-left:3px;">Email συνεπιβάτη:</label>'
				  + '   <input disabled type="text" size="30" name="p_email" value="'+q+'"/><br>'
				  + '   <label for="y_email" style="padding-left:3px;">Το email σου:</label>'
				  + '   <input disabled type="text" size="30" name="y_email" value="'+useremail+'"/><br>'
				  + '   <label for="y_details" style="padding-left:3px;">Σχόλια:</label>'
				  + '   <textarea name="y_details" rows="3" cols="40"></textarea><br><br>'
				  + '   <button type="button" name="submit" onclick="email('+id+'); return false">Send</button>'
				  + ' 	</fieldset>'
				  + ' </form>'
				InfoWindow.setContent(email);
			});
			function downloadUrl(url, callback) {
				var request = window.ActiveXObject ?
				new ActiveXObject('Microsoft.XMLHTTP') :
				new XMLHttpRequest;
				request.onreadystatechange = function() {
					if (request.readyState == 4) {
						request.onreadystatechange = doNothing;
						callback(request, request.status);
					}
				};
				request.open('GET', url, true);
				request.send(null);
			}
			function doNothing() {}						
		}
		
		function edit1(driver_id) {
			var ed1 =   ' <form id="dr_details" method="post" action="php/process7.php">'
					  + '   <fieldset>'
					  + '   <legend>Επεξεργασία δρομολογίου</legend>'
					  + '   <label style="padding-left:3px;">Ημερομηνία/Ώρα αναχώρησης και αριθμός ατόμων:</label><br>'
				      + '	<input type="date" name="ddate" maxlength="21" size="21" id="driver_date" value="ΕΕΕΕ-MM-ΗΗ"><br>'
					  + '	<select name="hour">'
				      + '	<option selected value="sel3"> - Ώρα (+|- 30 λεπτά) - </option>'
					  + ' 	<option value="00:00">00:00'
				      + ' 	<option value="01:00">01:00'
				      + ' 	<option value="02:00">02:00'
				      + ' 	<option value="03:00">03:00'
					  + ' 	<option value="04:00">04:00'
				      + ' 	<option value="05:00">05:00'
				      + ' 	<option value="06:00">06:00'
					  + ' 	<option value="07:00">07:00'
				      + ' 	<option value="08:00">08:00'
				      + ' 	<option value="09:00">09:00'
					  + ' 	<option value="10:00">10:00'
				      + ' 	<option value="11:00">11:00'
					  + ' 	<option value="12:00">12:00'
					  + ' 	<option value="13:00">13:00'
				      + ' 	<option value="14:00">14:00'
				      + ' 	<option value="15:00">15:00'
					  + ' 	<option value="16:00">16:00'
				      + ' 	<option value="17:00">17:00'
				      + ' 	<option value="18:00">18:00'
					  + ' 	<option value="19:00">19:00'
				      + ' 	<option value="20:00">20:00'
				      + ' 	<option value="21:00">21:00'
					  + ' 	<option value="22:00">22:00'
				      + ' 	<option value="23:00">23:00'
					  + '	</select>'
					  + '	<select name="people">'
				      + '	<option selected value="choice"> - Άτομα - </option>'
				      + ' 	<option value="1">1'
				      + ' 	<option value="2">2'
				      + ' 	<option value="3">3'
					  + '	</select><br>'
					  + '   <label for="details" style="padding-left:3px;">Λεπτομέρειες (καπνιστής/μη καπνιστής, τηλέφωνο):</label>'
				      + '   <textarea name="details" rows="3" cols="40"></textarea><br><br>'
					  + '	<select name="radius">'
				      + '	<option selected value="choice3"> - Αποδεκτή εμβέλεια επιβίβασης / αποβίβασης - </option>'
				      + ' 	<option value="1">1 χλμ'
				      + ' 	<option value="2">2 χλμ'
				      + ' 	<option value="3">3 χλμ'
					  + ' 	<option value="4">4 χλμ'
					  + ' 	<option value="5">5 χλμ'
					  + '	</select><br><br>'
					  + '   <button type="button" name="submit" onclick="process5('+ driver_id +',ddate.value,hour.value,people.value,form.details.value,radius.value); return false">Καταχώρηση</button>'
					  + ' 	</fieldset>'
				      + ' </form>'
			InfoWindow.setContent(ed1);
		}
		
		function process5 (driver_id,ddate,hour,people,details,radius) {
			var errors = '';
			var ddate = $("#dr_details [name='ddate']").val();
		    if ((ddate == "ΕΕΕΕ-MM-ΗΗ") || (ddate == "")) {
				errors += '- Παρακαλούμε επιλέξτε ημερομηνία αναχώρησης\n';
		    }
			var hour = $("#dr_details [name='hour']").val();
		    if (hour == "sel3") {
				errors += '- Παρακαλούμε επιλέξτε ώρα αναχώρησης\n';
		    }
			var people = $("#dr_details [name='people']").val();
		    if (people == "choice") {
				errors += '- Παρακαλούμε επιλέξτε τον αριθμό των ατόμων που μπορείτε να πάρετε μαζί σας\n';
		    }
			var details = $("#dr_details [name='details']").val();
		    if (!details) {
				errors += '- Παρακαλούμε συμπληρώστε λεπτομέρειες\n';
		    }	
			var radius = $("#dr_details [name='radius']").val();
		    if (radius == "choice3") {
				errors += '- Παρακαλούμε επιλέξτε εμβέλεια\n';
		    }
			if (errors) {
				errors = 'Διαπιστώθηκαν τα παρακάτω σφάλματα: \n' + errors;
				alert(errors);
				return false;
			}
			else {
				var url = "php/process7.php?driver_id=" +driver_id+ "&ddate=" +ddate+ "&hour=" +hour+ "&people=" +people+ "&details=" +details+ "&radius=" +radius;
				$.ajax({
					url: url,
					type: "POST",
					dataType: 'json',
					success: function(){
						showResult7("ok");
					}
				});
				InfoWindow.close();
				routes1();
			}
		}
		
		function edit2(passenger_id) {
			var ed2 =   ' <form id="pass_details" method="post" action="php/process8.php">'
					  + '   <fieldset>'
					  + '   <legend>Επεξεργασία δρομολογίου</legend>'
					  + '   <label style="padding-left:3px;">Ημερομηνία/Ώρα αναχώρησης και αριθμός ατόμων:</label><br>'
				      + '	<input type="date" name="ddate" maxlength="21" size="21" id="passenger_date" value="ΕΕΕΕ-MM-ΗΗ"><br>'
					  + '	<select name="hour">'
				      + '	<option selected value="sel3"> - Ώρα (+|- 30 λεπτά) - </option>'
					  + ' 	<option value="00:00">00:00'
				      + ' 	<option value="01:00">01:00'
				      + ' 	<option value="02:00">02:00'
				      + ' 	<option value="03:00">03:00'
					  + ' 	<option value="04:00">04:00'
				      + ' 	<option value="05:00">05:00'
				      + ' 	<option value="06:00">06:00'
					  + ' 	<option value="07:00">07:00'
				      + ' 	<option value="08:00">08:00'
				      + ' 	<option value="09:00">09:00'
					  + ' 	<option value="10:00">10:00'
				      + ' 	<option value="11:00">11:00'
					  + ' 	<option value="12:00">12:00'
					  + ' 	<option value="13:00">13:00'
				      + ' 	<option value="14:00">14:00'
				      + ' 	<option value="15:00">15:00'
					  + ' 	<option value="16:00">16:00'
				      + ' 	<option value="17:00">17:00'
				      + ' 	<option value="18:00">18:00'
					  + ' 	<option value="19:00">19:00'
				      + ' 	<option value="20:00">20:00'
				      + ' 	<option value="21:00">21:00'
					  + ' 	<option value="22:00">22:00'
				      + ' 	<option value="23:00">23:00'
					  + '	</select>'
					  + '	<select name="people">'
				      + '	<option selected value="choice"> - Άτομα - </option>'
				      + ' 	<option value="1">1'
				      + ' 	<option value="2">2'
				      + ' 	<option value="3">3'
					  + '	</select><br>'
					  + '   <label for="details" style="padding-left:3px;">Σχόλια (καπνιστής / μη καπνιστής, τηλέφωνο):</label>'
				      + '   <textarea name="details" rows="3" cols="40"></textarea><br><br>'
					  + '	<select name="radius">'
				      + '	<option selected value="choice3"> - Αποδεκτή εμβέλεια επιβίβασης / αποβίβασης - </option>'
				      + ' 	<option value="1">1 χλμ'
				      + ' 	<option value="2">2 χλμ'
				      + ' 	<option value="3">3 χλμ'
					  + ' 	<option value="4">4 χλμ'
					  + ' 	<option value="5">5 χλμ'
					  + '	</select><br><br>'
					  + '   <button type="button" name="submit" onclick="process6('+ passenger_id +',ddate.value,hour.value,people.value,form.details.value,radius.value); return false">Καταχώρηση</button>'
					  + ' 	</fieldset>'
				      + ' </form>'
			InfoWindow.setContent(ed2);		
		}
		
		function edit3(id) {
			var ed3 =   ' <form id="in_details2" method="post" action="php/process11.php">'
				  + '   <fieldset>'
				  + '   <legend>Επεξεργασία δρομολογίου</legend>'
				  + '   <label style="padding-left:3px;">Ημερομηνία/Ώρα αναχώρησης και αριθμός ατόμων:</label><br>'
				  + '	<input type="date" name="ddate" maxlength="21" size="21" id="driver_date" value="ΕΕΕΕ-MM-ΗΗ"><br>'
				  + '	<select name="hour">'
				  + '	<option selected value="sel3"> - Ώρα (+|- 30 λεπτά) - </option>'
				  + ' 	<option value="00:00">00:00'
				  + ' 	<option value="01:00">01:00'
				  + ' 	<option value="02:00">02:00'
				  + ' 	<option value="03:00">03:00'
				  + ' 	<option value="04:00">04:00'
				  + ' 	<option value="05:00">05:00'
				  + ' 	<option value="06:00">06:00'
				  + ' 	<option value="07:00">07:00'
				  + ' 	<option value="08:00">08:00'
				  + ' 	<option value="09:00">09:00'
				  + ' 	<option value="10:00">10:00'
				  + ' 	<option value="11:00">11:00'
				  + ' 	<option value="12:00">12:00'
				  + ' 	<option value="13:00">13:00'
				  + ' 	<option value="14:00">14:00'
				  + ' 	<option value="15:00">15:00'
				  + ' 	<option value="16:00">16:00'
				  + ' 	<option value="17:00">17:00'
				  + ' 	<option value="18:00">18:00'
				  + ' 	<option value="19:00">19:00'
				  + ' 	<option value="20:00">20:00'
				  + ' 	<option value="21:00">21:00'
				  + ' 	<option value="22:00">22:00'
				  + ' 	<option value="23:00">23:00'
				  + '	</select>'
				  + '	<select name="people">'
				  + '	<option selected value="choice"> - Άτομα - </option>'
				  + ' 	<option value="1">1'
				  + ' 	<option value="2">2'
				  + ' 	<option value="3">3'
				  + '	</select>'
				  + ' 	<select name="direction">'
				  + '	<option selected value="choice2"> - Είμαι - </option>'
				  + ' 	<option value="Driver">Οδηγός'
				  + ' 	<option value="Passenger">Συνεπιβάτης'
				  + '	</select><br>'
				  + '   <label><input type="checkbox" id="amea_box" name="amea_box">Καθημερινό δρομολόγιο</label>'
				  + '   <label for="details" style="padding-left:3px;">Λεπτομέρειες (καπνιστής/μη καπνιστής, τηλέφωνο):</label>'
				  + '   <textarea name="details" rows="3" cols="40"></textarea><br><br>'
				  + '	<select name="radius">'
				  + '	<option selected value="choice3"> - Αποδεκτή εμβέλεια επιβίβασης / αποβίβασης - </option>'
				  + ' 	<option value="0.1">100 μ'
				  + ' 	<option value="0.2">200 μ'
				  + ' 	<option value="0.3">300 μ'
				  + ' 	<option value="0.4">400 μ'
				  + ' 	<option value="0.5">500 μ'
				  + '	</select><br><br>'
				  + '   <button type="button" name="submit" onclick="process11('+ id +',ddate.value,hour.value,amea_box.value,people.value,form.details.value,radius.value,direction.value); return false">Καταχώρηση</button>'
				  + ' 	</fieldset>'
				  + ' </form>'
					  
			InfoWindow.setContent(ed3);		
		}
		
		function edit2(passenger_id) {
			var ed2 =   ' <form id="pass_details" method="post" action="php/process8.php">'
					  + '   <fieldset>'
					  + '   <legend>Επεξεργασία δρομολογίου</legend>'
					  + '   <label style="padding-left:3px;">Ημερομηνία/Ώρα αναχώρησης και αριθμός ατόμων:</label><br>'
				      + '	<input type="date" name="ddate" maxlength="21" size="21" id="passenger_date" value="ΕΕΕΕ-MM-ΗΗ"><br>'
					  + '	<select name="hour">'
				      + '	<option selected value="sel3"> - Ώρα (+|- 30 λεπτά) - </option>'
					  + ' 	<option value="00:00">00:00'
				      + ' 	<option value="01:00">01:00'
				      + ' 	<option value="02:00">02:00'
				      + ' 	<option value="03:00">03:00'
					  + ' 	<option value="04:00">04:00'
				      + ' 	<option value="05:00">05:00'
				      + ' 	<option value="06:00">06:00'
					  + ' 	<option value="07:00">07:00'
				      + ' 	<option value="08:00">08:00'
				      + ' 	<option value="09:00">09:00'
					  + ' 	<option value="10:00">10:00'
				      + ' 	<option value="11:00">11:00'
					  + ' 	<option value="12:00">12:00'
					  + ' 	<option value="13:00">13:00'
				      + ' 	<option value="14:00">14:00'
				      + ' 	<option value="15:00">15:00'
					  + ' 	<option value="16:00">16:00'
				      + ' 	<option value="17:00">17:00'
				      + ' 	<option value="18:00">18:00'
					  + ' 	<option value="19:00">19:00'
				      + ' 	<option value="20:00">20:00'
				      + ' 	<option value="21:00">21:00'
					  + ' 	<option value="22:00">22:00'
				      + ' 	<option value="23:00">23:00'
					  + '	</select>'
					  + '	<select name="people">'
				      + '	<option selected value="choice"> - Άτομα - </option>'
				      + ' 	<option value="1">1'
				      + ' 	<option value="2">2'
				      + ' 	<option value="3">3'
					  + '	</select><br>'
					  + '   <label for="details" style="padding-left:3px;">Σχόλια (καπνιστής / μη καπνιστής, τηλέφωνο):</label>'
				      + '   <textarea name="details" rows="3" cols="40"></textarea><br><br>'
					  + '	<select name="radius">'
				      + '	<option selected value="choice3"> - Αποδεκτή εμβέλεια επιβίβασης / αποβίβασης - </option>'
				      + ' 	<option value="1">1 χλμ'
				      + ' 	<option value="2">2 χλμ'
				      + ' 	<option value="3">3 χλμ'
					  + ' 	<option value="4">4 χλμ'
					  + ' 	<option value="5">5 χλμ'
					  + '	</select><br><br>'
					  + '   <button type="button" name="submit" onclick="process6('+ passenger_id +',ddate.value,hour.value,people.value,form.details.value,radius.value); return false">Καταχώρηση</button>'
					  + ' 	</fieldset>'
				      + ' </form>'
			InfoWindow.setContent(ed2);		
		}
		
		function process6(passenger_id,ddate,hour,people,details,radius) {
			var errors = '';
			var ddate = $("#pass_details [name='ddate']").val();
		    if ((ddate == "ΕΕΕΕ-MM-ΗΗ") || (ddate == "")) {
				errors += '- Παρακαλούμε επιλέξτε ημερομηνία αναχώρησης\n';
		    }
			var hour = $("#pass_details [name='hour']").val();
		    if (hour == "sel3") {
				errors += '- Παρακαλούμε επιλέξτε ώρα αναχώρησης\n';
		    }
			var people = $("#pass_details [name='people']").val();
		    if (people == "choice") {
				errors += '- Παρακαλούμε επιλέξτε πόσα άτομα είστε\n';
		    }
			var details = $("#pass_details [name='details']").val();
		    if (!details) {
				errors += '- Παρακαλούμε συμπληρώστε λεπτομέρειες\n';
		    }	
			var radius = $("#pass_details [name='radius']").val();
		    if (radius == "choice3") {
				errors += '- Παρακαλούμε επιλέξτε εμβέλεια\n';
		    }
			if (errors) {
				errors = 'Διαπιστώθηκαν τα παρακάτω σφάλματα: \n' + errors;
				alert(errors);
				return false;
			}
			else {
				var url = "php/process8.php?passenger_id=" +passenger_id+ "&ddate=" +ddate+ "&hour=" +hour+ "&people=" +people+ "&details=" +details+ "&radius=" +radius;
				$.ajax({
					url: url,
					type: "POST",
					dataType: 'json',
					success: function(){
						showResult8("ok");
					}
				});
				InfoWindow.close();
				routes2();
			}
		}
		
		function del1(driver_id) {
			var url = "php/del1.php?driver_id=" +driver_id;
			$.ajax({
				url: url,
				type: "POST",
				dataType: 'json',
				success: function(){
					showResult9("ok");
				}
			});
			for (var i=0; i<tmpmarkers.length; i++) {
				tmpmarkers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<show1markers.length; i++) {
				show1markers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<show2markers.length; i++) {
				show2markers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<drivermarkers.length; i++) {
				drivermarkers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<passengermarkers.length; i++) {
				passengermarkers[i].setVisible(false);
				InfoWindow.close();
			}
			InfoWindow.close();
			routes1();
			InfoWindow.close();
		}
		
		function del2(passenger_id) {
			var url = "php/del2.php?passenger_id=" +passenger_id;
			$.ajax({
				url: url,
				type: "POST",
				dataType: 'json',
				success: function(){
					showResult9("ok");
				}
			});
			for (var i=0; i<tmpmarkers.length; i++) {
				tmpmarkers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<show1markers.length; i++) {
				show1markers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<show2markers.length; i++) {
				show2markers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<drivermarkers.length; i++) {
				drivermarkers[i].setVisible(false);
				InfoWindow.close();
			}
			for (var i=0; i<passengermarkers.length; i++) {
				passengermarkers[i].setVisible(false);
				InfoWindow.close();
			}
			InfoWindow.close();
			routes2();
			InfoWindow.close();
		}
		
		function del3(id, direction) {
			if (direction == "Οδηγός") {
				direction = "Driver";
			}
			else if (direction == "Συνεπιβάτης") {
				direction = "Passenger";
			}
			var url = "php/del3.php?id=" +id;
			$.ajax({
				url: url,
				type: "POST",
				dataType: 'json',
				success: function(){
					alert("OK!");
				}
			});
			InfoWindow.close();
			tmpInfoWindow.close();
			map.setZoom(14);
			load12(map,direction);
			state = 0;
			path = [];
			directionsDisplay.setMap(null);
			inInfoWindow.close();
		}
		
		function email(id) {
			var errors = '';
			var details = jQuery("#visitor_details [name='y_details']").val();
			if (!details) {
				errors += ' - Παρακαλούμε συμπληρώστε τα σχόλια σας\n';
			}
			var q = jQuery("#visitor_details [name='p_email']").val();
			var email = jQuery("#visitor_details [name='y_email']").val();
			if (errors) {
				errors = ' Διαπιστώθηκαν τα παρακάτω σφάλματα: \n' + errors;
				alert(errors);
				return false;
			}
			else {
				var url = "php/email.php?details=" +details+ "&q=" +q+ "&email=" +email;
				jQuery.ajax({
					url: url,
					type: "POST",
					dataType: 'json',
					success: function(){
					}
				});
				InfoWindow.close();
			}
		}
		
		function routes1() {
			downloadUrl("php/emfanishmarkers5.php?useremail=" +useremail, function(data) {
				var data = new XMLHttpRequest(); 
				data.open("GET", "php/emfanishmarkers5.php?useremail=" +useremail, false); 
				data.overrideMimeType("text/xml");
				data.send(null);
				var xml = data.responseXML;
				var markers = xml.documentElement.getElementsByTagName("marker");
				for (var i = 0; i < markers.length; i++) {
					var driver_id = markers[i].getAttribute("driver_id");
					var name = markers[i].getAttribute("name");
					var username = markers[i].getAttribute("username");
					var email = markers[i].getAttribute("email");
					var facebook = markers[i].getAttribute("facebook");
					var ddate = markers[i].getAttribute("ddate");
					var hour = markers[i].getAttribute("hour");
					var people = markers[i].getAttribute("people");
					var direction = markers[i].getAttribute("direction");
					var details = markers[i].getAttribute("details");
					var point = new google.maps.LatLng(
						parseFloat(markers[i].getAttribute("lat")),
						parseFloat(markers[i].getAttribute("lng")));
					var status = markers[i].getAttribute("status");
					var distance = markers[i].getAttribute("distance");
					var duration = markers[i].getAttribute("duration");
					var radius = markers[i].getAttribute("radius");
					var p_username = markers[i].getAttribute("p_username");
					var p_email = markers[i].getAttribute("p_email");
					var p_facebook = markers[i].getAttribute("p_facebook");
					var p_details = markers[i].getAttribute("p_details");
					var marker = createMarker3(driver_id,name,username,email,facebook,ddate,hour,people,details,point,status,distance,duration,radius,p_username,p_email,p_facebook,p_details,direction);
					google.maps.event.trigger(marker,"click");
				}
				InfoWindow.close();
				directionsDisplay.setMap(null);
			});
			function downloadUrl(url, callback) {
				var request = window.ActiveXObject ?
				new ActiveXObject('Microsoft.XMLHTTP') :
				new XMLHttpRequest;
				request.onreadystatechange = function() {
					if (request.readyState == 4) {
						request.onreadystatechange = doNothing;
						callback(request, request.status);
					}
				};
				request.open('GET', url, true);
				request.send(null);
			}
			function doNothing() {}
		}
		
		function routes2() {
			downloadUrl("php/emfanishmarkers6.php?useremail=" +useremail, function(data) {
				var data = new XMLHttpRequest(); 
				data.open("GET", "php/emfanishmarkers6.php?useremail=" +useremail, false); 
				data.overrideMimeType("text/xml");
				data.send(null);
				var xml = data.responseXML;
				var markers = xml.documentElement.getElementsByTagName("marker");
				for (var i = 0; i < markers.length; i++) {
					var passenger_id = markers[i].getAttribute("passenger_id");
					var name = markers[i].getAttribute("name");
					var username = markers[i].getAttribute("username");
					var email = markers[i].getAttribute("email");
					var facebook = markers[i].getAttribute("facebook");
					var ddate = markers[i].getAttribute("ddate");
					var hour = markers[i].getAttribute("hour");
					var people = markers[i].getAttribute("people");
					var direction = markers[i].getAttribute("direction");
					var details = markers[i].getAttribute("details");
					var point = new google.maps.LatLng(
						parseFloat(markers[i].getAttribute("lat")),
						parseFloat(markers[i].getAttribute("lng")));
					var status = markers[i].getAttribute("status");
					var distance = markers[i].getAttribute("distance");
					var duration = markers[i].getAttribute("duration");
					var radius = markers[i].getAttribute("radius");
					var d_username = markers[i].getAttribute("d_username");
					var d_email = markers[i].getAttribute("d_email");
					var d_facebook = markers[i].getAttribute("d_facebook");
					var d_details = markers[i].getAttribute("d_details");
					var marker = createMarker4(passenger_id,name,username,email,facebook,ddate,hour,people,details,point,status,distance,duration,radius,d_username,d_email,d_facebook,d_details,direction);
					google.maps.event.trigger(marker,"click");
				}
				InfoWindow.close();
				directionsDisplay.setMap(null);
			});
			function downloadUrl(url, callback) {
				var request = window.ActiveXObject ?
				new ActiveXObject('Microsoft.XMLHTTP') :
				new XMLHttpRequest;
				request.onreadystatechange = function() {
					if (request.readyState == 4) {
						request.onreadystatechange = doNothing;
						callback(request, request.status);
					}
				};
				request.open('GET', url, true);
				request.send(null);
			}
			function doNothing() {}
		}
		
		function routes3() {
			downloadUrl("php/emfanishmarkers7.php?useremail=" +useremail, function(data) {
				var data = new XMLHttpRequest(); 
				data.open("GET", "php/emfanishmarkers7.php?useremail=" +useremail, false); 
				data.overrideMimeType("text/xml");
				data.send(null);
				var xml = data.responseXML;
				var markers = xml.documentElement.getElementsByTagName("marker");
				for (var i = 0; i < markers.length; i++) {
					var id = markers[i].getAttribute("id");
					var username = markers[i].getAttribute("username");
					var email = markers[i].getAttribute("email");
					var facebook = markers[i].getAttribute("facebook");
					var ddate = markers[i].getAttribute("ddate");
					var hour = markers[i].getAttribute("hour");
					var people = markers[i].getAttribute("people");
					var direction = markers[i].getAttribute("direction");
					var details = markers[i].getAttribute("details");
					var point1 = new google.maps.LatLng(
						parseFloat(markers[i].getAttribute("lat1")),
						parseFloat(markers[i].getAttribute("lng1")));
					var point2 = new google.maps.LatLng(
						parseFloat(markers[i].getAttribute("lat2")),
						parseFloat(markers[i].getAttribute("lng2")));
					var status = markers[i].getAttribute("status");
					var radius = markers[i].getAttribute("radius");
					var name = markers[i].getAttribute("name");
					var everyday = markers[i].getAttribute("everyday");
					var marker = createMarker5(id,username,email,facebook,ddate,hour,people,direction,details,point1,point2,status,radius,name,everyday);
					google.maps.event.trigger(marker,"click");
				}
				InfoWindow.close();
				directionsDisplay.setMap(null);
				for (var i=0; i<show3markers.length; i++) {
					show3markers[i].setMap(null);
				}
			});
			function downloadUrl(url, callback) {
				var request = window.ActiveXObject ?
				new ActiveXObject('Microsoft.XMLHTTP') :
				new XMLHttpRequest;
				request.onreadystatechange = function() {
					if (request.readyState == 4) {
						request.onreadystatechange = doNothing;
						callback(request, request.status);
					}
				};
				request.open('GET', url, true);
				request.send(null);
			}
			function doNothing() {}
		}
		
		function load1() {
			show1markers = [];
			show2markers = [];
			downloadUrl("php/emfanishmarkers2.php", function(data) {
				var data = new XMLHttpRequest(); 
				data.open("GET", "php/emfanishmarkers2.php", false); 
				data.overrideMimeType("text/xml");
				data.send(null);
				var xml = data.responseXML;
				var markers = xml.documentElement.getElementsByTagName("marker");
				for (var i = 0; i < markers.length; i++) {
					var passenger_id = markers[i].getAttribute("passenger_id");
					var name = markers[i].getAttribute("name");
					var username = markers[i].getAttribute("username");
					var email = markers[i].getAttribute("email");
					var facebook = markers[i].getAttribute("facebook");
					var ddate = markers[i].getAttribute("ddate");
					var hour = markers[i].getAttribute("hour");
					var people = markers[i].getAttribute("people");
					var direction = markers[i].getAttribute("direction");
					var details = markers[i].getAttribute("details");
					var point = new google.maps.LatLng(
						parseFloat(markers[i].getAttribute("lat")),
						parseFloat(markers[i].getAttribute("lng")));
					var status = markers[i].getAttribute("status");
					var distance = markers[i].getAttribute("distance");
					var duration = markers[i].getAttribute("duration");
					var radius = markers[i].getAttribute("radius");
					var d_username = markers[i].getAttribute("d_username");
					var d_email = markers[i].getAttribute("d_email");
					var d_facebook = markers[i].getAttribute("d_facebook");
					var d_details = markers[i].getAttribute("d_details");
					var marker = createMarker4(passenger_id,name,username,email,facebook,ddate,hour,people,details,point,status,distance,duration,radius,d_username,d_email,d_facebook,d_details,direction);
					google.maps.event.trigger(marker,"click");
				}
				InfoWindow.close();
				directionsDisplay.setMap(null);
			});
			function downloadUrl(url, callback) {
				var request = window.ActiveXObject ?
				new ActiveXObject('Microsoft.XMLHTTP') :
				new XMLHttpRequest;

				request.onreadystatechange = function() {
					if (request.readyState == 4) {
						request.onreadystatechange = doNothing;
						callback(request, request.status);
					}
				};
				request.open('GET', url, true);
				request.send(null);
			}
			function doNothing() {}
		}
		
		function load2() {
			show1markers = [];
			show2markers = [];
			downloadUrl("php/emfanishmarkers1.php", function(data) {
				var data = new XMLHttpRequest(); 
				data.open("GET", "php/emfanishmarkers1.php", false); 
				data.overrideMimeType("text/xml");
				data.send(null);
				var xml = data.responseXML;
				var markers = xml.documentElement.getElementsByTagName("marker");
				for (var i = 0; i < markers.length; i++) {
					var driver_id = markers[i].getAttribute("driver_id");
					var name = markers[i].getAttribute("name");
					var username = markers[i].getAttribute("username");
					var email = markers[i].getAttribute("email");
					var facebook = markers[i].getAttribute("facebook");
					var ddate = markers[i].getAttribute("ddate");
					var hour = markers[i].getAttribute("hour");
					var people = markers[i].getAttribute("people");
					var direction = markers[i].getAttribute("direction");
					var details = markers[i].getAttribute("details");
					var point = new google.maps.LatLng(
						parseFloat(markers[i].getAttribute("lat")),
						parseFloat(markers[i].getAttribute("lng")));
					var status = markers[i].getAttribute("status");
					var distance = markers[i].getAttribute("distance");
					var duration = markers[i].getAttribute("duration");
					var radius = markers[i].getAttribute("radius");
					var p_username = markers[i].getAttribute("p_username");
					var p_email = markers[i].getAttribute("p_email");
					var p_facebook = markers[i].getAttribute("p_facebook");
					var p_details = markers[i].getAttribute("p_details");
					var marker = createMarker3(driver_id,name,username,email,facebook,ddate,hour,people,details,point,status,distance,duration,radius,p_username,p_email,p_facebook,p_details,direction);
					google.maps.event.trigger(marker,"click");
				}
				InfoWindow.close();
				directionsDisplay.setMap(null);
			});
			function downloadUrl(url, callback) {
				var request = window.ActiveXObject ?
				new ActiveXObject('Microsoft.XMLHTTP') :
				new XMLHttpRequest;
				request.onreadystatechange = function() {
					if (request.readyState == 4) {
						request.onreadystatechange = doNothing;
						callback(request, request.status);
					}
				};
				request.open('GET', url, true);
				request.send(null);
			}
			function doNothing() {}
		}
		
	    var mapOptions = {
			center: new google.maps.LatLng(39.24528, 23.2144),
			zoom: 8,
			panControl: true,
			panControlOptions: {
				position: google.maps.ControlPosition.LEFT_CENTER
			},
			zoomControl: true,
			zoomControlOptions: {
				style: google.maps.ZoomControlStyle.SMALL,
				position: google.maps.ControlPosition.LEFT_CENTER
			},
			scaleControl: false,
			mapTypeControl: true,
			mapTypeControlOptions: {
				style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
				mapTypeIds: ['coordinate', google.maps.MapTypeId.ROADMAP],
			},
			streetViewControl: true,
			streetViewControlOptions: {
				position: google.maps.ControlPosition.LEFT_CENTER
			},
			overviewMapControl: true,
			disableDoubleClickZoom: true
		};
		map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
		jQuery('#drivers').hide();
		jQuery('#likes').show();
		jQuery('#passengers').hide();
		google.maps.event.addDomListener(window, "resize", function() {
			var center = map.getCenter();
			google.maps.event.trigger(map, "resize");
			map.setCenter(center); 
		});
		
		/*<![CDATA[*/
		(function(w2b){
			w2b(document).ready(function(){
				var $dur = "medium"; // Duration of Animation
				w2b("#drivers").hover(function () {
					w2b(this).stop().animate({
						bottom: 0
					}, $dur);
				}, function () {
					w2b(this).stop().animate({
						bottom: -189
					}, $dur);
				});
				
				w2b("#passengers").hover(function () {
					w2b(this).stop().animate({
						bottom: 0
					}, $dur);
				}, function () {
					w2b(this).stop().animate({
						bottom: -191
					}, $dur);
				});
				
				w2b("#likes").hover(function () {
					w2b(this).stop().animate({
						left: 0
					}, $dur);
				}, function () {
					w2b(this).stop().animate({
						left: -221
					}, $dur);
				});
			});
		})(jQuery);
		/*]]>*/
	</script>
  </body>
  <script type="text/javascript" src="js/form.js"></script>
  <script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	ga('create', 'UA-51253655-1', 'uth.gr');
	ga('send', 'pageview');
  </script>
  <!-- UserVoice JavaScript SDK (only needed once on a page) -->
  <script>(function(){var uv=document.createElement('script');uv.type='text/javascript';uv.async=true;uv.src='//widget.uservoice.com/3aquHIKiGXSXbY23EIQNQ.js';var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(uv,s)})()</script>
  <!-- A tab to launch the Classic Widget -->
  <script>
	UserVoice = window.UserVoice || [];
	UserVoice.push(['showTab', 'classic_widget', {
	  mode: 'full',
	  primary_color: '#cc6d00',
	  link_color: '#007dbf',
	  default_mode: 'feedback',
	  forum_id: 256753,
	  support_tab_name: 'Επικοινωνήστε μαζί μας',
	  feedback_tab_name: 'Πείτε μας την ιδέα σας',
	  tab_label: 'Σχόλια & Υποστήριξη',
	  tab_color: '#cc6d00',
	  tab_position: 'middle-right',
	  tab_inverted: false
	}]);
  </script>
</html>