<?php
require_once "includes/functions.php"; 
require_once "database/connect.php";
mysqli_set_charset($dbc,"utf8mb4");
/* if(isset($_SESSION["user_id"]) && validate_numbers($_SESSION["user_id"])){
	$user_id=$_SESSION['user_id']; */
		$uid=rand(time(),5);
	  if(isset($_COOKIE['stories_id'])){
		  $stories_id=$_COOKIE['stories_id'];
	  }else{
	  setcookie('stories_id',$uid,time()+86000 * 30);
	  $stories_id=$uid;
	  }
	  $section_predicted=[];
    if(isset($_POST['id']))
 {
     //$token=$_POST['owner'];
     //if(check_token($token)){
		$vote_id=secure_input($_POST['id']);
	    $prediction=$_POST['prediction'];
		$goals_array=array("over1_5","over2_5","over3_5","under1_5","under2_5","under3_5");
		if($prediction=="away_win" || $prediction=="draw" || $prediction=="home_win"){
			$section="outcomes";
		}else if(in_array($prediction,$goals_array)){
			$section="goals";
		}else if($prediction=="score_yes" || $prediction=="score_no"){
			$section="scores";
		}
		
		/* $sql_boost=$dbc->prepare("SELECT token,location FROM ".$type." WHERE id=$story_id LIMIT 1");
		$sql_boost->execute();
		$result_boost=$sql_boost->get_result();
		$row=$result_boost->num_rows;
		if($row>0){
			$boosts=$result_boost->fetch_assoc();
			$token=$boosts['token'];
			$location=$boosts['location'];
		} */
$sql=$dbc->prepare("SELECT * FROM voters WHERE voters_id=? AND vote_id=? AND prediction=?");
$sql->bind_param("iis",$stories_id,$vote_id,$section);
$sql->execute();
$result_booted=$sql->get_result();
$num_rows=$result_booted->num_rows;
if($num_rows==1){

}else{
$predicted=1; 
$query_boost=$dbc->prepare("UPDATE predictions SET ".$prediction."=".$prediction."+1 WHERE id=$vote_id");
$result=$query_boost->execute();
if($result){
	 $query = $dbc->prepare("INSERT INTO voters(vote_id,voters_id,prediction)
	VALUES (?,?,?)");	
	 $query->bind_param("iis",$vote_id,$stories_id,$section);
	 $result=$query->execute();
	 if($result){
	 $predicted = "predicted";
	$sql_predictions=$dbc->prepare("SELECT * FROM predictions WHERE id=$vote_id");	
	$sql_predictions->execute();
	$result_predictions=$sql_predictions->get_result();
	$row_num_predictions=$result_predictions->num_rows;	
	if($row_num_predictions>0){
		$predictions=$result_predictions->fetch_assoc();
		$teams=$predictions['teams'];
		$prediction_id=$predictions['id'];
		$home_win=$predictions['home_win'];
		$draw=$predictions['draw'];
		$away_win=$predictions['away_win'];
		$over1_5=$predictions['over1_5'];
		$over2_5=$predictions['over2_5'];
		$over3_5=$predictions['over3_5'];
		$under1_5=$predictions['under1_5'];
		$under2_5=$predictions['under2_5'];
		$under3_5=$predictions['under3_5'];
		$score_yes=$predictions['score_yes'];
		$score_no=$predictions['score_no'];
		$total_over=$over1_5+$over2_5+$over3_5;
		$total_under=$under1_5+$under2_5+$under3_5;
		$total_outcome=$home_win+$draw+$away_win;
		$total_goals=$total_under+$total_over;
		
		$total_score=$score_yes+$score_no;
		if($total_outcome>0){
		$home_win_percentage=round(($home_win/$total_outcome)*100);
		$draw_percentage=round(($draw/$total_outcome)*100);
		$away_win_percentage=round(($away_win/$total_outcome)*100);
		}else{
		$home_win_percentage=$draw_percentage=$away_win_percentage=0;	
		}
		
		if($total_over>0){
		$over1_5_percentage=round(($over1_5/$total_over)*100);
		$over2_5_percentage=round(($over2_5/$total_over)*100);
		$over3_5_percentage=round(($over3_5/$total_over)*100);
		}else{
		$over1_5_percentage=$over2_5_percentage=$over3_5_percentage=0;	
		}
		
		if($total_under>0){
		$under1_5_percentage=round(($under1_5/$total_under)*100);
		$under2_5_percentage=round(($under2_5/$total_under)*100);
		$under3_5_percentage=round(($under3_5/$total_under)*100);
		}else{
		$under1_5_percentage=$under2_5_percentage=$under3_5_percentage=0;	
		}
		if($total_score>0){
		$score_yes_percentage=round(($score_yes/$total_score)*100);
		$score_no_percentage=round(($score_no/$total_score)*100);
		}else{
		$score_yes_percentage=$score_no_percentage=0;	
		}
	 }
	 	if($section=="outcomes"){
		 $section_predicted
		 $data=array("vote_id"=>$vote_id,
		 "home_win_percentage" =>$home_win_percentage,
		 "draw_percentage" =>$draw_percentage,
		 "away_win_percentage" => $away_win_percentage,
		 "home_win" => $home_win,
		 "draw" => $draw,
		 "away_win" => $away_win,
		 "total_outcome" =>$total_outcome,
		 "section" => $section,
		"message" => $predicted,
		"prediction" => $prediction,
		"section_predicted" => $section_predicted
		 );
		 array_push($section_predicted,$data);
		}else if($section=="goals"){
		$data=array("vote_id" => $vote_id,
		"over1_5_percentage" =>$over1_5_percentage,
		"over2_5_percentage" => $over2_5_percentage,
		"over3_5_percentage" =>$over3_5_percentage,
		"under1_5_percentage" => $under1_5_percentage,
		"under2_5_percentage" => $under2_5_percentage,
		"under3_5_percentage" =>$under3_5_percentage,
		"over1_5" => $over1_5,
		"over2_5" => $over2_5,
		"over3_5" =>$over3_5,
		"under1_5" =>$under1_5,
		"under2_5" =>$under2_5,
		"under3_5" => $under3_5,
		"total_goals" => $total_goals,
		"section" => $section,
		"message" => $predicted,
		"prediction" => $prediction,
		"section_predicted" => $section_predicted
		);
		array_push($section_predicted,$data);
		}else if($section=="scores"){
			$data=array("vote_id" => $vote_id,
			"score_yes_percentage"=> $score_yes_percentage,
			"score_no_percentage" => $score_no_percentage,
			"score_yes" => $score_yes,
			"score_no" => $score_no,
			"total_score".$total_score,
			"section" => $section,
			"message" => $predicted,
			"prediction" => $prediction,
			"section_predicted" => $section_predicted
			);
		array_push($section_predicted,$data);
		}
		echo json_decode($section_predicted);
}
} 	
}
//}
}
/* }else{
	echo "Login to boost this story";
} */
mysqli_close($dbc);
?>