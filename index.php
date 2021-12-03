<?php 
include "includes/session.php"; 
include "database/connect.php"; 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Predict</title>
	<script type="text/javascript" src="js/jquery-1.12.3.js"></script> 
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="fontawesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<meta name="fb-url" property="og:url"           content="<?php  ?>https://www.domain.com/" />
	<meta name="fb-website" property="og:type"          content="website" />
	<meta name="fb-title" property="og:title"         content="Predict and win" />
	<meta name="fb-description" property="og:description"   content="Weekly predictions" />
	<meta name="fb-image" property="og:image"         content="https://www.domain.com/path/image.jpg" />	
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta content='#d81c1c' name='theme-color' />
	<link href="https://fonts.googleapis.com/css?family=Quicksand|Rajdhani|Titillium+Web|Open+SansBree+Serif" rel="stylesheet">
<script src="js/bootstrap.min.js"></script>
</head>
	<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
  
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header" >
	
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/"><img src="images/logo.png" /></a>
	<?php 
	 if(isset($_SESSION['user_id'])){
	?>
	  <a class="btn play-btn mobile" href="/">Play</a> 
	 <?php
	 }else{
	 ?>
	 <a class="btn play-btn sign-in mobile" href="/">Play</a> 
	 <?php
	 }
	 ?>
    </div>
	<?php 
	 if(isset($_SESSION['user_id'])){
	?>
	  <a class="btn play-btn desktop" href="/">Play</a> 
	 <?php
	 }else{
	 ?>
	 <a class="btn play-btn sign-in desktop" href="/">Play</a> 
	 <?php
	 }
	 ?>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
	  <li class="signin-link"><a href="leaderboard/">Leaderboard</a></li>
	   <li class="signin-link"><a href="how-to-play/">How To Play</a></li>
      <?php
	if(isset($_SESSION['user_id'])){
		$usrid=$_SESSION['user_id'];
		$pid=$_SESSION['pid'];
	?>
	<li><a class="profile" href="#" data-toggle="modal" data-target="#myModal">My Profile</a></li>
	<li class="hidden"><a href="../user/"><i class="far fa-newspaper" aria-hidden="true"></i><span class="get-result" data-target="<?php echo $pid; ?>">My Results</span> </span> <span class="badge fds"></span></a></li>
	<?php
	}else{
		$pid="";
	?>
	<li class="hidden"><a href=""><span class="get-result" data-target="<?php echo $pid; ?>">My Results Results</span></a></li>
	<?php
	}
	?>
    <?php
	
	 if(isset($_SESSION['user_id'])){
	?>
	<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Hi <?php echo ucfirst($_SESSION['firstname']); ?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="logout.php">Sign Out</a></li>
          </ul>
        </li>
	<?php	 
	 }else{
	?>
     <li class="signin-link"><a class="sign-in" href="">Sign In </a> / <a class="sign-up" href="../register/"> Sign Up</a></li>
	<?php	 
	 }
	?>
      </ul>
	  
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
 
