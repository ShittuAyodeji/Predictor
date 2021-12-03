<?php
function secure_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data = str_replace('@','(at)',$data);
  $data = str_replace('?','(question mark)',$data);
  $data = str_replace('*','(star)',$data);
  $data = str_replace('%','(percentage)',$data);
  $data = str_replace('#','(hashtag)',$data);
  $data = str_replace('^','(angle)',$data);
  $data = str_replace('=','(equals)',$data);
  $data = str_replace('<','(less than)',$data);
  $data = str_replace('>','(greater than)',$data);
  $data = str_replace('{','({)',$data);
  $data = str_replace('}','(})',$data);
  $data = str_replace('~','(tilde)',$data);
  $data = str_replace(':','(:)',$data);
  $data = str_replace(';','(;)',$data);
  $data = str_replace('|','(|)',$data);
  $data = str_replace('_','(underscore)',$data);
  $data = str_replace('-','(hyphen)',$data);
  $data = str_replace("'","\'",$data);
  $data = str_replace("\'","(backslash)",$data);
  $data = str_replace("/","(forwardslash)",$data);
  $data = str_replace("`","(foreign_apos)",$data);
  $data = str_replace('"','(doublequote)',$data);
  $data = str_replace("'","(singlequote)",$data);
  return $data;
  }
 function reverse_secure_input($data) {
	$data = str_replace('(at)','@',$data);
  $data = str_replace('(question mark)','?',$data);
  $data = str_replace('(star)','*',$data);
  $data = str_replace('(percentage)','%',$data);
  $data = str_replace('(hashtag)','#',$data);
  $data = str_replace('(angle)','^',$data);
  $data = str_replace('(equals)','=',$data);
  $data = str_replace('(less than)','<',$data);
  $data = str_replace('(greater than)','>',$data);
  $data = str_replace('({)','{',$data);
  $data = str_replace('(})','}',$data);
  $data = str_replace('(tilde)','~',$data);
  $data = str_replace('(:)',':',$data);
  $data = str_replace('(;)',';',$data);
  $data = str_replace('(|)','|',$data);
  $data = str_replace('(underscore)','_',$data);
  $data = str_replace('(hyphen)','-',$data);
  $data = str_replace("(backslash)","\'",$data);
  $data = str_replace("\'","'",$data);
  $data = str_replace("(forwardslash)","/",$data);
  $data = str_replace("(foreign_apos)","`",$data);
  $data = str_replace('(doublequote)','"',$data);
  $data = str_replace('(singlequote)',"'",$data);
  return $data;	 
 }
 
 function round_up($value){
	$value=number_format($value);
	$real_len=str_replace(',','',$value);
	$format=str_split($real_len);
	
	/**if(strlen($real_len)==4){
	if($format[1]>0){
		$value=$format[0].".".$format[1]."k";
	}else{
		$value=$format[0]."k";
	}
	}else**/ if(strlen($real_len)==5){
	if($format[2]>0){
		$value=$format[0].$format[1].".".$format[2]."k";
	}else{
		$value=$format[0].$format[1]."k";
	}	
	}else if(strlen($real_len)==6){
	if($format[3]>0){
		$value=$format[0].$format[1].$format[2].".".$format[3]."k";
	}else{
		$value=$format[0].$format[1].$format[2]."k";
	}	
	}else if(strlen($real_len)==7){
	if($format[1]>0){
		$value=$format[0].".".$format[1]."m";
	}else{
		$value=$format[0]."m";
	}	
	}else if(strlen($real_len)==8){
	if($format[2]>0){
		$value=$format[0].$format[1].".".$format[2]."m";
	}else{
		$value=$format[0].$format[1]."m";
	}	
	}else if(strlen($real_len)==9){
	if($format[3]>0){
		$value=$format[0].$format[1].$format[2].".".$format[3]."m";
	}else{
		$value=$format[0].$format[1].$format[2]."m";
	}	
	}else if(strlen($real_len)==10){
	if($format[1]>0){
		$value=$format[0].".".$format[1]."b";
	}else{
		$value=$format[0]."b";
	}	
	}else if(strlen($real_len)==11){
	if($format[2]>0){
		$value=$format[0].$format[1].".".$format[2]."b";
	}else{
		$value=$format[0].$format[1]."b";
	}	
	}else if(strlen($real_len)==12){
	if($format[3]>0){
		$value=$format[0].$format[1].$format[2].".".$format[3]."b";
	}else{
		$value=$format[0].$format[1].$format[2]."b";
	}	
	}
	return $value;
}
 
 
  function redirect_to( $location = NULL ) {
		if ($location != NULL) {
			header("Location: {$location}");
			exit;
		}
	}

function validate_numbers($value){
	$re = '/^[0-9]+$/i';
	return preg_match($re,$value);
}

function validate_letters_only($value){
	$re = '/^[a-zA-Z\-& ]+$/i';
return preg_match($re,$value);
}

