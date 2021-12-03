<?php
$connect_error = 'We experiencing down time';
$host='localhost';
$username='root';
$password='';
$dbname='pre_db';
$dbc = mysqli_connect($host,$username,$password,$dbname);
try{
	if(!$dbc){
		throw new Exception($connect_error);
	}
}catch(Exception $e){
	echo $e->getMessage();
}
 
		   or die($connect_error);
?>