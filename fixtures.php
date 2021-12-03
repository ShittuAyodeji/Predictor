	<?php
require_once "includes/functions.php"; 
require_once "includes/session.php"; 
require_once "database/connect.php";
$all_data=array();
$uid=rand(time(),5);
	  if(isset($_SESSION['pid'])){
		  $pid=$_SESSION['pid'];
	  }else{
	  $pid=0;
	  }
	 	       if(isset($_POST['league']))
 {
     
		
	 //$token=$_POST['owner'];
     //if(check_token($token)){
    mysqli_set_charset($dbc,"utf8mb4");
	$league=$_POST['league'];
	$today=date("Y-m-d H:i:s");
	$sql_predictions=$dbc->prepare("SELECT * FROM predictions WHERE league='$league' AND match_date>='$today' ORDER BY match_date");	
	if($league=="all"){
	$sql_predictions=$dbc->prepare("SELECT * FROM predictions WHERE match_date<='$today' ORDER BY match_date");		
	}
	$user_score=0;
	$sql_predictions->execute();
	$result_predictions=$sql_predictions->get_result();
	$row_num_predictions=$result_predictions->num_rows;	
	if($row_num_predictions>0){
	while($predictions=$result_predictions->fetch_assoc()){
			$teams=reverse_secure_input($predictions['teams']);
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
		$goals=$predictions['goals'];
		$outcomes=$predictions['outcomes'];
		$scores=$predictions['scores'];
		$score_no=$predictions['score_no'];
		$time=$predictions['match_time'];
		$date=$predictions['match_day'];
		$date=explode("-",$date);
		$date=$date[2]."/".$date[1]."/".$date[0];
		$total_goal_1_5=$over1_5+$under1_5;
		$total_goal_2_5=$over2_5+$under2_5;
		$total_goal_3_5=$over3_5+$under3_5;
		$total_over=$over1_5+$over2_5+$over3_5;
		$total_under=$under1_5+$under2_5+$under3_5;
		$total_outcome=$home_win+$draw+$away_win;
		$all_goals=$total_over+$total_under;
		$total_score=$score_yes+$score_no;
		
	/* 
		$sql_report=$dbc->prepare("SELECT * FROM voters WHERE voters_id=? AND vote_id=?");
		$sql_report->bind_param("ii",$pid,$prediction_id);
		$sql_report->execute();
		$result_report=$sql_report->get_result();
		$num_report=$result_report->num_rows;
		if($num_report>0){
			while($user=$result_report->fetch_assoc()){
				$uPredict=$user['prediction'];
				$uChoice=$user['choice'];
				if($uPredict=="outcomes" && $outcomes==$uChoice){
					$user_score+=2;
				}else if($uPredict=="goals" && $goals==$uChoice){
					$user_score+=5;
				}else if($uPredict=="scores" && $scores==$uChoice){
					$user_score+=3;
				}
			}
		}
		 */
		
		$sql_outcome=$dbc->prepare("SELECT * FROM voters WHERE voters_id=? AND vote_id=? AND prediction='outcomes'");
		$sql_outcome->bind_param("si",$pid,$prediction_id);
		$sql_outcome->execute();
		$result_outcome=$sql_outcome->get_result();
		$num_outcome=$result_outcome->num_rows;
		
		$sql_over=$dbc->prepare("SELECT * FROM voters WHERE voters_id=? AND vote_id=? AND prediction='goals'");
		$sql_over->bind_param("si",$pid,$prediction_id);
		$sql_over->execute();
		$result_over=$sql_over->get_result();
		$num_goals=$result_over->num_rows;
		
		$sql_scores=$dbc->prepare("SELECT * FROM voters WHERE voters_id=? AND vote_id=? AND prediction='scores'");
		$sql_scores->bind_param("si",$pid,$prediction_id);
		$sql_scores->execute();
		$result_scores=$sql_scores->get_result();
		$num_scores=$result_scores->num_rows;
		
		if($total_outcome>0 && $num_outcome==1){
		$home_win_percentage=round(($home_win/$total_outcome)*100);
		$draw_percentage=round(($draw/$total_outcome)*100);
		$away_win_percentage=round(($away_win/$total_outcome)*100);
		
		$percentages=reducePercentage($home_win_percentage,$draw_percentage,$away_win_percentage);
		
		$home_win_percentage=$percentages[0];
		$draw_percentage=$percentages[1];
		$away_win_percentage=$percentages[2];
		$home_win_percentage_score=$percentages[0]."%";
		$draw_percentage_score=$percentages[1]."%";
		$away_win_percentage_score=$percentages[2]."%";
		
		$home_win_score="(".round_up($home_win).")";
		$draw_score="(".round_up($draw).")";
		$away_win_score="(".round_up($away_win).")";
		}else{
		$home_win_percentage=$draw_percentage=$away_win_percentage=0;	
		$home_win_percentage_score=$draw_percentage_score=$away_win_percentage_score="";	
		$home_win_score=$draw_score=$away_win_score="";	
		}
		if($total_outcome>1 || $total_outcome==0){
		$outcomes_votes="votes";
		}else{
		$outcomes_votes="vote";
		}
		if($all_goals>1 || $all_goals==0){
		$goal_votes="votes";
		}else{
		$goal_votes="vote";
		}
		
		if($total_score>1 || $total_score==0){
		$score_votes="votes";
		}else{
		$score_votes="vote";
		}
		
		$over1_5_percentage=$over2_5_percentage=$over3_5_percentage=0;	
		$over1_5_percentage_score=$over2_5_percentage_score=$over3_5_percentage_score="";	
		$over1_5_score=$over2_5_score=$over3_5_score="";

		$under1_5_percentage=$under2_5_percentage=$under3_5_percentage=0;
		$under1_5_percentage_score=$under2_5_percentage_score=$under3_5_percentage_score="";		
		$under1_5_score=$under2_5_score=$under3_5_score="";
		
		if($total_goal_1_5>0 && $num_goals==1){
		$over1_5_percentage=$total_goal_1_5!=0 ? round(($over1_5/$total_goal_1_5)*100) : 0;
		$under1_5_percentage=$total_goal_1_5!=0 ? round(($under1_5/$total_goal_1_5)*100) : 0;
		
		$new_percentages=reducePercentage($over1_5_percentage,$under1_5_percentage);
		
		$over1_5_percentage=$new_percentages[0];
		$under_5_percentage=$new_percentages[1];

		
		$over1_5_percentage_score=$new_percentages[0]."%";
		$under1_5_percentage_score=$new_percentages[1]."%";
		
		$over1_5_score="(".round_up($over1_5).")";
		$under1_5_score="(".round_up($under1_5).")";
		}
		if($total_goal_2_5>0 && $num_goals==1){
		$over2_5_percentage=$total_goal_2_5!=0 ? round(($over2_5/$total_goal_2_5)*100) : 0;
		$under2_5_percentage=$total_goal_2_5!=0 ? round(($under2_5/$total_goal_2_5)*100) : 0;
		
		$new_percentages=reducePercentage($over2_5_percentage,$under2_5_percentage);
		
		$over2_5_percentage=$new_percentages[0];
		$under2_5_percentage=$new_percentages[1];

		
		$over2_5_percentage_score=$new_percentages[0]."%";
		$under2_5_percentage_score=$new_percentages[1]."%";
		
		$over2_5_score="(".round_up($over2_5).")";
		$under2_5_score="(".round_up($under2_5).")";
		}
		if($total_goal_3_5>0 && $num_goals==1){
		$over3_5_percentage=$total_goal_3_5!=0 ? round(($over3_5/$total_goal_3_5)*100) : 0;
		$under3_5_percentage=$total_goal_3_5!=0 ? round(($under3_5/$total_goal_3_5)*100) : 0;
		
		$new_percentages=reducePercentage($over3_5_percentage,$under3_5_percentage);
		
		$over3_5_percentage=$new_percentages[0];
		$under3_5_percentage=$new_percentages[1];

		
		$over3_5_percentage_score=$new_percentages[0]."%";
		$under3_5_percentage_score=$new_percentages[1]."%";
		
		$over3_5_score="(".round_up($over3_5).")";
		$under3_5_score="(".round_up($under3_5).")";
		}
		
		if($total_score>0 && $num_scores==1){
		$score_yes_percentage=round(($score_yes/$total_score)*100);
		$score_no_percentage=round(($score_no/$total_score)*100);
		
		$score_percentages=reducePercentage($score_yes_percentage,$score_no_percentage);
		$score_yes_percentage=$score_percentages[0];
		$score_no_percentage=$score_percentages[1];
		
		$score_yes_percentage_score=$score_yes_percentage."%";
		$score_no_percentage_score=$score_no_percentage."%";		
		
		$score_yes_score="(".round_up($score_yes).")";
		$score_no_score="(".round_up($score_no).")";
		}else{
		$score_yes_percentage=$score_no_percentage=0;	
		$score_yes_percentage_score=$score_no_percentage_score="";	
		$score_yes_score=$score_no_score="";	
		}
		if(!isset($_SESSION['pid'])){
		$total_goal_1_5=0;
		$total_goal_2_5=0;
		$total_goal_3_5=0;
		$total_outcome=0;
		$total_score=0;
		}
		if($num_outcome==0){
			$total_outcome=0;
		}
		if($num_goals==0){
			$total_goal_1_5=0;
		$total_goal_2_5=0;
		$total_goal_3_5=0;
		}
		if($num_scores==0){
			$total_score=0;
		}
		$data = array(
		"teams" => $teams,
		"date" => $date,
		"time" => reverse_secure_input($time)." CAT",
		"pid" => $prediction_id,
		"total_outcome" => $total_outcome,
		//"total_votes" => $total_votes,
		"home_win_percentage" => $home_win_percentage,
		"home_win_score" => $home_win_score,
		"home_win_percentage_score" => $home_win_percentage_score,
		"draw_percentage" => $draw_percentage,
		"draw_score" => $draw_score,
		"draw_percentage_score" => $draw_percentage_score,
		"away_win_percentage" => $away_win_percentage,
		"away_win_score" => $away_win_score,
		"away_win_percentage_score" => $away_win_percentage_score,
		"over1_5_percentage" => $over1_5_percentage,
		"over1_5_score" => $over1_5_score,
		"over1_5_percentage_score" => $over1_5_percentage_score,
		"under1_5_percentage" => $under1_5_percentage,
		"under1_5_score" => $under1_5_score,
		"under1_5_percentage_score" => $under1_5_percentage_score,
		"over2_5_percentage" => $over2_5_percentage,
		"over2_5_score" => $over2_5_score,
		"over2_5_percentage_score" => $over2_5_percentage_score,
		"under2_5_percentage" => $under2_5_percentage,
		"under2_5_score" => $under2_5_score,
		"under2_5_percentage_score" => $under2_5_percentage_score,
		"over3_5_percentage" => $over3_5_percentage,
		"over3_5_score" => $over3_5_score,
		"over3_5_percentage_score" => $over3_5_percentage_score,
		"under3_5_percentage" => $under3_5_percentage,
		"under3_5_score" => $under3_5_score,
		"under3_5_percentage_score" => $under3_5_percentage_score,
		"score_yes_percentage" => $score_yes_percentage,
		"score_yes_score" => $score_yes_score,
		"score_no_percentage" => $score_no_percentage,
		"score_no_score" => $score_no_score,
		"score_yes_percentage_score" => $score_yes_percentage_score,
		"score_no_percentage_score" => $score_no_percentage_score,
		"outcomes_votes" => $outcomes_votes,
		"all_goals" => $all_goals,
		"one_five" => $total_goal_1_5,
		"two_five" => $total_goal_2_5,
		"three_five" => $total_goal_3_5,
		"total_score" => $total_score,		
		"score_votes" => $score_votes,		
		"goal_votes" => $goal_votes		
		//"user_score" => $user_score
		);
		array_push($all_data,$data);
	}
	}
	}
	echo json_encode($all_data);
	mysqli_close($dbc);
	?>