function validate_numbers_alpha($value){
	$re = '/^[0-9a-zA-Z\-& ]+$/i';
return preg_match($re,$value);
}

function validate_screens($value){
	$re = '/^[0-9a-zA-Z\-. ]+$/i';
return preg_match($re,$value);
}
function validate_alphanumeric($value){
	$re = '/^[0-9a-zA-Z\-.+& ]+$/i';
return preg_match($re,$value);
}

function validate_textfield($value){
	$re = '/^[0-9a-zA-Z\-.+,_ ]+$/i';
return preg_match($re,$value);
}

function validate_alphanumeric_dashes($value){
	$re = '/^[0-9a-zA-Z_\-]+$/i';
return preg_match($re,$value);
}

function validate_alphanumeric_x($value){
	$re = '/^[0-9a-zA-Z_\-/()]+$/i';
return preg_match($re,$value);
}

function rowz($dbc,$alter){
	$clause="";
	if($alter!=""){
	$clause=" AND score>=$alter";
	}
	//echo "SELECT * FROM users".$clause;
	$sql_user_rows=$dbc->prepare("SELECT * FROM users WHERE calculated='YES'".$clause) or die(mysqli_error($dbc));
	$sql_user_rows->execute() or die(mysqli_error($dbc));
	$result_rows=$sql_user_rows->get_result();
	$num_rows=$result_rows->num_rows;
	return $num_rows;
}

function eligible_to_predict($dbc,$pid){
	$sql=$dbc->prepare("SELECT * FROM users WHERE (pid=? AND eligible='YES') OR (pid=? AND free='YES') LIMIT 1");
	$sql->bind_param("ss",$pid,$pid);
	$sql->execute();
	$result_booted=$sql->get_result();
	$num_rows=$result_booted->num_rows;
	return $num_rows;
}

function result_average($dbc,$alter){
	$clause="";
	if($alter!=""){
	$clause=" WHERE score>=$alter";
	}
	$num_rows=rowz($dbc,$alter);
	$sql_user=$dbc->prepare("SELECT SUM(score) AS scores FROM users  WHERE calculated='YES'".$clause);
	$sql_user->execute();
	$result_user=$sql_user->get_result();
	$row_num_user=$result_user->num_rows;	
	$scores=0;
	if($row_num_user>0){
	$users=$result_user->fetch_assoc();
	$scores=$users['scores']/$num_rows;
	}
	return ceil($scores);
}
function reducePercentage($home_win_percentage=0,$draw_percentage=0,$away_percentage=''){
	$percentages=[$home_win_percentage,$draw_percentage,$away_percentage];
	 for($k=0; $k<count($percentages); $k++){
			 if($percentages[$k]==''){
				array_slice($percentages,$k,1);
			 }
		 } 
		//print_r($percentages);
	if(array_sum($percentages)>100 || array_sum($percentages)==99){
		$highestNum=$percentages[0];
		$elem=0;
		 for($i=0; $i<count($percentages); $i++){
			 if($percentages[$i]>$highestNum){
				$highestNum=$percentages[$i];
				$elem=$i;
			 }
		 }
		 $newPercentage=[];
		 $theElemt=0;
		 for($j=0; $j<count($percentages); $j++){
			 if($elem==$j && $percentages[$j]>1){
				 if(array_sum($percentages)>100){
				$theElemt=$percentages[$j]-1;
				 }else{
				$theElemt=$percentages[$j]+1;	 
				 }
			 }else{
				 $theElemt=$percentages[$j];
			 }
			array_push($newPercentage,$theElemt); 
		 }
		 $percentages=$newPercentage;
}
//print_r($percentages);
return $percentages;
		 }
function table_field($dbc,$table,$field,$req='',$value=''){
	$where='';
	if(!empty($req)){
		$where=" WHERE ".$req."='".$value."'";
	}
	$sql_user=$dbc->prepare("SELECT * FROM ".$table.$where);
	$sql_user->execute();
	$result_user=$sql_user->get_result();
	$row_num_user=$result_user->num_rows;	
	$response='';
	if($row_num_user>0){
	$users=$result_user->fetch_assoc();
	$response=$users[$field];
	}
	return $response;
}

function getTotalFunds($array,$funds,$rates){
	$array->execute();
	$result_user=$array->get_result();
	$row_num_user=$result_user->num_rows;
$totalPrice=0;	
	if($row_num_user>0){
		$i=0;
		$price=0;
	$lastScore=array();
	while($users=$result_user->fetch_assoc()){
	$predictorID=$users['pid'];
	$predictorScore=$users['score'];
	//echo $predictorScore;
	$lastSaved=end($lastScore);
	$price=$funds * $rates[$i];
	$totalPrice+=$price;
	//echo $price;
	if($predictorScore!==$lastSaved){
	$i++;
	}
	array_push($lastScore,$predictorScore);
	}
	}
	return $totalPrice;
}
?>