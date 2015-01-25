<?php 
	session_start();
	if (!isset($_SESSION['username']) && !isset($_SESSION['id'])){
        echo "<script type=\"text/javascript\">window.alert('To view tracks, you need to login.Redirecting to Login Page');window.location.href = './index.php';</script>";
        //header("location:index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <link rel="shortcut icon" href="img/favicon.png">

    <title>Tracks of
        <?php echo $_SESSION[ 'other_user']; ?>
    </title>

    <link rel="icon" type="image/ico" href="img/tracker.png">
    <meta charset="UTF-8" />

    <link rel="icon" type="image/ico" href="img/tracker.png" />

    <link rel="stylesheet" type="text/css" href="./lib/css/jqueryui.css" />
    <link rel="stylesheet" type="text/css" href="./lib/leaflet/leaflet.label.css" />
    <link rel="stylesheet" type="text/css" href="./lib/leaflet/leaflet.css" />
    <link rel="stylesheet" type="text/css" href="./lib/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="./lib/css/bootstrap-typeahead.css" />
    <link rel="stylesheet" type="text/css" href="./lib/css/typeahead.css" />
    <link rel='stylesheet' type="text/css" href='./lib/css/MarkerCluster.css' />
    <link rel="stylesheet" type="text/css" href='./lib/css/MarkerCluster.Default.css' />
    <link rel="stylesheet" type="text/css" href="./css/tracker-interface.css">


    <script type="text/javascript" src="./js/activity.js"></script>
    <script type="text/javascript" src="./lib/js/jquery.min.js"></script>
    <script type="text/javascript" src="./lib/js/jqueryui.js"></script>
    <script type="text/javascript" src="./lib/leaflet/leaflet.js"></script>
    <script type="text/javascript" src="./lib/leaflet/leaflet.label.js"></script>
    <script type="text/javascript" src='./lib/js/leaflet.markercluster.js'></script>
    <script type="text/javascript" src="./lib/leaflet/leaflet.polylineDecorator.min.js"></script>
    <script type="text/javascript" src="./lib/js/bootstrap.js"></script>
    <script type="text/javascript" src="./lib/js/bootstrap-typeahead.js"></script>
    <script type="text/javascript" src="./js/common-activity.js"></script>
    <script type="text/javascript" src="./js/tracker-interface-user.js"></script>


</head>

<body>

    <nav class="navbar navbar-default" id="navbar" role="navigation" style="height:78px">
        <div class="container-fluid">

            <div class="navbar-header">
                <!--<a class="navbar-brand navbar-left pull-left" href='profile-page.php' style="float:left;margin-bottom:2px;margin-left:0px;">
                    <img title="Go Back" alt="Brand" src="img/back.png" style="float:left;margin-left:0px;margin-bottom:2px;height:50px;width:50px;">
                </a>-->
                
                <a href="./interface.php" title = "Click to go to Interface page" style="float:left;margin-top:15px;margin-left:0px;">
                	<button type="button" class="btn btn-default btn-lg">
                    		<span class="glyphicon glyphicon-home"></span> Home 
                	</button>
            	</a>
            
            	<a href="./profile-page.php" title= "Click to go to profile" style="float:left;margin-bottom:2px;margin-left:20px;margin-top:15px">
                	<button type="button" class="btn btn-default btn-lg">
                    		<span class="glyphicon glyphicon-user"></span> Profile
                	</button>
            	</a>
            	
                <a class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                </a>
                <a class="navbar-brand" title="Click to view Notifications" data-toggle="modal" data-target="#notificationModal" style="margin-bottom:5px;margin-left:15px;">
                    <button type="button" id="notifications" class="btn btn-default btn-lg" style="margin-bottom:5px;margin-left:15px;">
                        <img title="Click to view Notifications" name="notification" alt="Brand" src="img/no-notification.png" style="height:18px;width:18px;" />
                    </button>
                </a>
            </div>

            <ul class="nav navbar-nav navbar-right" title="Click to logout this session" style="margin-right:25px; margin-top:10px;">
                <button id="signout" type="button" class="btn btn-default btn-lg">Logout</button>

                <!--<li class="active"><a href="./logout.php">SignOut</a></li>
		            <li>&nbsp;</li>-->
            </ul>

            <form class="navbar-form" title="Search your friends on Tracker" role="search" action="search.php" method="post">
                <div class="form-group" style="display:inline;">
                    <input class="form-control" type="text" name="query" style="width:50%; margin-left:70px; margin-top:10px" id="query" placeholder="Search friends">
                </div>
                <a type="submit" class="btn btn-primary" style="margin-top:10px" style="display:inline;" id="button"><span class="glyphicon glyphicon-search"></span></a>
            </form>

        </div>
    </nav>

    <div id="map"></div>
    <img src="./img/loading.gif" id="loading-indicator" style="display:none" />

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