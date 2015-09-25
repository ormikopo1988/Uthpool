<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>UthPool</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css"/>
	<script type="text/javascript"
		src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyBvJFVY3P3bwTflFzlBIU6pdPQjTqGpsNQ&sensor=false">
	</script>
	<script src="http://code.jquery.com/jquery-latest.js"></script>
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
			
			#help {
				background: none repeat scroll 0 0 rgba(0, 0, 0, 0.5);
				border-radius: 5px;
				color: #FFFFFF;
				display: none;
				height: 410px;
				padding: 9px;
				position: absolute;
				right: 10px;
				top: 27px;
				width: 575px;
				z-index: 100;
			}
			
			#help2 {
				background: none repeat scroll 0 0 rgba(0, 0, 0, 0.5);
				border-radius: 5px;
				color: #FFFFFF;
				display: none;
				height: 475px;
				padding: 9px;
				position: absolute;
				right: 10px;
				top: 27px;
				width: 575px;
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
		</style>
  </head>
  <body onload="load()">
    <div id="map-canvas"></div>
	<div id="login_button" style="display: block;">
		<table border="0">
			<tbody>
				<tr>
					<td width="954" valign="top" style="color: black;">
					<div class="basic_menu" style="text-decoration: none; padding-left: 0px; padding-top: 0px; color: black; font-weight: bold;">
					<form action="#">
						<span style="padding-left:63px">
						<input type="submit" value="" title="Βοήθεια" id="target3"
						style="font-family:sans-serif; font-size:12pt;
						font-weight:bold; background-image:url('images/help.gif'); none; color:white; width:1.3em">
						</SUBMIT>
						</span>
					</form>
					</div>
					</td>
				</tr>	
			</tbody>
			<tbody>
				<tr>
					<td width="200" valign="top" style="text-decoration: none; color: black;">
						<p align='center' id="nav">
						<a class="login" href="LoginPage.php">Είσοδος</a>
						</p>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
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
				<p style="color:white; font-weight:bold; text-align:center">Οδηγοί με αφετηρία το Βόλο και προορισμό την κορυφή του δείκτη</p>
			</td>
		  </tbody></tr>
		  <tbody><tr>
			<td>
				<div align="center">
					<img src="images/blue_Marker_new3.png"/>
				</div>
			</td>
			<td>
				<p style="color:white; font-weight:bold; text-align:center">Οδηγοί με προορισμό το Βόλο και αφετηρία την ουρά του δείκτη</p>
			</td>
		  </tbody></tr>
		  <tbody><tr>
			<td>
				<div align="center">
					<img src="images/marker_red2.png"/>
				</div>
			</td>
			<td>
				<p style="color:white; font-weight:bold; text-align:center">Συνεπιβάτες με αφετηρία το Βόλο και προορισμό την κορυφή του δείκτη</p>
			</td>
		  </tbody></tr>
		  <tbody><tr>
			<td>
				<div align="center">
					<img src="images/marker_red3.png"/>
				</div>
			</td>
			<td>
				<p style="color:white; font-weight:bold; text-align:center">Συνεπιβάτες με προορισμό το Βόλο και αφετηρία την ουρά του δείκτη</p>
			</td>
		  </tbody></tr>
		</table><br>
		<div align="center">
			<iframe width="450" height="190" src="//www.youtube.com/embed/Kqoz0yfnSV0" frameborder="0" allowfullscreen></iframe>
		</div>
	</div>
	<div id="help2" style="display: block;">
		<a href="#" class="close_box" id="close_recent_posts_div2">Κλείσιμο </a>
		<div id="keimeno" align="left" style="font-family: Yanone; padding-top:7px; text-align:justify; text-justify:inter-word; font-weight:bold;">
			Αγαπητά μέλη της Πανεπιστημιακής Κοινότητας του Π.Θ.,<br><br>
			Στους δύσκολους καιρούς που περνάμε, η Πολυτεχνική Σχολή έχει τη χαρά να σας παρουσιάσει την πλατφόρμα UthPool. Πρόκειται για ένα σύστημα car pooling που χρησιμοποιείται διεθνώς σε μεγάλη κλίμακα, το οποίο κατασκευάστηκε προκειμένου να καταστήσει τις μετακινήσεις μας πιο ευχάριστες.<br><br>
			Η συμμετοχή στο σύστημα προορίζεται μόνο για τα μέλη της Πανεπιστημιακής Κοινότητας του Π.Θ., και σας καλούμε να την αγκαλιάσετε και να τη χρησιμοποιήσετε όσο περισσότερο γίνεται, όπως και να στείλετε σχόλιά σας στη διαχείριση του συστήματος για να κάνουμε, αν χρειαστεί, βελτιώσεις.<br><br>
			Από το βήμα αυτό, θα ήθελα να ευχαριστήσω θερμά τον Ορέστη Μεϊκόπουλο για τον σχεδιασμό και την υλοποίηση της πλατφόρμας.<br><br>
			Καλά και ευχάριστα ταξίδια!<br>
			Παντελής Σκάγιαννης<br>
			Κοσμήτορας Π.Σ. Π.Θ.<br><br>
			ΥΓ: Η εφαρμογή προς το παρόν λειτουργεί δοκιμαστικά και αφορά μόνο διαδρομές από και προς Βόλο. Σύντομα θα προσθέσουμε και τη δυνατότητα διαδρομών από και προς Λάρισα, Τρίκαλα και Καρδίτσα.
			<br>
			<div style="padding-top:6px;">(*<u>Υπόδειξη</u>: Πατήστε "Κλείσιμο" ή το ερωτηματικό για να εμφανιστεί η βοήθεια)</div> 
		</div>
	</div>
	<noscript><b>JavaScript must be enabled in order for you to use Google Maps.</b> 
      However, it seems JavaScript is either disabled or not supported by your browser. 
      To view Google Maps, enable JavaScript by changing your browser options, and then 
      try again.
    </noscript>
    <script type="text/javascript">		
		var lastmarker;
		var markerClusterer = null;
		var mmarkers = [];
		var show1markers = [];  //otan emfanizetai o marker me status active
		var show2markers = [];  //otan emfanizetai o marker me status inactive
		var InfoWindow = new google.maps.InfoWindow();
		var home = new google.maps.LatLng(39.359785,22.930802);
		var home2 = new google.maps.LatLng(39.614747,22.387719);
		var home3 = new google.maps.LatLng(39.535027,21.779652);
		var home4 = new google.maps.LatLng(39.378431,21.912217);
		var home5 = new google.maps.LatLng(38.912541,22.428145);
		var rendererOptions = {
			suppressMarkers : true,
			preserveViewport: true
		}
		var directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
		var directionsService = new google.maps.DirectionsService();
		
		function show2() {
			for (var i=0; i<show1markers.length; i++) {
				show1markers[i].hide();
				map.closeInfoWindow();
			}
			for (var i=0; i<show2markers.length; i++) {
				show2markers[i].hide();
				map.closeInfoWindow();
			}
			load3();
			load4();
			map.setCenter(new google.maps.LatLng(39.191849,23.206291), 8);
			var input = /** @type {HTMLInputElement} */(
			document.getElementById('login_button'));
			map.controls[google.maps.ControlPosition.CENTER].push(input);
			var input2 = /** @type {HTMLInputElement} */(
			document.getElementById('logo'));
			map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(input2);
			var home_marker = new google.maps.Marker({
				position: home,
				map: map,
				animation: google.maps.Animation.DROP
			});
			home_marker.setIcon("images/University_map_marker.png");
			jQuery('#help').hide();
			jQuery('#help2').show();
		}
		
		function createMarker5(driver_id,ddate,hour,people,text,point,status,p_details,direction) {	//otan emfanizei sthn arxh odhgous (pros8ese +1 stoixeio status kai +1 koumpi gia krathsh)
			var marker = new google.maps.Marker({
				position: point,
				animation: google.maps.Animation.DROP
			});
			if (direction == "From Volos") {
				direction = "Από Βόλο";
				var request = {
					origin:home,
					destination:point,
					travelMode: google.maps.TravelMode.DRIVING
				};
			}
			else if (direction == "To Volos") {
				direction = "Προς Βόλο";
				var request = {
					origin:home,
					destination:point,
					travelMode: google.maps.TravelMode.DRIVING
				};
			}
			else if (direction == "From Larisa") {
				direction = "Από Λάρισα";
				var request = {
					origin:home2,
					destination:point,
					travelMode: google.maps.TravelMode.DRIVING
				};
			}
			else if (direction == "To Larisa") {
				direction = "Προς Λάρισα";
				var request = {
					origin:home2,
					destination:point,
					travelMode: google.maps.TravelMode.DRIVING
				};
			}
			else if (direction == "From Trikala") {
				direction = "Από Τρίκαλα";
				var request = {
					origin:home3,
					destination:point,
					travelMode: google.maps.TravelMode.DRIVING
				};
			}
			else if (direction == "To Trikala") {
				direction = "Προς Τρίκαλα";
				var request = {
					origin:home3,
					destination:point,
					travelMode: google.maps.TravelMode.DRIVING
				};
			}
			else if (direction == "From Karditsa") {
				direction = "Από Καρδίτσα";
				var request = {
					origin:home4,
					destination:point,
					travelMode: google.maps.TravelMode.DRIVING
				};
			}
			else if (direction == "To Karditsa") {
				direction = "Προς Καρδίτσα";
				var request = {
					origin:home4,
					destination:point,
					travelMode: google.maps.TravelMode.DRIVING
				};
			}
			else if (direction == "From Lamia") {
				direction = "Από Λαμία";
				var request = {
					origin:home5,
					destination:point,
					travelMode: google.maps.TravelMode.DRIVING
				};
			}
			else if (direction == "To Lamia") {
				direction = "Προς Λαμία";
				var request = {
					origin:home5,
					destination:point,
					travelMode: google.maps.TravelMode.DRIVING
				};
			}
			if (status == "Inactive...") {
				if((direction == "Από Βόλο") || (direction == "Από Λάρισα") || (direction == "Από Τρίκαλα") || (direction == "Από Καρδίτσα") || (direction == "Από Λαμία")) {
					directionsDisplay.setMap(null);
					var txt = '<u><b>Κατεύθυνση</b></u>' + ': ' + direction + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Έχω χώρο για άτομα</b></u>' + ': ' + people + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + text + '<br><br>' + '<span style="color:red; font-size:11pt"><a href="LoginPage.php"><u><b>ΠΡΟΦΙΛ ΕΝΔΙΑΦΕΡΟΜΕΝΟΥ</b></u></a></span>' + '<br>' + '<b>Σχόλια: </b>' + p_details;
					google.maps.event.addListener(marker,"click", function() {
						marker.setIcon("images/blue_Marker_new2.png");
						InfoWindow.setContent(txt);
						InfoWindow.open(map,marker);
					});
					google.maps.event.addListener(marker,"mouseover", function() {
						marker.setIcon("images/blue_Marker_new2.png");
						InfoWindow.setContent(txt);
						InfoWindow.open(map,marker);
						directionsService.route(request, function(response, status) {
							if (status == google.maps.DirectionsStatus.OK) {
								directionsDisplay.setDirections(response);
							}
						});
						directionsDisplay.setMap(map);
					});
					google.maps.event.addListener(marker,"mouseout", function() {
						directionsDisplay.setMap(null);
					});					
					setTimeout(function() {
						for (var i=0; i<show2markers.length; i++) {
							InfoWindow.close();
						}
					}, 0);
					marker.setMap(map);
					show2markers.push(marker);
					mmarkers.push(marker);
					google.maps.event.addListener(map,"click", function() {
						for (var i=0; i<show2markers.length; i++) {
							InfoWindow.close();
						}
					});
					return marker;
				}
				else {
					directionsDisplay.setMap(null);
					var txt = '<u><b>Κατεύθυνση</b></u>' + ': ' + direction + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Έχω χώρο για άτομα</b></u>' + ': ' + people + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + text + '<br><br>' + '<span style="color:red; font-size:11pt"><a href="LoginPage.php"><u><b>ΠΡΟΦΙΛ ΕΝΔΙΑΦΕΡΟΜΕΝΟΥ</b></u></a></span>' + '<br>' + '<b>Σχόλια: </b>' + p_details;
					google.maps.event.addListener(marker,"click", function() {
						marker.setIcon("images/blue_Marker_new3.png");
						InfoWindow.setContent(txt);
						InfoWindow.open(map,marker);
					});
					google.maps.event.addListener(marker,"mouseover", function() {
						marker.setIcon("images/blue_Marker_new3.png");
						InfoWindow.setContent(txt);
						InfoWindow.open(map,marker);
						directionsService.route(request, function(response, status) {
							if (status == google.maps.DirectionsStatus.OK) {
								directionsDisplay.setDirections(response);
							}
						});
						directionsDisplay.setMap(map);
					});
					google.maps.event.addListener(marker,"mouseout", function() {
						directionsDisplay.setMap(null);
					});	
					setTimeout(function() {
						for (var i=0; i<show2markers.length; i++) {
							InfoWindow.close();
						}
					}, 0);
					marker.setMap(map);
					show2markers.push(marker);
					mmarkers.push(marker);
					google.maps.event.addListener(map,"click", function() {
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
					var txt = '<u><b>Κατεύθυνση</b></u>' + ': ' + direction + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Έχω χώρο για άτομα</b></u>' + ': ' + people + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + text + '<br><br>' + '<form><span style="padding-left:110px"><button type="button" onclick="booking()">Ενδιαφέρομαι!</button></span></form>';
					google.maps.event.addListener(marker,"click", function() {
						marker.setIcon("images/blue_Marker_new2.png");
						InfoWindow.setContent(txt);
						InfoWindow.open(map,marker);
					});
					google.maps.event.addListener(marker,"mouseover", function() {
						marker.setIcon("images/blue_Marker_new2.png");
						InfoWindow.setContent(txt);
						InfoWindow.open(map,marker);
						directionsService.route(request, function(response, status) {
							if (status == google.maps.DirectionsStatus.OK) {
								directionsDisplay.setDirections(response);
							}
						});
						directionsDisplay.setMap(map);
					});
					google.maps.event.addListener(marker,"mouseout", function() {
						directionsDisplay.setMap(null);
					});
					setTimeout(function() {
						for (var i=0; i<show1markers.length; i++) {
							InfoWindow.close();
						}
					}, 0);
					marker.setMap(map);
					show1markers.push(marker);
					mmarkers.push(marker);
					google.maps.event.addListener(map,"click", function() {
						for (var i=0; i<show1markers.length; i++) {
							InfoWindow.close();
						}
					});
					return marker;
				}
				else {
					directionsDisplay.setMap(null);
					var txt = '<u><b>Κατεύθυνση</b></u>' + ': ' + direction + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Έχω χώρο για άτομα</b></u>' + ': ' + people + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + text + '<br><br>' + '<form><span style="padding-left:110px"><button type="button" onclick="booking()">Ενδιαφέρομαι!</button></span></form>';
					google.maps.event.addListener(marker,"click", function() {
						marker.setIcon("images/blue_Marker_new3.png");
						InfoWindow.setContent(txt);
						InfoWindow.open(map,marker);
					});
					google.maps.event.addListener(marker,"mouseover", function() {
						marker.setIcon("images/blue_Marker_new3.png");
						InfoWindow.setContent(txt);
						InfoWindow.open(map,marker);
						directionsService.route(request, function(response, status) {
							if (status == google.maps.DirectionsStatus.OK) {
								directionsDisplay.setDirections(response);
							}
						});
						directionsDisplay.setMap(map);
					});
					google.maps.event.addListener(marker,"mouseout", function() {
						directionsDisplay.setMap(null);
					});
					setTimeout(function() {
						for (var i=0; i<show1markers.length; i++) {
							InfoWindow.close();
						}
					}, 0);
					marker.setMap(map);
					show1markers.push(marker);
					mmarkers.push(marker);
					google.maps.event.addListener(map,"click", function() {
						for (var i=0; i<show1markers.length; i++) {
							InfoWindow.close();
						}
					});
					return marker;
				}
			}
		}
		
		function createMarker6(passenger_id,ddate,hour,people,text,point,status,d_details,direction) {	//otan emfanizei sthn arxh sunepivates (pros8ese +1 stoixeio status kai +1 koumpi gia krathsh)
			var marker = new google.maps.Marker({
				position: point,
				animation: google.maps.Animation.DROP
			});
			if (direction == "From Volos") {
				direction = "Από Βόλο";
				var request = {
					origin:home,
					destination:point,
					travelMode: google.maps.TravelMode.DRIVING
				};
			}
			else if (direction == "To Volos") {
				direction = "Προς Βόλο";
				var request = {
					origin:home,
					destination:point,
					travelMode: google.maps.TravelMode.DRIVING
				};
			}
			else if (direction == "From Larisa") {
				direction = "Από Λάρισα";
				var request = {
					origin:home2,
					destination:point,
					travelMode: google.maps.TravelMode.DRIVING
				};
			}
			else if (direction == "To Larisa") {
				direction = "Προς Λάρισα";
				var request = {
					origin:home2,
					destination:point,
					travelMode: google.maps.TravelMode.DRIVING
				};
			}
			else if (direction == "From Trikala") {
				direction = "Από Τρίκαλα";
				var request = {
					origin:home3,
					destination:point,
					travelMode: google.maps.TravelMode.DRIVING
				};
			}
			else if (direction == "To Trikala") {
				direction = "Προς Τρίκαλα";
				var request = {
					origin:home3,
					destination:point,
					travelMode: google.maps.TravelMode.DRIVING
				};
			}
			else if (direction == "From Karditsa") {
				direction = "Από Καρδίτσα";
				var request = {
					origin:home4,
					destination:point,
					travelMode: google.maps.TravelMode.DRIVING
				};
			}
			else if (direction == "To Karditsa") {
				direction = "Προς Καρδίτσα";
				var request = {
					origin:home4,
					destination:point,
					travelMode: google.maps.TravelMode.DRIVING
				};
			}
			else if (direction == "From Lamia") {
				direction = "Από Λαμία";
				var request = {
					origin:home5,
					destination:point,
					travelMode: google.maps.TravelMode.DRIVING
				};
			}
			else if (direction == "To Lamia") {
				direction = "Προς Λαμία";
				var request = {
					origin:home5,
					destination:point,
					travelMode: google.maps.TravelMode.DRIVING
				};
			}
			if (status == "Inactive...") {
				if((direction == "Από Βόλο") || (direction == "Από Λάρισα") || (direction == "Από Τρίκαλα") || (direction == "Από Καρδίτσα") || (direction == "Από Λαμία")) {
					directionsDisplay.setMap(null);
					var txt = '<u><b>Κατεύθυνση</b></u>' + ': ' + direction + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Άτομα</b></u>' + ': ' + people + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + text + '<br><br>' + '<span style="color:blue; font-size:11pt"><a href="LoginPage.php"><u><b>ΠΡΟΦΙΛ ΕΝΔΙΑΦΕΡΟΜΕΝΟΥ</b></u></a></span>' + '<br>' + '<b>Σχόλια: </b>' + d_details;
					google.maps.event.addListener(marker,"click", function() {
						marker.setIcon("images/marker_red2.png");
						InfoWindow.setContent(txt);
						InfoWindow.open(map,marker);
					});
					google.maps.event.addListener(marker,"mouseover", function() {
						marker.setIcon("images/marker_red2.png");
						InfoWindow.setContent(txt);
						InfoWindow.open(map,marker);
						directionsService.route(request, function(response, status) {
							if (status == google.maps.DirectionsStatus.OK) {
								directionsDisplay.setDirections(response);
							}
						});
						directionsDisplay.setMap(map);
					});
					google.maps.event.addListener(marker,"mouseout", function() {
						directionsDisplay.setMap(null);
					});
					setTimeout(function() {
						for (var i=0; i<show2markers.length; i++) {
							InfoWindow.close();
						}
					}, 0);
					marker.setMap(map);
					show2markers.push(marker);
					mmarkers.push(marker);
					google.maps.event.addListener(map,"click", function() {
						for (var i=0; i<show2markers.length; i++) {
							InfoWindow.close();
						}
					});
					return marker;
				}
				else {
					directionsDisplay.setMap(null);
					var txt = '<u><b>Κατεύθυνση</b></u>' + ': ' + direction + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Άτομα</b></u>' + ': ' + people + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + text + '<br><br>' + '<span style="color:blue; font-size:11pt"><a href="LoginPage.php"><u><b>ΠΡΟΦΙΛ ΕΝΔΙΑΦΕΡΟΜΕΝΟΥ</b></u></a></span>' + '<br>' + '<b>Σχόλια: </b>' + d_details;
					google.maps.event.addListener(marker,"click", function() {
						marker.setIcon("images/marker_red3.png");
						InfoWindow.setContent(txt);
						InfoWindow.open(map,marker);
					});
					google.maps.event.addListener(marker,"mouseover", function() {
						marker.setIcon("images/marker_red3.png");
						InfoWindow.setContent(txt);
						InfoWindow.open(map,marker);
						directionsService.route(request, function(response, status) {
							if (status == google.maps.DirectionsStatus.OK) {
								directionsDisplay.setDirections(response);
							}
						});
						directionsDisplay.setMap(map);
					});
					google.maps.event.addListener(marker,"mouseout", function() {
						directionsDisplay.setMap(null);
					});
					setTimeout(function() {
						for (var i=0; i<show2markers.length; i++) {
							InfoWindow.close();
						}
					}, 0);
					marker.setMap(map);
					show2markers.push(marker);
					mmarkers.push(marker);
					google.maps.event.addListener(map,"click", function() {
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
					var txt = '<u><b>Κατεύθυνση</b></u>' + ': ' + direction + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Άτομα</b></u>' + ': ' + people + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + text + '<br><br>' + '<form><span style="padding-left:110px"><button type="button" onclick="booking()">Ενδιαφέρομαι!</button></span></form>';
					google.maps.event.addListener(marker,"click", function() {
						marker.setIcon("images/marker_red2.png");
						InfoWindow.setContent(txt);
						InfoWindow.open(map,marker);
					});
					google.maps.event.addListener(marker,"mouseover", function() {
						marker.setIcon("images/marker_red2.png");
						InfoWindow.setContent(txt);
						InfoWindow.open(map,marker);
						directionsService.route(request, function(response, status) {
							if (status == google.maps.DirectionsStatus.OK) {
								directionsDisplay.setDirections(response);
							}
						});
						directionsDisplay.setMap(map);
					});
					google.maps.event.addListener(marker,"mouseout", function() {
						directionsDisplay.setMap(null);
					});
					setTimeout(function() {
						for (var i=0; i<show1markers.length; i++) {
							InfoWindow.close();
						}
					}, 0);
					marker.setMap(map);
					show1markers.push(marker);
					mmarkers.push(marker);
					google.maps.event.addListener(map,"click", function() {
						for (var i=0; i<show1markers.length; i++) {
							InfoWindow.close();
						}
					});
					return marker;
				}	
				else {
					directionsDisplay.setMap(null);
					var txt = '<u><b>Κατεύθυνση</b></u>' + ': ' + direction + '<br>' + '<u><b>Αναχώρηση (+ | - 30 λεπτά)</b></u>' + '<br>' + ddate + ' στις ' + hour + '<br>' + '<u><b>Άτομα</b></u>' + ': ' + people + '<br>' + '<u><b>Λεπτομέρειες</b></u>' + '<br>' + text + '<br><br>' + '<form><span style="padding-left:110px"><button type="button" onclick="booking()">Ενδιαφέρομαι!</button></span></form>';
					google.maps.event.addListener(marker,"click", function() {
						marker.setIcon("images/marker_red3.png");
						InfoWindow.setContent(txt);
					});
					google.maps.event.addListener(marker,"mouseover", function() {
						marker.setIcon("images/marker_red3.png");
						InfoWindow.setContent(txt);
						InfoWindow.open(map,marker);
						directionsService.route(request, function(response, status) {
							if (status == google.maps.DirectionsStatus.OK) {
								directionsDisplay.setDirections(response);
							}
						});
						directionsDisplay.setMap(map);
					});
					google.maps.event.addListener(marker,"mouseout", function() {
						directionsDisplay.setMap(null);
					});
					setTimeout(function() {
						for (var i=0; i<show1markers.length; i++) {
							InfoWindow.close();
						}
					}, 0);
					marker.setMap(map);
					show1markers.push(marker);
					mmarkers.push(marker);
					google.maps.event.addListener(map,"click", function() {
						for (var i=0; i<show1markers.length; i++) {
							InfoWindow.close();
						}
					});
					return marker;
				}
			}
		}

		function load3() {
			downloadUrl("php/emfanishmarkers4.php", function(data) {
				var data = new XMLHttpRequest(); 
				data.open("GET", "php/emfanishmarkers4.php", false); 
				data.overrideMimeType("text/xml");
				data.send(null);
				var xml = data.responseXML;
				var markers = xml.documentElement.getElementsByTagName("marker");
				for (var i = 0; i < markers.length; i++) {
					var passenger_id = markers[i].getAttribute("passenger_id");
					var ddate = markers[i].getAttribute("ddate");
					var hour = markers[i].getAttribute("hour");
					var people = markers[i].getAttribute("people");
					var direction = markers[i].getAttribute("direction");
					var details = markers[i].getAttribute("details");
					var point = new google.maps.LatLng(
						parseFloat(markers[i].getAttribute("lat")),
						parseFloat(markers[i].getAttribute("lng")));
					var status = markers[i].getAttribute("status");
					var d_details = markers[i].getAttribute("d_details");
					var marker = createMarker6(passenger_id,ddate,hour,people,details,point,status,d_details,direction);
					google.maps.event.trigger(marker,"click");
				}
				markerClusterer = new MarkerClusterer(map, mmarkers);
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
		
		function load4() {
			downloadUrl("php/emfanishmarkers3.php", function(data) {
				var data = new XMLHttpRequest(); 
				data.open("GET", "php/emfanishmarkers3.php", false); 
				data.overrideMimeType("text/xml");
				data.send(null);
				var xml = data.responseXML;
				var markers = xml.documentElement.getElementsByTagName("marker");
				for (var i = 0; i < markers.length; i++) {
					var driver_id = markers[i].getAttribute("driver_id");
					var ddate = markers[i].getAttribute("ddate");
					var hour = markers[i].getAttribute("hour");
					var people = markers[i].getAttribute("people");
					var direction = markers[i].getAttribute("direction");
					var details = markers[i].getAttribute("details");
					var point = new google.maps.LatLng(
						parseFloat(markers[i].getAttribute("lat")),
						parseFloat(markers[i].getAttribute("lng")));
					var status = markers[i].getAttribute("status");
					var p_details = markers[i].getAttribute("p_details");
					var marker = createMarker5(driver_id,ddate,hour,people,details,point,status,p_details,direction);
					google.maps.event.trigger(marker,"click");
				}
				markerClusterer = new MarkerClusterer(map, mmarkers);
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
		
		function booking() {
			window.location = "LoginPage.php";
			return false;
		}
		
	    var mapOptions = {
					center: new google.maps.LatLng(39.24528, 23.2144),
					zoom: 8,
					panControl: true,
					panControlOptions: {
						position: google.maps.ControlPosition.TOP_LEFT
					},
					zoomControl: true,
					zoomControlOptions: {
						style: google.maps.ZoomControlStyle.SMALL,
						position: google.maps.ControlPosition.TOP_LEFT
					},
					scaleControl: false,
					mapTypeControl: true,
					mapTypeControlOptions: {
						style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
						mapTypeIds: ['coordinate', google.maps.MapTypeId.ROADMAP],
					},
					streetViewControl: true,
					streetViewControlOptions: {
						position: google.maps.ControlPosition.TOP_LEFT
					},
					overviewMapControl: true
				};
		map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
		google.maps.event.addDomListener(window, "resize", function() {
			var center = map.getCenter();
			google.maps.event.trigger(map, "resize");
			map.setCenter(center); 
		});
		
		function load() {
			show2();
		}
		$('#target3').click(function() {
			$("#help").fadeIn(10);
			$("#help2").fadeOut(10);
			return false;
		});
		$("#close_recent_posts_div").click(function(){
			$("#help").fadeOut(10);
			return false;
		});
		$("#close_recent_posts_div2").click(function(){
			$("#help2").fadeOut(10);
			jQuery('#help').show();
			return false;
		});
	</script>
	<script src="js/markerclusterer.js" type="text/javascript"></script>
  </body>
</html>