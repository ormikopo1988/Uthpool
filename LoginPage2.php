<html lang="el" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
	<title>Καλώς ήρθατε!</title>
	<link media="all" type="text/css" href="http://www.inf.uth.gr/cced/wp-admin/css/wp-admin.min.css?ver=3.5.1" id="wp-admin-css" rel="stylesheet">
	<link media="all" type="text/css" href="http://www.inf.uth.gr/cced/wp-includes/css/buttons.min.css?ver=3.5.1" id="buttons-css" rel="stylesheet">
	<script src="http://www.inf.uth.gr/cced/wp-includes/js/jquery/jquery.js?ver=1.8.3" type="text/javascript"></script>
	<link href="http://www.inf.uth.gr/cced/wp-content/plugins/bm-custom-login/bm-custom-login.css" type="text/css" rel="stylesheet">
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<style>	
		#login {
			background: none repeat scroll 0 0 #FFFFFF;
			border: 2px solid #E5E5E5;
			box-shadow: 1px 4px 10px -1px rgba(200, 200, 200, 0.7);
			font-weight: normal;
			margin-top: 200px;
			padding: 29px 24px 46px;
			width:360px;
		}
		
		#login,
		#login label {
			color:#454545;
		}
		
		html {
			background: grey url(http://news.schools.gr/wp-content/uploads/2014/01/panepistimio_thessalias.jpg) center center fixed no-repeat;
			background-size: 100% 100%;
		}
		
		body.login {
			background:transparent !important;
		}
		
		.login #login a {
			color:black !important;
		}

		.login #login a:hover {
			color:#3333CC !important;
		}


		#login #nav,
		#login #backtoblog {
			text-shadow:0 1px 4px #000;
		}
		
		.login #nav a, .login #backtoblog a {
			color: white !important;
		}
	</style>
	<meta content="noindex,nofollow" name="robots">
	<style type="text/css">
		body.login #login h1 a {
			background: url("http://www.uth.gr/en/images/uth_logo.jpg") no-repeat scroll center top transparent;
			height: 75px;
			width: 348px;
		}
	</style>
	<script>
		function Members(username,password) {

			var errors = '';

			var username = $("#loginform [name='username']").val();
			if (username == "") {
				errors += '- Παρακαλώ εισάγετε το όνομα χρήστη σας\n';
			}

			var password = $("#loginform [name='password']").val();
			if (password == "") {
				errors += '- Παρακαλώ εισάγετε το συνθηματικό σας\n';
			}

			if (errors) {
				errors = 'Διαπιστώθηκαν τα παρακάτω σφάλματα: \n' + errors;
				//alert(errors);
				return false;
			}
		}
	</script>
</head>
<body class="login login-action-login wp-core-ui">
	<div id="login" align='center'>
		<h1><a title="Πανεπιστήμιο Θεσσαλίας" href="http://www.uth.gr/">Πανεπιστήμιο Θεσσαλίας</a></h1>
	
	<form method="post" action="Members2.php" id="loginform" name="loginform">
		<p>
			<label for="username">Όνομα χρήστη<br>
			<input type="text" size="20" value="" class="input" id="username" name="username" autocomplete="on"/></label>
		</p>
		<p>
			<label for="password">Συνθηματικό<br>
			<input type="password" size="20" value="" class="input" id="password" name="password" autocomplete="on"/></label>
		</p>
		<p class="submit">
		<input type="submit" onclick="Members(username.value,password.value)" value="Σύνδεση" class="button button-primary button-large" id="wp-submit" name="wp-submit"></input>
		</p>
	</form>

	</div>
</body>
</html>