</nav>
<div class="toolbar container">
</div>
<div class="container-fluid controls">
	<div class="col-sm-4 col-xs-4 mobile"><span class="result-btn selected" data-type="fixtures">Fixtures</span></div>
	<div class="col-sm-4 col-xs-4 mobile"><span class="result-btn" data-type="general_results">Results</span></div>
	<div class="col-sm-4 col-xs-4 mobile"><span class="get-result summary-btn result-btn" data-type="user_results" data-target="<?php echo $pid; ?>">Summary</span></div>
	</div>
	<div class="toolbar container mobile">
	</div>

	<div class="body-container container">
	
	<div class="row" style="margin:0 auto;">
	<p class="alert alert-success msg-alert"></p>
	<div class="col-sm-4 col-md-4 col-12 float-left mobile-wrap general_results">
	<div class="view_results_wrap float-left">
	<p  class="desktop headings">Results</p>
			<div class="view_results float-left">
				<p class="loading-results"></p>
			</div>
	 </div>
	 </div>
	 <div class="col-sm-12 col-md-5 col-12 float-left fixtures">
	<p class="desktop headings">Fixtures</p>
	 <div class="view_predictions">
	 <p class="loading-fixtures"></p>
	 </div>
	 </div>
	 <div class="col-sm-12 col-md-3 col-12 mobile-wrap user-scores user_results">
	 <?php
	 include "includes/register.php";
	 include "includes/login.php";



 if(isset($_SESSION['pid'])){
		 ?>
		 <div class="toggle-user-result">
			<p class="desktop headings">Prediction Summary</p>
			<div class="row total-score" style="margin-bottom:10px;">
						<div class="col-sm-6 col-md-6 col-xs-7"></div>
						<div class="col-sm-6 col-md-6 col-xs-5">
						<p class="score-wrap">Total Score: <span class="badge view_user_score"></span></p>
						</div>
					</div>
			
					<div class="user-results">
					<div class="view_user-results">
						<p class="loading-results"></p>
					</div>
					</div>
			 </div> 
		<?php
	 }else{
	 ?>
		<div class="row form_wrap signin_wrap">
		<div class="col-sm-12 col-md-12">
		<p class="h4 center">Sign In</p>
		<div id="register_user" class="form_ad_sign"> 
		<div class="msg"></div>
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
					  <div class="form-group">
					  <label for="Email">Email:</label>
					<input type="text" class="form-control" name="email" size="51" id="email" placeholder="Username" value="<?php echo isset($email) ? $email : '' ?>">
					</div>
					<div class="form-group">
					  <label for="Password">Password:</label>
						<input type="password" class="form-control" name="password" id="password" size="51" placeholder="Password">
					</div>
					<a href="../forgot-password/">Forgot password?</a> <input type="submit" name="login" value="Sign In" class="register_button btn btn-primary">
					
					</form>
				   <div class="sign_in"><span>If you have not register, Please <a class="sign-up" href="#">Sign up</a></div>
					</div>

					</div><!---end of form wrapper-->
					</div><!---end of form wrapper-->
		<div class="row form_wrap register_wrap">
		
		</div>
	 <?php
	 }
	 ?>
	 <br/>
	 <ul class="list-group link-group">
	 <li class="list-group-item"><a href="about-us/">About Us</a></li>
	 <li class="list-group-item"><a href="terms-of-use/">Terms of Use</a></li>
	 <li class="list-group-item"><a href="privacy">Privacy</a></li>
	 <li class="list-group-item"><a href="contact-us/">Contact Us</a></li>
	 
	 </ul>
	 </div>
	 </div>
	</div>
	
	<div class="register_form hidden">
	<div class="col-sm-12 col-md-12">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
			<div class="form-group">
			<label for="Email">First name:<sup>*</sup></label>
			<input id="fname_fld" class="form-control" title="First name must not be blank and contain only letters." type="text"  name="firstname" value="<?php echo isset($fitstname) ? $firstname : '' ?>" size="51" placeholder="First name">
			</div>
			<div class="form-group">
			<label for="Email">Last name:<sup>*</sup></label>
			<input id="lname_fld" class="form-control" title="Last name must not be blank and contain only letters." type="text"  name="lastname" value="<?php echo isset($lastname) ? $lastname : '' ?>" size="51" placeholder="Last name">
			</div>
			<div class="form-group">
			<label for="Email">Email:<sup>*</sup></label>
			<input id="email_fld" class="form-control" title="Your Email address is required." value="<?php echo isset($email) ? $email : '' ?>" type="text" name="email" size="51" placeholder="Email">
			</div>
			<div class="form-group">
			<label for="Email">Password:<sup>*</sup></label>
			<input id="password_fld1" class="form-control" type="password" title="Password must contain at least 6 characters, including UPPER/lowercase and numbers."  name="password" size="51" placeholder="Password">
			</div>
			<div class="form-group">
			<label for="Email">Confirm Password:<sup>*</sup></label>
			<input id="password_fld2" class="form-control" title="Please enter the same Password as above." type="password"  name="password2" size="51" placeholder="Confirm Password">
			</div>
			<input type="submit" name="register" value="Register" class="register_button register_btn btn">
			</form>
			<br/>
			<br/>
		   <div id="sign_in"><span>Already Registered? Please </span><a class="sign-in" href="#">Sign in</a></div>
			</div>
			</div>
	</div>
	<template class="predictions-template">
	<?php include "template/board.php"; ?>
	</template>
	
	<template class="results-template">
	<div class="row result-line">
		<div class="col-sm-1 col-xs-1 col-md-1 float-left">#--num--</div>
		<div class="col-sm-5 col-xs-5 col-md-5 float-left">--predictor--</div>
		<div class="col-sm-4 col-xs-4 col-md-4 float-left">&#8358;--price--</div>
		<div class="col-sm-1 col-xs-1 col-md-1 float-left"><span class="badge">--score--</span></div>
	</div>
	</template>
	
	<template class="user-results-template" style="display:none;">
	<div class="row result-line report-line">
		<div class="col-sm-12 col-xs-12 col-md-12 float-left result-head" style="text-align:center;">--teams-- <span class="badge">--report--</span></div>
		<div class="col-sm-6 col-xs-6 col-md-6 float-left reports" style="text-align:center;"><p>Prediction</p> --played--</div>
		<div class="col-sm-6 col-xs-6 col-md-6 float-left reports" style="text-align:center;"><p>Result</p> --play_result--</div>
	</div>
	</template>
	
	 <form id="paymentForm" class="hidden">
  <div class="form-group">
    <label for="email">Email Address</label>
    <input type="email" id="email-address" value="<?php echo isset($_SESSION['user_id']) ? table_field($dbc,"users","email","pid",$pid) : '' ?>" required />
  </div>
  <div class="form-group">
    <label for="amount">Amount</label>
    <input type="tel" id="amount" value="200" required />
  </div>
  <div class="form-group">
    <label for="first-name">First Name</label>
    <input type="text" value="<?php echo isset($_SESSION['user_id']) ? table_field($dbc,"users","firstname","pid",$pid) : '' ?>" id="first-name" />
  </div>
  <div class="form-group">
    <label for="last-name">Last Name</label>
    <input type="text" value="<?php echo isset($_SESSION['user_id']) ? table_field($dbc,"users","firstname","pid",$pid) : '' ?>" id="last-name" />
  </div>
  <div class="form-submit">
    <button type="submit" class="pay" onclick="payWithPaystack()"> Pay </button>
  </div>
