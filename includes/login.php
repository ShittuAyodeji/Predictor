<?php
if(isset($_POST['login'])) { 
$date=date('Y-m-d H:i:s');
$email = trim(mysqli_real_escape_string($dbc, $_POST['email']));
$password = trim(mysqli_real_escape_string($dbc, $_POST['password']));
$query_password = $dbc->prepare("SELECT email,salt FROM users WHERE email=?");
$query_password->bind_param("s",$email);
$query_password->execute();
$result_password = $query_password->get_result();
$num_rows = $result_password->num_rows;
if ($num_rows == 1) {
$verify = $result_password->fetch_assoc();
$salt= $verify['salt'];
}else{
$salt ="";
}
$key="KEY HERE";
$hashed_password = hash_hmac('sha512',$password.$salt, $key);
$msg_count = 0;
$servertime=$_SERVER["REQUEST_TIME"];
$validity = 120;
if(empty($email)){
echo "What's your email?";
}
else if(empty($password)){
echo "You need password to login!";
}
else{

$query = "SELECT id, pid, email,firstname FROM users WHERE email='$email' AND password='$hashed_password' LIMIT 1";
$result = mysqli_query($dbc, $query);
		if (!$result) {
				echo "Invalid account details";
			}
			else{
						if (mysqli_num_rows($result) == 1) {
								// username/password authenticated
								// and only 1 match
								$found_user = mysqli_fetch_array($result);
								$_SESSION['user_id'] = $found_user['id'];
								$_SESSION['pid'] = $found_user['pid'];
								$_SESSION['firstname'] = $found_user['firstname'];
								redirect_to("../predictor/");
						}else{
							echo "Incorrect Email and Password Combination, please try again. Make sure CAPS LOCK is turned off";
							}
				}
}
} 