<?php
$session_life=3600 * 24 * 182;
session_set_cookie_params($session_life);
	session_start();
	
	function logged_in(){
		return isset($_SESSION["user_id"]);
	}
	
	function confirm_logged_in($link)
		{
		if(!logged_in())
			{
				if($link=="user_page"){
					$redirect_link='../../sign-in/';
				}else{
					$redirect_link='../sign-in/';
				}
			redirect_to($redirect_link);
			}
		}
?>