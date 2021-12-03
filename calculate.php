	<?php
include "includes/functions.php"; 
include "includes/session.php"; 
include "database/connect.php";
 $all_data=array();

	  	       if(isset($_POST['start'],$_POST['per_page']))
 {
	 $start=$_POST['start'];
	 $per_page=$_POST['per_page'];
	 $accumulated_score=0;
	 $calculated="NO";
	 //$start=0;
	 //$per_page=5;
     //$token=$_POST['owner'];
     //if(check_token($token)){
    mysqli_set_charset($dbc,"utf8mb4");
	$today=date("Y-m-d H:i:s");
	if(isset($_POST['pid'])){
		$uniqueID=$_POST['pid'];
	$sql_user=$dbc->prepare("SELECT * FROM users WHERE pid=? ORDER BY id");
	$sql_user->bind_param("s",$uniqueID);
	}else{
	$sql_user=$dbc->prepare("SELECT * FROM users WHERE eligibility='YES' OR free='YES' ORDER BY id LIMIT $start,$per_page");
	}
	$sql_user->execute();
	$result_user=$sql_user->get_result();
	$row_num_user=$result_user->num_rows;
$i=0;	
	if($row_num_user>0){
	while($users=$result_user->fetch_assoc()){
	$user_score=0;
	$upid=$users['pid'];
	$calculated=$users['calculated'];
	$accumulated_score=$users['accumulated_score'];
	$sql_predictions=$dbc->prepare("SELECT * FROM predictions WHERE match_date<='$today' ORDER BY match_date");	
	$sql_predictions->execute();
	$result_predictions=$sql_predictions->get_result();
	$row_num_predictions=$result_predictions->num_rows;	
	if($row_num_predictions>0){
	while($predictions=$result_predictions->fetch_assoc()){
		$prediction_id=$predictions['id'];
		//echo $prediction_id;
		$goals=$predictions['goals'];
		$outcomes=$predictions['outcomes'];
		$scores=$predictions['scores'];
		$teams=$predictions['teams'];
		//echo "SELECT * FROM voters WHERE voters_id='$upid' AND vote_id='$	'";
		$sql_report=$dbc->prepare("SELECT * FROM voters WHERE voters_id=? AND vote_id=?");
		$sql_report->bind_param("si",$upid,$prediction_id);
		$sql_report->execute();
		$result_report=$sql_report->get_result();
		$num_report=$result_report->num_rows;
		$fullChoice='';
		$fullScore=0;
		if($num_report>0){
			while($user=$result_report->fetch_assoc()){
				$uPredict=$user['prediction'];
				$uChoice=$user['choice'];
				if($uPredict=="outcomes" && $outcomes==$uChoice){
					$user_score+=2;
					$fullScore+=2;
				}else if($uPredict=="goals" && $goals==$uChoice){
					$user_score+=5;
					$fullScore+=5;
				}else if($uPredict=="scores" && ($scores==$uChoice || ($scores==9 & ($uChoice==5 || $uChoice==7)) ||
						($scores==7 & $uChoice==5 ))){
					$user_score+=3;
					$fullScore+=3;
				}
				$fullChoice.=$uChoice."-";
				
			}
		}
		$playResult=$outcomes."-".$goals."-".$scores;
		$played=substr($fullChoice,0,-1);
		if($played!=false){
			$numPlayed=explode("-",$played);
			$counter=count($numPlayed);
			if($counter==1){
				$played=$played."  -   -";
			}else if($counter==2){
				$played=$played."  -";
			}
		}
		$played==false ? $played="-  -  -" : $played=$played;
		$playerResult=$fullScore."/10";
		$data=array(
		"played" => $played,
		"play_result" => $playResult,
		"report" => $playerResult,
		"teams" => $teams,
		"user_score" => $user_score,
		);
		array_push($all_data,$data);	
	}
	
	}
	if(eligible_to_predict($dbc,$upid)>0 && $calculated=="NO"){
			$calculated="YES";
			$accumulated_score=$accumulated_score+$user_score;
			$sql_score=$dbc->prepare("UPDATE users SET score=?, accumulated_score=?, calculated=? WHERE pid=?");
			$sql_score->bind_param("iiss",$user_score,$accumulated_score,$calculated,$upid);
			$res=$sql_score->execute();
			$calculated="NO";
	}
	 }
	 //echo $user_score;
	 if($user_score==0){
		 $all_data=array();
		$data=array(
		"played" => "-",
		"play_result" => "-",
		"report" => "0/0",
		"teams" => "no predictions",
		"user_score" => 0
		);
		array_push($all_data,$data);
	}
	 echo json_encode($all_data);
 }
	}
	
	mysqli_close($dbc);
	?>