</form>

<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-md profile-modal">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">My Profile</h4>
        </div>
        <div class="modal-body">
        <form method="post" action="" class="profile-form">
		<p>Enter details the same as your bank account.</p>
		  <div class="form-group">
		  <label for="email">Firstname</label>
		  <input class="form-control" placeholder="First name" name="firstname" value="<?php
		  echo isset($_SESSION['pid']) ? table_field($dbc,"users","firstname","pid",$pid) : '';
		  ?>" />
		  </div>
		  <div class="form-group">
		  <label for="email">Lastname</label>
		  <input class="form-control" placeholder="Last name" name="lastname" value="<?php
		  echo isset($_SESSION['pid']) ? table_field($dbc,"users","lastname","pid",$pid) : '';
		  ?>"/>
		  </div>
		  <div class="form-group">
		  <label for="email">Phone</label>
		  <input class="form-control" placeholder="Tel" name="tel" value="<?php
		  echo isset($_SESSION['pid']) ? table_field($dbc,"users","tel","pid",$pid) : '';?>"/>
		  </div>
		  <div class="form-group">
		  <label for="email">Bank account numer</label>
		  <input class="form-control" placeholder="Account Number" name="account" value="<?php
		  echo isset($_SESSION['pid']) ? table_field($dbc,"users","account_no","pid",$pid) : '';?>"/>
		  </div>
		  <div class="form-group">
		  <label for="email">Email</label>
		  <input class="form-control" placeholder="Email" name="email" value="<?php echo isset($_SESSION['pid']) ? table_field($dbc,"users","email","pid",$pid) : '';?>" />
		  </div>
		  <div class="form-group">
		  <input class="form-control get-bank" placeholder="bank" type="hidden" value="<?php echo isset($_SESSION['pid']) ? table_field($dbc,"users","bank","pid",$pid) : '';?>"/>
		  </div>
		  <div class="form-group">
		  <label for="email">Bank</label>
				<select class="form-control custom-select take-bank" id="bank" name="bank">
				  <option selected>--Select Bank--</option>
				  <option value="this">This Bank</option>
				  <option value="that">That Bank</option>
				  <option value="your">Your Bank</option>
				  <option value="our">Our Bank</option>
				</select>
		  </div>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" target="profile-form" class="btn btn-default edit-user updating-profile" style="color:#fff;">Save</button>
        </div>
      </div>
    </div>
  </div>
