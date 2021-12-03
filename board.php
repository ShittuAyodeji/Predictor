<?php
function prediction_board($dbc){
	$uid=rand(time(),5);
	  if(isset($_COOKIE['stories_id']) &&(validate_numbers($_COOKIE['stories_id']))){
		  $stories_id=$_COOKIE['stories_id'];
	  }/* else{
	  setcookie('stories_id',$uid,time()+86000 * 30);
	  $stories_id=$uid;
	  } */
	 $today=date("Y-m-d H:i:s");
	$sql_predictions=$dbc->prepare("SELECT * FROM predictions WHERE match_day>='$today' ORDER BY match_date LIMIT 10");	
	$sql_voters=$dbc->prepare("SELECT * FROM predictions WHERE match_day<'$today' LIMIT 1");
	$sql_voters->execute();
	$result_voters=$sql_voters->get_result();
	$row_num_voters=$result_voters->num_rows;	
	if($row_num_voters>0){
		$expired=$result_voters->fetch_assoc();
		$expired_id=$expired['id'];
		$delete_voters=$dbc->prepare("DELETE  FROM voters WHERE vote_id=$expired_id");	
		$result_deleted=$delete_voters->execute();
		if($result_deleted){
		$delete_predictions=$dbc->prepare("DELETE  FROM predictions WHERE id=$expired_id");	
		$delete_predictions->execute();
		}
	}
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
		$score_no=$predictions['score_no'];
		$time=$predictions['match_time'];
		$date=$predictions['match_day'];
		$date=explode("-",$date);
		$date=$date[2]."/".$date[1]."/".$date[0];
		$total_over=$over1_5+$over2_5+$over3_5;
		$total_under=$under1_5+$under2_5+$under3_5;
		$total_outcome=$home_win+$draw+$away_win;
		$all_goals=$total_over+$total_under;
		$total_score=$score_yes+$score_no;
	
		$sql_outcome=$dbc->prepare("SELECT * FROM voters WHERE voters_id=? AND vote_id=? AND prediction='outcomes'");
		$sql_outcome->bind_param("ii",$stories_id,$prediction_id);
		$sql_outcome->execute();
		$result_outcome=$sql_outcome->get_result();
		$num_outcome=$result_outcome->num_rows;
		
		$sql_over=$dbc->prepare("SELECT * FROM voters WHERE voters_id=? AND vote_id=? AND prediction='goals'");
		$sql_over->bind_param("ii",$stories_id,$prediction_id);
		$sql_over->execute();
		$result_over=$sql_over->get_result();
		$num_goals=$result_over->num_rows;
		
		$sql_scores=$dbc->prepare("SELECT * FROM voters WHERE voters_id=? AND vote_id=? AND prediction='scores'");
		$sql_scores->bind_param("ii",$stories_id,$prediction_id);
		$sql_scores->execute();
		$result_scores=$sql_scores->get_result();
		$num_scores=$result_scores->num_rows;
		
		if($total_outcome>0 && $num_outcome==1){
		$home_win_percentage=round(($home_win/$total_outcome)*100);
		$draw_percentage=round(($draw/$total_outcome)*100);
		$away_win_percentage=round(($away_win/$total_outcome)*100);
		
		$home_win_percentage_score=$home_win_percentage."%";
		$draw_percentage_score=$draw_percentage."%";
		$away_win_percentage_score=$away_win_percentage."%";
		
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

		if($total_over>0 && $num_goals==1){
		$over1_5_percentage=round(($over1_5/$total_over)*100);
		$over2_5_percentage=round(($over2_5/$total_over)*100);
		$over3_5_percentage=round(($over3_5/$total_over)*100);
		
		$over1_5_percentage_score=$over1_5_percentage."%";
		$over2_5_percentage_score=$over2_5_percentage."%";
		$over3_5_percentage_score=$over3_5_percentage."%";
		
		$over1_5_score="(".round_up($over1_5).")";
		$over2_5_score="(".round_up($over2_5).")";
		$over3_5_score="(".round_up($over3_5).")";
		}else{
		$over1_5_percentage=$over2_5_percentage=$over3_5_percentage=0;	
		$over1_5_percentage_score=$over2_5_percentage_score=$over3_5_percentage_score="";	
		$over1_5_score=$over2_5_score=$over3_5_score="";	
		}
		
		if($total_under>0  && $num_goals==1){
		$under1_5_percentage=round(($under1_5/$total_under)*100);
		$under2_5_percentage=round(($under2_5/$total_under)*100);
		$under3_5_percentage=round(($under3_5/$total_under)*100);
		
		$under1_5_percentage_score=$under1_5_percentage."%";
		$under2_5_percentage_score=$under2_5_percentage."%";
		$under3_5_percentage_score=$under3_5_percentage."%";
		
		$under1_5_score="(".round_up($under1_5).")";
		$under2_5_score="(".round_up($under2_5).")";
		$under3_5_score="(".round_up($under3_5).")";
		}else{
		$under1_5_percentage=$under2_5_percentage=$under3_5_percentage=0;
		$under1_5_percentage_score=$under2_5_percentage_score=$under3_5_percentage_score="";		
		$under1_5_score=$under2_5_score=$under3_5_score="";		
		}
		if($total_score>0 && $num_scores==1){
		$score_yes_percentage=round(($score_yes/$total_score)*100);
		$score_no_percentage=round(($score_no/$total_score)*100);
		
		$score_yes_percentage_score=$score_yes_percentage."%";
		$score_no_percentage_score=$score_no_percentage."%";		
		
		$score_yes_score="(".round_up($score_yes).")";
		$score_no_score="(".round_up($score_no).")";
		}else{
		$score_yes_percentage=$score_no_percentage=0;	
		$score_yes_percentage_score=$score_no_percentage_score="";	
		$score_yes_score=$score_no_score="";	
		}
	?>
	<div class="prediction-wrap">
	<!---<span class="close close-advise">&times;</span>--->
	<div class="team_name"><strong class="teams"><?php echo htmlspecialchars_decode($teams);  ?></strong> <span class="match-time"><?php echo $date." @".reverse_secure_input($time)." CAT";  ?></span></div>
	<div class="prediction-head">Outcomes <span class="no_votes" ><span class="outcomes_no_votes_<?php echo $prediction_id; ?>"><?php echo $total_outcome;  ?></span><span> <?php echo $outcomes_votes;  ?></span></span></div>
	
	<div class="col-sm-4 col-xs-4 outcomes options home_win_<?php echo $prediction_id; ?>" target="<?php echo $prediction_id; ?>" caption="home_win" data-choice="1">
	<span class="votes" style="width:<?php echo $home_win_percentage."%"; ?>"></span><span class="option-caption">Win</span>
	<span><em class="number_score"><?php echo $home_win_score; ?></em><em class="percentage_score"><?php echo $home_win_percentage_score; ?></em></span></div>
	
	<div class="col-sm-4 col-xs-4 outcomes lines options draw_<?php echo $prediction_id; ?>" target="<?php echo $prediction_id; ?>" caption="draw" data-choice="2">
	<span class="votes" style="width:<?php echo $draw_percentage."%"; ?>"></span><span class="option-caption">Draw</span>
	<span><em class="number_score"><?php echo $draw_score; ?></em><em class="percentage_score"><?php echo $draw_percentage_score; ?></em></span></div>
	
	<div class="col-sm-4 col-xs-4 outcomes lines options away_win_<?php echo $prediction_id; ?>" target="<?php echo $prediction_id; ?>" caption="away_win" data-choice="3">
	<span class="votes" style="width:<?php echo $away_win_percentage."%"; ?>"></span><span class="option-caption">Win</span>
	<span><em class="number_score"><?php echo $away_win_score; ?></em><em class="percentage_score"><?php echo $away_win_percentage_score; ?></em></span></div>
	
	<div class="prediction-head">Goals <span class="no_votes"><span class="goals_no_votes_<?php echo $prediction_id; ?>"><?php echo $all_goals;  ?></span><span> <?php echo $goal_votes;  ?></span></span></div>
	<div class="goal-options">
	<div class="col-sm-4 col-xs-4 outcomes score">1.5</div>
	<div class="col-sm-4 col-xs-4 outcomes lines options over1_5_<?php echo $prediction_id; ?>" target="<?php echo $prediction_id; ?>" caption="over1_5" data-choice="4">
	<span class="votes" style="width:<?php echo $over1_5_percentage."%"; ?>"></span><span class="option-caption">Over</span>
	<span><em class="number_score"><?php echo $over1_5_score; ?></em><em class="percentage_score"><?php echo $over1_5_percentage_score; ?></em></span></div>
	
	<div class="col-sm-4 col-xs-4 outcomes lines options under1_5_<?php echo $prediction_id; ?>" target="<?php echo $prediction_id; ?>" caption="under1_5" data-choice="5">
	<span class="votes" style="width:<?php echo $under1_5_percentage."%"; ?>"></span><span class="option-caption">Under</span>
	<span><em class="number_score"><?php echo $under1_5_score; ?></em><em class="percentage_score"><?php echo $under1_5_percentage_score; ?></em></span></div>
	</div>
	<div class="goal-options">
	<div class="col-sm-4 col-xs-4 outcomes score">2.5</div>
	<div class="col-sm-4 col-xs-4 outcomes lines options over2_5_<?php echo $prediction_id; ?>" target="<?php echo $prediction_id; ?>" caption="over2_5" data-choice="6">
	<span class="votes" style="width:<?php echo $over2_5_percentage."%"; ?>"></span><span class="option-caption">Over</span>
	<span><em class="number_score"><?php echo $over2_5_score; ?></em><em class="percentage_score"><?php echo $over2_5_percentage_score; ?></em></span></div>
	
	<div class="col-sm-4 col-xs-4 outcomes lines options under2_5_<?php echo $prediction_id; ?>" target="<?php echo $prediction_id; ?>" caption="under2_5" data-choice="7">
	<span class="votes" style="width:<?php echo $under2_5_percentage."%"; ?>"></span><span class="option-caption">Under</span>
	<span><em class="number_score"><?php echo $under2_5_score; ?></em><em class="percentage_score"><?php echo $under2_5_percentage_score; ?></em></span></div>
	</div>
	
	<div class="goal-options">
	<div class="col-sm-4 col-xs-4 outcomes score">3.5</div>
	<div class="col-sm-4 col-xs-4 outcomes lines options over3_5_<?php echo $prediction_id; ?>" target="<?php echo $prediction_id; ?>" caption="over3_5" data-choice="8">
	<span class="votes" style="width:<?php echo $over3_5_percentage."%"; ?>"></span><span class="option-caption">Over</span>
	<span><em class="number_score"><?php echo $over3_5_score; ?></em><em class="percentage_score"><?php echo $over3_5_percentage_score; ?></em></span></div>
	
	<div class="col-sm-4 col-xs-4 outcomes lines options under3_5_<?php echo $prediction_id; ?>" target="<?php echo $prediction_id; ?>" caption="under3_5" data-choice="9">
	<span class="votes" style="width:<?php echo $under3_5_percentage."%"; ?>"></span><span class="option-caption">Under</span>
	<span><em class="number_score"><?php echo $under3_5_score; ?></em><em class="percentage_score"><?php echo $under3_5_percentage_score; ?></em></span></div>
	</div>
	
	<div class="prediction-head">Both teams to score <span class="no_votes"><span class="scores_no_votes_<?php echo $prediction_id; ?>">
	<?php echo $total_score;  ?></span> <span> <?php echo $score_votes;  ?></span></span></div>
	<div class="col-sm-6 col-xs-6 outcomes options score_yes_<?php echo $prediction_id; ?>" target="<?php echo $prediction_id; ?>" caption="score_yes" data-choice="10">
	<span class="votes" style="width:<?php echo $score_yes_percentage."%"; ?>"></span><span class="">Yes</span>
	<span><em class="number_score"><?php echo $score_yes_score; ?></em><em class="percentage_score"><?php echo $score_yes_percentage_score; ?></em></span></div>
	
	<div class="col-sm-6 col-xs-6 outcomes lines options score_no_<?php echo $prediction_id; ?>" target="<?php echo $prediction_id; ?>" caption="score_no" data-choice="11">
	<span class="votes" style="width:<?php echo $score_no_percentage."%"; ?>"></span><span class="">No</span>
	<span><em class="number_score"><?php echo $score_no_score; ?></em><em class="percentage_score"><?php echo $score_no_percentage_score; ?></em></span></div>
	</div>
	<?php
	/*  $i=0; */
	}
	}
}
?>