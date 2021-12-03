<?php
include "includes/functions.php"; 
include "includes/session.php"; 
include "database/connect.php";		
 $today=date("Y-m-d H:i:s");
	if(isset($_POST['email'])){
		$uniqueID=$_SESSION['pid'];
		$email=$_POST['email'];
		$firstname=$_POST['firstname'];
		$lastname=$_POST['lastname'];
		$bank=$_POST['bank'];
		$tel=$_POST['tel'];
		$account=$_POST['account'];
		$sql_user=$dbc->prepare("UPDATE users SET firstname=?, lastname=?, tel=?, email=?, bank=?, account_no=? WHERE pid=?");
		$sql_user->bind_param("sssssss",$firstname,$lastname,$tel,$email,$bank,$account,$uniqueID);
		$result=$sql_user->execute();
		if($result){
			echo "success";
		}
	}
	mysqli_close($dbc);
	?>