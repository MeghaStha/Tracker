<?php
	session_start();
	if (isset($_SESSION['username']) && isset($_SESSION['id'])){
		header('Location:interface.php');
	}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Tracker</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <link rel="icon" type="image/ico" href="img/tracker.png" />
    <link rel="stylesheet" type="text/css" href="./lib/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="./lib/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="./lib/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" type="text/css" href="./lib/css/bootstrap-formhelpers.min.css" />
    <link rel="stylesheet" type="text/css" href="./css/fill-navbar.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    
	<script type="text/javascript" src="./lib/js/TweenLite.min.js"></script>
    <script type="text/javascript" src="./lib/js/jquery.min.js"></script>
    <script type="text/javascript" src="./lib/js/jquery.js"></script>
    <script type="text/javascript" src="./lib/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./lib/js/bootstrap-formhelpers.min.js"></script>
    <script type="text/javascript" src="./js/login.js"></script>

</head>

<body>

	<div id="navigation_bar">
		<nav class="navbar navbar-default" role="navigation">

			<!-- Collection of nav links and other content for toggling -->
	        <div id="navbarCollapse" class="collapse navbar-collapse">
	            <ul class="nav navbar-nav">
	                <li><a href="#">Home</a></li>
	                <li><a href="http://kathmandulivinglabs.org/pages/details/about_us" target="_blank">About Us</a></li>
	                <li><a href="#">About Tracker</a></li>
	                <li><a href="http://kathmandulivinglabs.org/blog/" target="_blank">Blog</a></li>
	                <li><a href="http://kathmandulivinglabs.org/contact" target="_blank">Leave Feedback</a></li>
	            </ul>
	        </div>
		</nav>
	</div>

	<div class="container">
	    <div class="row">
	        <div class="col-sm-6 col-md-4 col-md-offset-4">
	            <h1 class="text-center login-title" style="color:yellow">Sign in to continue</h1>

	            <div class="account-wall">
	                <img class="profile-img" src="./img/tracker1.png" height="120" width="120" alt="Login">

	                <form type="submit" class="form-signin" method="post">
		                <input type="text" class="form-control" id="username" name="name" placeholder="Username" pattern="[a-zA-Z0-9]+" required autofocus>
		                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
		                <button class="btn btn-success btn-lg btn-primary btn-block" id="submit">Sign in</button>
			        	<a href="#" class="pull-right need-help">Need help? </a><span class="clearfix"></span>
	                </form>

	            </div>

	            <a href="./signup.php" id="new_content" class="text-center new-account" style="color:white">Create an account </a>

	        </div>
	    </div>
	</div>

</body>

</html>