</div>
 <?php mysqli_close($dbc); ?>
<script src="https://js.paystack.co/v1/inline.js"></script> 
<script>
const qsl=document.querySelector.bind(document);
const qslAll=document.querySelectorAll.bind(document);
let start=0;
let per_page=20;
const btn = document.querySelector("body");
var paymentForm = document.getElementById('paymentForm');
paymentForm.addEventListener('submit', function(e){
    e.preventDefault();
});

 $(function(){
    $(document).on('click','.options',function(e){
	let prediction=$(this).attr("caption");
	let id=$(this).attr("target");
	let choice=$(this).attr("data-choice");
	$.ajax({
		type:"POST",
		url:"predictions.php",
		data:{"id":id,"prediction":prediction,"choice":choice},
		success:function(data){
			data=JSON.parse(data);
			for(x in data){
				if(data[x].login==undefined){
					if(data[x].eligibility!=undefined){
						alertMessage("You are not eligible to predict, kindly make payment for today's entry","warning")
					setTimeout(()=>{
					document.querySelector(".play-btn").click();
					},5000);
					}else{
				let classes = Object.keys(data[x]);
				for(let i=0; i<classes.length; i++){
					//console.log(classes[i]);
					let obj=classes[i];
					
				if(document.querySelector("."+data[x].section+id)!=null){
					document.querySelectorAll("."+data[x].section+id).forEach((sect,i)=>{
						let votes=document.querySelectorAll("."+data[x].section+id+" .num_votes")[i].innerHTML;
						if(votes!='0'){
						sect.classList.remove("hidden");
						}
					});
				}
				
					if(document.querySelector("."+classes[i])!=null){
					document.querySelector("."+classes[i]).innerHTML=data[x][obj];
					
					
					if(classes[i].includes("_percentage")){
					let progress = classes[i].replace("_percentage","_progress");
					document.querySelectorAll("."+progress).forEach((pro)=>{
						pro.style.width=data[x][obj];
					});
					}
					}
				}
				}
				}else{
				//location.href="sign-in/";
				if(screen.width<=800){
				document.querySelector(".summary-btn").click();
				}
			}
			}
			
		},
	});
	  
    });
	
	$(document).on('change','.team-list select',function(){
	var league=$(this).val();
	$.ajax({
				url:"fixtures.php",
				type:"POST",
				data:{"league":league,"owner":browse},
				beforeSend:function(){
					 $('.loading-league').show().html("<i class='fa fa-spinner fa-spin' aria-hidden='true'></i> Loading "+league+" fixtures...");				
				},
				complete:function(){
					 $('.loading-league').show().html(""); 
				},
				success: function (data){
					data=JSON.parse(data);
					data.forEach((dat)=>{
						//console.log(data);
					})
					//$(".prediction-section").html(data).scrollTop(0);	
				}
			
			});
});
btn.addEventListener("click",function(e){
	if(e.target.classList.contains("play-btn")){
		document.querySelector(".pay").click();
		e.preventDefault();
	}
});
btn.addEventListener("click",function(e){
	if(e.target.classList.contains("get-result") || e.target.classList.contains("result-btn")){
	let pid=e.target.getAttribute("data-target")!=null ? e.target.getAttribute("data-target") : 0;
	//console.log(pid)
	let type=e.target.getAttribute("data-type");
	let uri ="";
	let templateDiv="";
	let data="";
	document.querySelector(".fixtures").style.display="none";
	document.querySelectorAll(".mobile-wrap").forEach((btn)=>{
			btn.style.display="none";
		});
	if(type=="user_results"){
	uri ="calculate.php";
	templateDiv="user-results";
	data={"start":start,"per_page":per_page,"pid":pid}
	fillTemplates(templateDiv,uri,data,"results");
	}else if(type=="general_results"){
			uri ="results.php";
			 templateDiv="results";
			 data={"league":"all"}
			fillTemplates(templateDiv,uri,data,"results");
	}else if(type=="fixtures"){
			let uri ="fixtures.php";
			let templateDiv="predictions";
			let data={"league":"all"}
			fillTemplates(templateDiv,uri,data,"fixtures");
	}
	document.querySelector("."+type).style.display="block";
	e.preventDefault();
	}
});

btn.addEventListener("click",function(e){
	if(e.target.classList.contains("sign-up")){
		if(screen.width<=800){
				document.querySelector(".summary-btn").click();
				}
		document.querySelector(".form_wrap").style.display="none";
		document.querySelector(".register_wrap").style.display="block";
		let registerForm=document.querySelector(".register_form").innerHTML;
		document.querySelector(".register_wrap").innerHTML=registerForm;
		e.preventDefault();
	}else if(e.target.classList.contains("sign-in")){
		if(screen.width<=800){
		document.querySelector(".summary-btn").click();
		}
		document.querySelector(".register_wrap").style.display="none";
		document.querySelector(".signin_wrap").style.display="block";
		e.preventDefault();
	}
});

btn.addEventListener("click",function(e){
	if(e.target.classList.contains("result-btn")){
		document.querySelectorAll(".result-btn").forEach((btn)=>{
			btn.classList.remove("selected");
		});
		e.target.classList.add("selected");
	}
});
setInterval(function(){
gatherResults(start,per_page);	
start+=20;
},180000);
let uri ="fixtures.php";
let template="predictions";
let data={"league":"all"}
fillTemplates(template,uri,data,"fixtures");

let resultURI ="results.php";
let templateDiv="results";
data={"league":"all"}
fillTemplates(templateDiv,resultURI,data,"results");

setInterval(function(){
fillTemplates(templateDiv,resultURI,data,"results");
},300000);

	let userURI ="calculate.php";
	let templateUserResult="user-results";
	let pid=document.querySelector(".get-result").getAttribute("data-target");
	if(pid!=""){
	let userData={"start":start,"per_page":per_page,"pid":pid}
	fillTemplates(templateUserResult,userURI,userData,"results");
	}

setTimeout(function(){
let alertBox =document.querySelector(".returned-message");	
if(alertBox!=null){
	let msg = document.querySelector(".returned-message").innerHTML;
	if(document.querySelector(".returned-message").classList.contains("signups")){
		document.querySelector(".sign-up").click();
	}
	let type = document.querySelector(".returned-message").getAttribute("target");
	type=='error' ? type='warning' : type='success';
	alertMessage(msg,type);	
}
 });
 
 },500);
 
  setTimeout(()=>{
 let bank = document.querySelector(".get-bank").value;
 document.querySelector(".take-bank").value=bank;
  },2000);


