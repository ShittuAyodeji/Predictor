	<?php
include "includes/functions.php"; 
include "includes/session.php"; 
include "database/connect.php";
 $all_data=array();			
 $rates=[0.2,0.16,0.12,0.08,0.04,0.036,0.032,0.028,0.024,0.02,0.016,0.012,0.008,0.004,0.0036,0.0032,0.0028,0.0024,0.002,0.0016];
 //$rates2=[0.12,0.08,0.04,0.036,0.032,0.028,0.024,0.02,0.016,0.012,0.008,0.004,0.0036,0.0032,0.0028,0.0024,0.002,0.0016,0.0012,0.00008];
 $funds=table_field($dbc,"settings","funds");
 $play_status=table_field($dbc,"settings","play_status");
 $result_status=table_field($dbc,"settings","result_status");
 $today=date("Y-m-d H:i:s");
	if(isset($_POST['pid'])){
		$uniqueID=$_POST['pid'];
	$sql_user=$dbc->prepare("SELECT pid,score FROM users WHERE pid=? AND status='YES' ORDER BY id");
	$sql_user->bind_param("s",$uniqueID);
	}else{
	$all_rows=rowz($dbc,"");
	//echo $all_rows;
		if($all_rows<=20){
			$sql_user=$dbc->prepare("SELECT pid,score FROM users WHERE calculated='YES' ORDER BY score DESC LIMIT 20");	
		}else{
			$saveAverages=array();
			$result_average=result_average($dbc,"");
			 $sql_user=$dbc->prepare("SELECT pid,score FROM users WHERE score>=$result_average  AND calculated='YES' ORDER BY score DESC");
			$pre_sql=$sql_user;
			$pre_sql->execute();
			$pre_result=$pre_sql->get_result();
			$new_all_rows=$pre_result->num_rows;
			do{
				$result_average=result_average($dbc,$result_average);
				$sql_user=$dbc->prepare("SELECT pid,score FROM users WHERE score>=$result_average  AND calculated='YES' ORDER BY score DESC");
				$new_all_rows=rowz($dbc,$result_average);
				array_push($saveAverages);
			} while($new_all_rows > 20 && end($saveAverages)!=$result_average);
		}
	}
	$sql_user->execute();
	$result_user=$sql_user->get_result();
	$row_num_user=$result_user->num_rows;	
	if($row_num_user>0){
	if(isset($POST['pid'])){
	$users=$result_user->fetch_assoc();
	$user_score=0;
	$upid=$users['pid'];
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
		if($num_report>0){
			$fullChoice='';
			$fullScore=0;
			while($user=$result_report->fetch_assoc()){
				$uPredict=$user['prediction'];
				$uChoice=$user['choice'];
				if($uPredict=="outcomes" && $outcomes==$uChoice){
					$user_score+=2;
					$fullScore+=2;
				}else if($uPredict=="goals" && $goals==$uChoice){
					$user_score+=5;
					$fullScore+=5;
				}else if($uPredict=="scores" && $scores==$uChoice){
					$user_score+=3;
					$fullScore+=3;
				}
				$fullChoice.=$uChoice."-";
				
			}
		}
		$playResult=$outcomes."-".$goals."-".$scores;
		$played=substr($fullChoice,0,-1);
		$playerResult=$fullScore."/10";
		$data=array(
		"played" => $played,
		"play_result" => $playResult,
		"report" => $playerResult,
		"teams" => $teams
		);
		array_push($all_data,$data);
		echo json_encode($all_data);
	}
	
	}
	// }
	}else{
		$i=0;
		$j=0;
		$k=1;
		$p=0;
		$price=0;
		$initialPrice=0;
		$totalPrice=0;
	$initialLastScore=array();
	$lastScore=array();
	$positions=array();
	
	$totalPrice=getTotalFunds($sql_user,$funds,$rates);
	do{
	$new_rate=array();
	if($totalPrice>$funds){
		//$rates=$rates2;
		$deduct=0.04;
		$new_index=0;
		for($u=0; $u<count($rates); $u++){
			$index=$rates[$u];
			$number_of_digits=strlen(substr(strrchr($index, "."), 1));
			if($number_of_digits==2 && strlen(substr(strrchr($deduct, "."), 1)<=$number_of_digits)){
				$deduct=0.04;
			}else if($number_of_digits==3 && strlen(substr(strrchr($deduct, "."), 1)<=$number_of_digits)){
				$deduct=0.004;
			}else if($number_of_digits==4 && strlen(substr(strrchr($deduct, "."), 1)<=$number_of_digits)){
				$deduct=0.0004;
			}else if($number_of_digits==5 && strlen(substr(strrchr($deduct, "."), 1)<=$number_of_digits)){
				$deduct=0.00004;
			}
			$new_index=$index-$deduct;
			if($new_index==0){
				$digit='0.00'.strlen(substr(strrchr($deduct, "."), 1));
				$deduct=$digit;
				//echo $deduct;
				$new_index=$index-$deduct;
			}else if($new_index<0){
				$digit='0.00'.strlen(substr(strrchr($deduct, "."), 1));
				$deduct=$digit;
				$new_index=$index-$deduct;
			}
			//echo $deduct."-";
			array_push($new_rate,$new_index);
		}
		$rates=$new_rate;
		$totalPrice=getTotalFunds($sql_user,$funds,$rates);
		//print_r($rates);
	}

	}while($totalPrice>$funds);
	//echo $totalPrice;
	
	//print_r($rates);
	while($users=$result_user->fetch_assoc()){
	$predictorID=$users['pid'];
	$predictorScore=$users['score'];
	//echo $predictorScore;
	$j++;
	$lastSaved=end($lastScore);
	if($predictorScore!==$lastSaved & !empty($lastScore)){
	$i++;
	//$k++;
	$k=$j;
	}
	$price=number_format($funds * $rates[$i]);
	$data= array(
		"num" => $k,
		"predictor" => $predictorID,
		"score" => $predictorScore,
		"price" => $price
	);
	
	
	
	array_push($all_data,$data);
	array_push($lastScore,$predictorScore);
	}
	echo json_encode($all_data);
	}
	}else{
	$data= array(
		"num" => "",
		"predictor" => "No predictions yet",
		"score" => ""
	);
	array_push($all_data,$data);
	echo json_encode($all_data);	
	}
	
	mysqli_close($dbc);
	?>