<?php
    session_start();
    if (!isset($_SESSION['username']) && !isset($_SESSION['id'])){
        echo "<script type=\"text/javascript\">window.alert('To view profile, you need to login.Redirecting to Login Page');window.location.href = './index.php';</script>";
        //header("location:index.php");
    }
    
    else{
        $username=$_SESSION['username'];
    }

    $other_user = '';

    function test_input($data) {
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }
    include "connection.php";

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $other_user = test_input(($_GET["value"]));
        
        if($other_user == $username){
            header('location:profile-page.php');
        }
    }
        
        //check username in db
        $results = mysqli_query($con,"SELECT username FROM user WHERE username='$other_user'");
        
        //return total count
        $username_exist = mysqli_num_rows($results); //total records
        
        //if value is more than 0, username is not available
        if($username_exist<=0) {            
            echo "<script type=\"text/javascript\">window.alert('The username does not exist');window.location.href = './profile-page.php';</script>";
        }

        else{
            $_SESSION['other_user'] = $other_user;
        
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Profile Page of <?php echo $other_user; ?></title>
  <link rel="icon" type="image/ico" href="img/tracker.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

    <!--link rel="stylesheet/less" href="less/bootstrap.less" type="text/css" /-->
    <!--link rel="stylesheet/less" href="less/responsive.less" type="text/css" /-->
    <!--script src="js/less-1.3.3.min.js"></script-->
    <!--append ‘#!watch’ to the browser URL, then refresh the page. -->
    
    <link rel="stylesheet" type="text/css" href="./lib/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="./lib/css/bootstrap-typeahead.css"/>
    <link rel="stylesheet" type="text/css" href="./lib/css/jqueryui.css"/>
    <link rel="stylesheet" type="text/css" href="./lib/leaflet/leaflet.label.css" />
    <link rel="stylesheet" type="text/css" href="./lib/leaflet/leaflet.css" /> 
    <link rel="stylesheet" type="text/css" href="./lib/css/typeahead.css" />
    <link rel='stylesheet' type="text/css" href='./lib/css/MarkerCluster.css'  />
    <link rel="stylesheet" type="text/css" href='./lib/css/MarkerCluster.Default.css'/>
    <link rel="stylesheet" type="text/css" href="./css/select-profile.css"/>


  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
  <![endif]-->

  <!-- Fav and touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="./profile/img/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="./profile/img/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="./profile/img/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="./profile/img/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="img/favicon.png">

  
    <script type="text/javascript" src="./lib/js/jquery.min.js"></script>
    <script type="text/javascript" src="./lib/js/bootstrap.js"></script>
    <script type="text/javascript" src="./lib/js/jqueryui.js"></script>
    <script type="text/javascript" src="./lib/js/bootstrap-typeahead.js"></script>
    <script type="text/javascript" src="./lib/leaflet/leaflet.js"></script>
    <script type="text/javascript" src="./lib/leaflet/leaflet.label.js"></script>    
    <script type="text/javascript" src='./lib/js/leaflet.markercluster.js'></script>
    <script type="text/javascript" src = "./js/activity.js"></script>
    <script type="text/javascript" src="./js/select-profile.js"></script>
    <script type="text/javascript" src = "./js/common-activity.js"></script>
</head>

<body>

<img src="./img/loading.gif" id="loading-indicator" style="display:none" />

<!-- Navigation -->

<nav class="navbar navbar-default" id = "navbar" role="navigation" style="height:78px">
    <div class="container-fluid">

        <div class="navbar-header"> 
            <!--<a class="navbar-brand navbar-left pull-left" href="./profile-page.php" style="float:left;margin-bottom:2px;margin-left:0px;">
                <img title = "Go Back" alt="Brand" src="img/back.png" style="float:left;margin-left:0px;margin-bottom:2px;height:50px;width:50px;" >                
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
            <a class="navbar-brand" title= "Click to view Notifications" data-toggle="modal" data-target="#notificationModal" style="margin-bottom:5px;margin-left:15px;">  
                <button type="button" id="notifications" class="btn btn-default btn-lg" style="margin-bottom:5px;margin-left:15px;">
                    <img title= "Click to view Notifications" name ="notification" alt="Brand" src="img/no-notification.png" style="height:18px;width:18px;" />
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
        <div class="col-md-4 column">
            <div class="panel panel-default" style="height:37.5vw;width:25vw">
                <div class="panel-heading text-center">
                    <h1 class="panel-title"><h2 style="font-weight:bold"><?php echo $other_user; ?></h2></h1>
                </div>
                <div class="panel-body text-center" id="profile-picture">
                    <div id = "buttons-groups">
                            <button type="button" id = "friend" style="display:none" class="btn btn-success">Connected</button>
                            <button type="button" id = "unfriend" style="display:none" class="btn btn-danger">Disconnect</button>
                            <button type="button" id = "addAsFriend" style="display:none" class="btn btn-primary">Connect</button>
                            <button type="button" id = "friendRequestSent" style="display:none" class="btn btn-warning">Friend Request Sent</button>
                     </div>
                </div>
                <div class="panel-footer">
                    <div class="row clearfix">
                        <div id="track-record">
                            
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
        <div class="col-md-8 column">
            <div class="row clearfix">
                <div class="panel panel-default" style="height:37.5vw;width:67vw">
                    <div class="panel-heading">
                        <h1 class="panel-title"><h3><?php echo $other_user; ?>'s Check-Ins<h3/></h1>
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
                        <div id="modalContentFollowing"><h2></h2></div>                        
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
                        <div id="modalContentFollowers"><h2></h2></div>                        
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
<?php } ?>
</body>
</html>