function fillTemplates(templateDiv,uri,data,type){
$.ajax({
url:uri,
type:"POST",
data:data,
beforeSend:function(){
	 $('.loading-'+type).show().html("<i class='fa fa-spinner fa-spin' aria-hidden='true'></i> Loading "+type+"...");				
},
complete:function(){
	 $('.loading-'+type).show().html(""); 
},
success: function (data){
	let board='';
	let templateHolder='';
	data=JSON.parse(data);
				for(x in data){
						template =document.querySelector("."+templateDiv+"-template").innerHTML;
						template=cloneElements("."+templateDiv+"-template");
						const keys= Object.keys(data[x]);
						const keysLen= Object.keys(data[x]).length;
						let currentPid=0;
						let resultArray=[];
						let keyArray=['total_score','total_outcome','one_five','two_five','three_five'];
						let keyIndex, toBeReplaced, object;
						for(let j=0; j<keysLen; j++){
							keyIndex=(keys[j]);
							toBeReplaced= new RegExp("--"+keyIndex+"--","gi");
							object=keys[j];
							template=template.replace(toBeReplaced,data[x][object]);
							if(data[x][object]=="no predictions"){
								template='<p class="alert alert-danger">You have not made predictions</p>';
							}
							if(keyArray.indexOf(keyIndex)!=-1){
							currentPid=data[x].pid;
							resultArray[keyIndex]=data[x][object];
							}
							if(qsl(".view_"+keyIndex)!=null){
								qsl(".view_"+keyIndex).innerHTML=data[x][object];
							}
						}
						templateHolder+=template;
						qsl(".view_"+templateDiv).innerHTML=templateHolder;
						let reportDiv=0;
						  for(let k=0; k<keyArray.length; k++){
							reportDiv=resultArray[keyArray[k]];
							 if(Number(reportDiv)>0 && qsl(".report-div-"+keyArray[k]+currentPid)!=null){
								setTimeout(()=>{
								qsl(".report-div-"+keyArray[k]+currentPid).classList.remove("hidden");
								},200);
							}
						}  
					}	
}

});
 } 

