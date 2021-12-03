<?php 
include "../includes/session.php"; 
include "../database/connect.php"; 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Predict</title>
	<script type="text/javascript" src="../js/jquery-1.12.3.js"></script> 
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../fontawesome/css/font-awesome.min.css">
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
	<h3 class="heading">About us</h3>
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
		<article>
		<p>About Us</p>
        </article>
		</div>
	</div>
	</div>

	</body>
</html>