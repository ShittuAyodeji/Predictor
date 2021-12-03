<?php
require_once "includes/functions.php"; 
require_once "includes/session.php"; 
require_once "database/connect.php";
mysqli_set_charset($dbc,"utf8mb4");
$all_data=array();
if(isset($_SESSION["pid"]) && validate_numbers_alpha($_SESSION["pid"])){
	$upid=$_SESSION['pid'];
    if(isset($_POST['id']))
 {
	 
     //$token=$_POST['owner'];
     //if(check_token($token)){
		$vote_id=secure_input($_POST['id']);
	    $prediction=$_POST['prediction'];
	    $choice=$_POST['choice'];
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
$sql->bind_param("sis",$upid,$vote_id,$section);
$sql->execute();
$result_booted=$sql->get_result();
$num_rows=$result_booted->num_rows;
if(eligible_to_predict($dbc,$upid)==0){
	$data=array(
		"eligibility" => 'no'
	 );
	 array_push($all_data,$data);
	 echo json_encode($all_data);
}else if($num_rows==1){
echo json_encode($all_data);
}else{
$predicted=1; 
$query_boost=$dbc->prepare("UPDATE predictions SET ".$prediction."=".$prediction."+1 WHERE id=$vote_id");
$result=$query_boost->execute();
if($result){
	 $query = $dbc->prepare("INSERT INTO voters(vote_id,voters_id,prediction,choice)
	VALUES (?,?,?,?)");	
	 $query->bind_param("issi",$vote_id,$upid,$section,$choice);
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
		$total_goal_1_5=$over1_5+$under1_5;
		$total_goal_2_5=$over2_5+$under2_5;
		$total_goal_3_5=$over3_5+$under3_5;
		$total_over=$over1_5+$over2_5+$over3_5;
		$total_under=$under1_5+$under2_5+$under3_5;
		$total_outcome=$home_win+$draw+$away_win;
		$total_goals=$total_under+$total_over;
		
		$total_score=$score_yes+$score_no;
		if($total_outcome>0){
		$home_win_percentage=round(($home_win/$total_outcome)*100);
		$draw_percentage=round(($draw/$total_outcome)*100);
		$away_win_percentage=round(($away_win/$total_outcome)*100);
		
		$outcome_percentages=reducePercentage($home_win_percentage,$draw_percentage,$away_win_percentage);
		$home_win_percentage=$outcome_percentages[0];
		$draw_percentage=$outcome_percentages[1];
		$away_win_percentage=$outcome_percentages[2];
		}else{
		$home_win_percentage=$draw_percentage=$away_win_percentage=0;	
		}
		
		
		$over1_5_percentage=$over2_5_percentage=$over3_5_percentage=0;
		$under1_5_percentage=$under2_5_percentage=$under3_5_percentage=0;
		if($total_goal_1_5>0){
		$over1_5_percentage=$total_goal_1_5!=0 ? round(($over1_5/$total_goal_1_5)*100) : 0;
		$under1_5_percentage=$total_goal_1_5!=0 ? round(($under1_5/$total_goal_1_5)*100) : 0;
		
		$new_percentages=reducePercentage($over1_5_percentage,$under1_5_percentage);
		
		$over1_5_percentage=$new_percentages[0];
		$under_5_percentage=$new_percentages[1];
		}
		if($total_goal_2_5>0){
		$over2_5_percentage=$total_goal_2_5!=0 ? round(($over2_5/$total_goal_2_5)*100) : 0;
		$under2_5_percentage=$total_goal_2_5!=0 ? round(($under2_5/$total_goal_2_5)*100) : 0;
		
		$new_percentages=reducePercentage($over2_5_percentage,$under2_5_percentage);
		
		$over2_5_percentage=$new_percentages[0];
		$under2_5_percentage=$new_percentages[1];
		}
		if($total_goal_3_5>0){
		$over3_5_percentage=$total_goal_3_5!=0 ? round(($over3_5/$total_goal_3_5)*100) : 0;
		$under3_5_percentage=$total_goal_3_5!=0 ? round(($under3_5/$total_goal_3_5)*100) : 0;
		
		$new_percentages=reducePercentage($over3_5_percentage,$under3_5_percentage);
		
		$over3_5_percentage=$new_percentages[0];
		$under3_5_percentage=$new_percentages[1];
		}
		if($total_score>0){
		$score_yes_percentage=round(($score_yes/$total_score)*100);
		$score_no_percentage=round(($score_no/$total_score)*100);
		
		$score_percentages=reducePercentage($score_yes_percentage,$score_no_percentage);
		$score_yes_percentage=$score_percentages[0];
		$score_no_percentage=$score_percentages[1];
		}else{
		$score_yes_percentage=$score_no_percentage=0;	
		}
	 }
	 	if($section=="outcomes"){
		 //$section_predicted=$vote_id."|".$home_win_percentage."|".$draw_percentage."|".$away_win_percentage."|".$home_win."|".$draw."|".$away_win."|".$total_outcome;
		$data = array(
			"id" => $vote_id,
			"home_win_".$vote_id."_percentage" => $home_win_percentage."%",
			"draw_".$vote_id."_percentage" => $draw_percentage."%",
			"away_win_".$vote_id."_percentage" => $away_win_percentage."%",
			"home_win_".$vote_id."_score" => "(".$home_win.")",
			"draw_".$vote_id."_score" => "(".$draw.")",
			"away_win_".$vote_id."_score" => "(".$away_win.")",
			"outcomes_no_votes_".$vote_id => $total_outcome,
			"section" => $section
		);
		}else if($section=="goals"){
		// $section_predicted=$vote_id."|".$over1_5_percentage."|".$over2_5_percentage."|".$over3_5_percentage."|".$under1_5_percentage.
		// "|".$under2_5_percentage."|".$under3_5_percentage."|".$over1_5."|".$over2_5."|".$over3_5."|".$under1_5.
		 //"|".$under2_5."|".$under3_5."|".$total_goals;
		 
		 $data = array(
			"id" => $vote_id,
			"over1_5_".$vote_id."_percentage" => $over1_5_percentage."%",
			"over1_5_".$vote_id."_score" => "(".$over1_5.")",
			"under1_5_".$vote_id."_percentage" => $under1_5_percentage."%",
			"under1_5_".$vote_id."_score" => "(".$under1_5.")",
			"over2_5_".$vote_id."_percentage" => $over2_5_percentage."%",
			"over2_5_".$vote_id."_score" => "(".$over2_5.")",
			"under2_5_".$vote_id."_percentage" => $under2_5_percentage."%",
			"under2_5_".$vote_id."_score" => "(".$under2_5.")",
			"over3_5_".$vote_id."_percentage" => $over3_5_percentage."%",
			"over3_5_".$vote_id."_score" => "(".$over3_5.")",
			"under3_5_".$vote_id."_percentage" => $under3_5_percentage."%",
			"under3_5_".$vote_id."_score" => "(".$under3_5.")",
			"one_five_votes_".$vote_id => $total_goal_1_5,
			"two_five_votes_".$vote_id => $total_goal_2_5,
			"three_five_votes_".$vote_id => $total_goal_3_5,
			"goals_no_votes_".$vote_id => $total_goals,
			"section" => $section
		);
		}else if($section=="scores"){
			//$section_predicted=$vote_id."|".$score_yes_percentage."|".$score_no_percentage."|".$score_yes."|".$score_no."|".$total_score;
		$data = array(
			"id" => $vote_id,
			"score_yes_".$vote_id."_percentage" => $score_yes_percentage."%",
			"score_no_".$vote_id."_percentage" => $score_no_percentage."%",
			"score_yes_".$vote_id."_score" => "(".$score_yes.")",
			"score_no_".$vote_id."_score" => "(".$score_no.")",
			"scores_no_votes_".$vote_id => $total_score,
			"section" => $section
		);
		}
		array_push($all_data,$data);
		echo json_encode($all_data);
		//echo $section."|".$predicted."|".$prediction."|".$section_predicted;
}
} 	
}
//}
}
 }else{
	 $data=array(
		"login" => 'no'
	 );
	 array_push($all_data,$data);
	 echo json_encode($all_data);
}
mysqli_close($dbc);
?>