function cloneElements(elem){
	 let template='';
	 if(qsl("."+elem)!=null){
	 let clone = qsl("."+elem);
	template = clone.content.cloneNode(true);
	let newDiv = document.createElement("div");
	newDiv.append(template);
	template=newDiv.innerHTML;
	 }
	return template;
 }
 
function alertMessage(msg,type){
	 const alertBox =document.querySelector(".alert");
	 document.querySelector(".alert").innerHTML=msg;
	 type=="warning" ? alertBox.setAttribute('class','alert alert-danger msg-alert') : alertBox.setAttribute('class','alert alert-success msg-alert');
	 alertBox.classList.add("show");
	 setTimeout(()=>{
		  alertBox.classList.remove("show");
	 },7000);
 }
 
function gatherResults(start,per_page){
		$.ajax({
		type:"POST",
		url:"calculate.php",
		data:{"start":start,"per_page":per_page},
		success:function(data){
			//console.log(data);
		},
	});
}
function sendProfile(){
	   const http = new XMLHttpRequest();
		let url="profile.php";
		let parameters='';
		document.querySelectorAll(".profile-form input, .profile-form select").forEach((input)=>{
			parameters+=input.name+"="+input.value+"&";
		});
		parameters=parameters.slice(0,-1);
		console.log(parameters);
     http.open("POST",url, true);	
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	document.querySelector(".updating-profile").innerHTML="Updating...";
    http.onload = function(){
        if(http.status===200){
		if(http.responseText=="success"){
		setTimeout(function(){
			document.querySelector(".updating-profile").innerHTML="Updated!";
			},2000);
			
		setTimeout(function(){
			document.querySelector(".updating-profile").innerHTML="Save";
			},3000);
		}
		}
	}
	http.send(parameters); 
 }
 
function generateToken(){
	 let newToken='',covertThis,letter;
	 let token = Math.floor(Math.random() * new Date().getTime()) + 1;
	 const alphabet = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];
	 token=String(token).split("");
	 let k=0;
	 token.forEach((tk)=>{
		  k = Math.floor(Math.random() * 25) + 1;
		  k = k%3==0 ? k: tk;
		  k = Number(k);
		  convertThis= Math.floor(Math.random() * 31) + 1;
		  console.log(k);
		  console.log(alphabet[k]);
		  letter= alphabet[k];
		  newToken+= convertThis%2 == 0 ? letter : tk;
	 });
	 return newToken;
 }
function payWithPaystack() {
	let userEmail=document.getElementById('email-address').value;
  var handler = PaystackPop.setup({
    key: 'pk_test_654cb5b019249273184c772006fe1149f691c04e', // Replace with your public key
    email: document.getElementById('email-address').value,
    amount: document.getElementById('amount').value * 100, // the amount value is multiplied by 100 to convert to the lowest currency unit
    currency: 'NGN', // Use GHS for Ghana Cedis or USD for US Dollars
    ref: generateToken(), // Replace with a reference you generated
	channels: ['card', 'bank', 'ussd', 'mobile_money', 'bank_transfer'],
    callback: function(response) {
      //this happens after the payment is completed successfully
      var reference = response.reference;
      //alert('Payment complete! Reference: ' + reference);
      // Make an AJAX call to your server with the reference to verify the transaction
	  setTimeout(()=>{
	  	$.ajax({
				url:"transactions.php",
				type:"POST",
				data:{"email":userEmail,"reference":reference},
				beforeSend:function(){
					 $('.loading-verification').show().html("Verifying transaction...");				
				},
				complete:function(){
					 $('.loading-verification').show().html(""); 
				},
				success: function (data){
					if(data.trim()=="success"){
						alertMessage('Payment complete! Reference: ' + reference,"success");
					}else{
						alertMessage('Oops Something went wrong! Reference: ' + reference,"warning");
					}
				}
			
			});
			},200);
    },
    onClose: function() {
      alertMessage('Transaction was not completed','warning');
    },
  });
  handler.openIframe();
}

 document.querySelector(".edit-user").addEventListener("click", function(e){
	 e.target.classList.add("btn");
	sendProfile();
 });
</script>
	</body>
</html>