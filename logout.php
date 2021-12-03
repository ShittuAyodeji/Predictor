<?php
 require_once "includes/functions.php";
 require_once "database/connect.php";
 require_once "includes/session.php";
 ?>

<?php
//find session
$date=date('Y-m-d H:i:s');
session_start();
//inset all session variables
$_SESSION = array();
//destroy cookie
if(isset($_COOKIE[session_name()]))
{
	setcookie(session_name(), '',time()-42000, '/');
}
//destroy session
session_destroy();
redirect_to("../predictor/");
?>