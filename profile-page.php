<?php
    session_start();
    if (!isset($_SESSION['username']) && !isset($_SESSION['id'])){
        echo "<script type=\"text/javascript\">window.alert('To view profile, you need to login.Redirecting to Login Page');window.location.href = './index.php';</script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="img/favicon.png">
  <meta charset="utf-8">
  <title>Profile Page of <?php echo $_SESSION['username']; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

    <link rel="icon" type="image/ico" href="img/tracker.png">

    <link rel="stylesheet" type="text/css" href="./lib/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="./lib/css/bootstrap-typeahead.css"/>
    <link rel="stylesheet" type="text/css" href="./lib/css/jqueryui.css"/>
    <link rel="stylesheet" type="text/css" href="./lib/leaflet/leaflet.label.css"/>
    <link rel="stylesheet" type="text/css" href="./lib/leaflet/leaflet.css" /> 
    <link rel="stylesheet" type="text/css" href="./lib/css/typeahead.css" />
    <link rel='stylesheet' type="text/css" href='./lib/css/MarkerCluster.css'  />
    <link rel="stylesheet" type="text/css" href='./lib/css/MarkerCluster.Default.css'/>
    <link rel="stylesheet" type="text/css" href="./css/profile-page.css"/>
  
    <script type="text/javascript" src="./lib/js/jquery.min.js"></script>
    <script type="text/javascript" src="./lib/js/bootstrap.js"></script>
    <script type="text/javascript" src="./lib/js/jqueryui.js"></script>
    <script type="text/javascript" src="./lib/js/bootstrap-typeahead.js"></script>
    <script type="text/javascript" src="./lib/leaflet/leaflet.js"></script>
    <script type="text/javascript" src="./lib/leaflet/leaflet.label.js"></script>    
    <script type="text/javascript" src='./lib/js/leaflet.markercluster.js'></script>
    <script type="text/javascript" src = "./js/activity.js"></script>
    <script type="text/javascript" src = "./js/profile-page.js"></script>
    <script type="text/javascript" src = "./js/common-activity.js"></script>
    
</head>

<body>

<img src="./img/loading.gif" id="loading-indicator" style="display:none" />

<!-- Navigation -->

<nav class="navbar navbar-default" id = "navbar" role="navigation" style="height:78px">
    <div class="container-fluid">

        <div class="navbar-header"> 
            <a class="navbar-brand" href="#" style="margin-bottom:2px;margin-top: -5px;">                
                <img alt="Brand" src="img/KLL.png" style="margin-bottom:2px;height:60px;width:80px;" >
            </a>
            <!--<a class="navbar-brand navbar-left pull-left" href="./interface.php" style="float:left;margin-bottom:2px;margin-left:0px;">
                <img title = "Home" alt="Brand" src="img/back.png" style="float:left;margin-left:0px;margin-bottom:2px;height:50px;width:50px;" >                
            </a>-->
            <a href="./interface.php" title = "Click to go to Interface page" style="float:left;margin-top:15px;margin-left:0px;">
                <button type="button" class="btn btn-default btn-lg">
                    <span class="glyphicon glyphicon-home"></span> Home 
                </button>
            </a>
            
            <a class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
            </a>
            <a class="navbar-brand" title= "Click to view Notifications" data-toggle="modal" data-target="#notificationModal" style="margin-bottom:5px;margin-left:15px;">  
                <button type="button" id="notifications" class="btn btn-default btn-lg" style="margin-bottom:5px;margin-left:15px;">
                    <img name ="notification" alt="Brand" src="img/no-notification.png" style="height:18px;width:18px;" />
                </button>
            </a>
        </div>

        <ul class="nav navbar-nav navbar-right" title= "Click to logout this session" style="margin-right:25px; margin-top:10px;">
            <button id = "signout" type="button" class = "btn btn-default btn-lg">Logout</button>

            <!--<li class="active"><a href="./logout.php">SignOut</a></li>
            <li>&nbsp;</li>-->
        </ul>

        <form class="navbar-form" title= "Search your friends on Tracker" role="search" action="search.php" method="post">
            <div class="form-group" style="display:inline;">
              <input class="form-control" type="text" name="query" style = "width:50%; margin-left:70px; margin-top:10px" id="query" placeholder="Search friends">
            </div>
            <a type="submit" class="btn btn-primary" style="margin-top:10px" style="display:inline;" id="button"><span class="glyphicon glyphicon-search"></span></a>
        </form>


    </div>
</nav>



<div class="container">
    <div class="row clearfix">
        <div class="col-md-4 column" id="panel-profile">
            <div class="panel panel-default" style="height:37.5vw;width:25vw">
                <div class="panel-heading text-center">
                    <h1 class="panel-title"><h2 style="font-weight:bold"><?php echo $_SESSION['username']; ?><h2/></h1>
                </div>
                <div class="panel-body text-center" id="profile-picture"></div>
                <div class="panel-footer">
                    <div class="row clearfix">
                        <div id="track-record">
                        	<br/>
                            	<div>
                            		<div class="col-md-6 column" id="check-in"></div>
	                            	<div class="col-md-6 column" id="tracks"></div>
                            	</div>
                            	
                            	<div>
                            		<div class="col-md-6 column" id="followers"><br/></div>
	                            	<div class="col-md-6 column" id="following"><br/></div>
        	                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 column" id="panel-map">
            <div class="row clearfix">
                <div class="panel panel-default" style="height:37.5vw;width:67vw">
                    <div class="panel-heading">
                        <h1 class="panel-title"><h3>Your Check-Ins<h3/></h1>
                    </div>
                    <div class="panel-body">
                        <div id="map" style="height:29.5vw"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="followingList" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">List of Following</h4>
                    </div>

                    <div class="modal-body">
                        <div id="modalContentFollowing"></div>                        
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="followersList" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">List of Followers</h4>
                    </div>

                    <div class="modal-body">
                        <div id="modalContentFollowers"></div>                        
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!--modal-->

<div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Notifications</h4>
                </div>

                <div class="modal-body">
                    <div id="modalContent_notifications"></div>
                </div>
            </div>
        </div>
</div>

<!--modal-->

</body>
</html>