<?php
if(isset($_POST['first_name'])){
$to="mytest@gmail.com";
$fullname =$_POST['name'];
$email =$_POST['email'];
$phone =$_POST['phone'];
$comment =$_POST['message'];
$date = date("Y-m-d H:i:s");
$subject="Support";

$message = "
<html>
<head>
<title>".$subject."</title>
</head>
<body>
<p>Name: ".$fullname."</p>
<p>".$comment."</p>
<p>Contact: ".$email.", ".$phone."</p>
<p>Date: ".$date." @".$time."</p>
</body>
</html>
";

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From: '.$email;
if(mail($to,$subject,$message,$headers)){
    echo "sent";
}
}

?>