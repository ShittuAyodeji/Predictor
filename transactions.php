<?php
require_once "includes/functions.php"; 
require_once "includes/session.php"; 
require_once "database/connect.php";
if(isset($_POST['reference'])) { 
if(isset($_SESSION["pid"]) && validate_numbers_alpha($_SESSION["pid"])){
	$upid=$_SESSION['pid'];
$reference = trim(mysqli_real_escape_string($dbc, $_POST['reference']));
$email = trim(mysqli_real_escape_string($dbc, $_POST['email']));
$time=date('Y-m-d H:i:s');
$error_message = 'class="returned-message signups" target="error"';
$success_message = 'class="returned-message signups" target="success"';
		$query_payment = "INSERT INTO transactions (
								email, timestp, reference
							)".
			"VALUES(
					 '$email', '$time', '$reference'
					)";
$result_payment = mysqli_query($dbc, $query_payment);

if($result_payment){
	$sql=$dbc->prepare("UPDATE users SET eligible='YES' WHERE pid=? AND email=?") or die(mysqli_error($dbc));
	$sql->bind_param("ss",$upid,$email)  or die(mysqli_error($dbc));
	if($sql->execute()){
		echo "success";
	}
}

/* redirect_to("../phones/"); */
}
} 

?>