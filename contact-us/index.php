<?php 
include "../includes/session.php"; 
include "../database/connect.php"; 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Predictor</title>
	<script type="text/javascript" src="../js/jquery-1.12.3.js"></script> 
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css" />
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta content='#d81c1c' name='theme-color' />
	<link href="https://fonts.googleapis.com/css?family=Quicksand|Rajdhani|Titillium+Web|Open+SansBree+Serif" rel="stylesheet">
	<script src="../js/bootstrap.min.js"></script>
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
      <a class="navbar-brand" href="/"><img src="../images/logo.png" /></a>
	
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
	   <li class="signin-link"><a href="../leaderboard/">Leaderboard</a></li>
	   <li class="signin-link"><a href="../how-to-play/">How To Play</a></li>
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
			 <li class="signin-link"><a class="sign-in" href="../">Sign In </a> / <a class="sign-up" href="../register/"> Sign Up</a></li>
			<?php	 
			 }
			?>
      </ul>
	  
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
 
</nav>

<!---<span id="timer"></span>-->
	<div class="container">
	<div class="top-heading" style="margin-top:70px;">
	<h3 class="heading">Contact us</h3>
	</div>
	<div class="row" style="margin-top:30px;">
	<div class="col-sm-3 col-md-3 col-xs-12">
		<ul class="list-group link-group">
	 <li class="list-group-item"><a href="../about-us/">About Us</a></li>
	 <li class="list-group-item"><a href="../terms-of-use/">Terms of Use</a></li>
	 <li class="list-group-item"><a href="../privacy/">Privacy</a></li>
	 <li class="list-group-item"><a href="../contact-us/">Contact Us</a></li>
	 
	 </ul>
	</div>
	<div class="col-sm-9 col-md-0 col-xs-12">
		<div class="row">
     <div class="col-sm-9 message-form">
		</p>Email:email@email.com</p>
        <div class="form-group">
            <label for="message">Message</label>
            <textarea name="message" id="message" class="form-control required" placeholder="Write your message here" cols="30" rows="5"></textarea>
        </div>
                <div class="form-group mt-2">
                        <label for="name">Name</label>
                        <input name="name" id="name" placeholder="Name" class="form-control required"/>
                </div>
                <div class="form-group mt-2">
                        <label for="email">Email</label>
                        <input name="email" id="email" placeholder="Email" class="form-control required"/>
                </div>
                <div class="form-group mt-2">
                        <label for="phone">Phone</label>
                        <input name="phone" id="phone" placeholder="Phone number" class="form-control required"/>
                </div>
				<p class="alert alert-success" style="display:none;"></p>
        <div class="form-group">
            <br/>
                <button class="btn btn-success float-right submit-btn" data-target="message">Send</button>
            </div>
     </div> 
	  <div class="col-sm-3"> </div> 
	  </div>
		</div>
	</div>
	</div>

<script>
  const submitBtn = document.querySelector(".message-form");
  submitBtn.addEventListener("click",(e)=>{
	  if(e.target.classList.contains("submit-btn") 	|| e.target.parentElement.classList.contains("submit-btn")){
		  sendForm(e,'send.php');
	  }
  });
  
  ['keyup','change'].forEach((event)=>{
	   submitBtn.addEventListener(event,(e)=>{
	  if(e.target.classList.contains("required") || e.target.classList.contains("required")){
		  e.target.style="border-color:#ccc;";
	  }
  });
  });
  
  async function sendForm(e,url){
	  if(e.target.classList.contains("submit-btn")	|| e.target.parentElement.classList.contains("submit-btn")){
		  let formdata= new FormData();
		  let formTarget = e.target.getAttribute("data-target") || e.target.parentElement.getAttribute("data-target");
		
		  let formInputs=document.querySelectorAll("."+formTarget+"-form .required");
		  let error=0;
		
		  formInputs.forEach((input)=>{
			  if(input.value==""){
				  error++;
				  input.style="border-color:red";
			  }
			  formdata.append(input.name, input.value);  
		  });
		  if(error!==0){
				  return;
			 }
		 let response = await fetch(url,{
			 method: 'POST',
			 body: formdata
		 });
		 result= await response.text();
		 
		 if(result.trim()=='sent'){
				        let msg="Thank You, we  will get back to you shortly";
						alert("success","block",msg,4000);
				 }else{
					 let msg="Message not sent";
						alert("danger","block",msg,8000);
			}
	  }
 }
 
  function alert(type,display,msg,timer){
      document.querySelector(".alert").setAttribute("class","alert alert-"+type);
	document.querySelector(".alert").style=`display:${display}`;
	document.querySelector(".alert").innerHTML=msg;
	setTimeout(()=>{
	    document.querySelector(".alert").style="display:none;";
	},timer);
  }
</script>
	</body>
</html>