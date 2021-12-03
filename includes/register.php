<?php
if(isset($_POST['register'])) { 
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email']));
$password1 = $_POST['password'];
$password2 = $_POST['password2'];
$pid="PXE".rand(5, time());
$key="KEY HERE";
$salt = bin2hex(openssl_random_pseudo_bytes(20));
$hashed_password = hash_hmac('sha512',$password1.$salt, $key);
$rand =hash_hmac('sha512',$email.$salt, $key);

$activation_key = $rand;
$time=$_SERVER["REQUEST_TIME"];
$account_id=substr(rand(4,time()),0,8);

if(empty($firstname)){
echo "Enter your first name!";
}else if(empty($lastname)){
echo "Enter your last name!";
}
else if(empty($email)){
echo "Would you be so kind to let us have your email?";
}
else if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)){
echo "Would you be so kind to give us a valid email?";
}
else if(empty($password1)){
echo "Password required?";
}
else if($password1!==$password2){
echo "Password does not match!";
}
else{
  
$select = "SELECT email FROM users WHERE email = '$email'";
$email_result = mysqli_query($dbc, $select);
if(mysqli_num_rows($email_result)==1){
    echo $email." is already been used";
	}else{
		$query_pending_user = "INSERT INTO pending_users (
								firstname, email, timestp, token
							)".
			"VALUES(
					 '$firstname', '$email', '$time', '$activation_key'
					)";
$result_pending_user = mysqli_query($dbc, $query_pending_user);

	if($result_pending_user){
		$query = "INSERT INTO users (
								pid, firstname,  lastname, email, salt, password,status
							)".
			"VALUES(
					'$pid', '$firstname',  '$lastname', '$email', '$salt', '$hashed_password', '0'
					)";
$result = mysqli_query($dbc, $query);
if($result){
		$message ="Thank you ".$firstname;	
		echo $message;
	
			}else{
			echo "Registration error, please try again";
				}
		}else{
		echo "Registration not successful, please try again";
		}
	}

}
}
?>