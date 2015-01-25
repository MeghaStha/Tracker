<?php
    session_start();
    if (!isset($_SESSION['username']) && !isset($_SESSION['id'])){
        echo "<script type=\"text/javascript\">window.alert('Enter Username and Password.Redirecting to Login Page');window.location.href = './index.php';</script>";
        //header("location:index.php");
    }
    $directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']); 

    // make a note of the location of the upload handler script 
    $uploadHandler = 'http://' . $_SERVER['HTTP_HOST'] . $directory_self . './upload.processing.php'; 

    // set a max file size for the html upload form     
    $max_file_size = 1000000; // size in bytes
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">    

    <title>Web Tracker Interface</title>   

    <link rel="icon" type="image/ico" href="img/tracker.png">
    <link type="text/css" rel="stylesheet" href="./css/stylish-portfolio.css"/>
    <link rel="stylesheet" href="./lib/leaflet/leaflet.label.css" />
    <link rel="stylesheet" href="./lib/css/jqueryui.css"/>
    <link rel="stylesheet" href="./lib/leaflet/leaflet.css" />    
    <link rel="stylesheet" href="./lib/css/bootstrap.css">
    <link rel="stylesheet" href="./css/override-navbar.css">
    <link type="text/css" rel="stylesheet" href=".lib/font-awasome/css/font-awesome.min.css"/>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/interface.css">
    
    <script type="text/javascript" src = "./js/activity.js"></script>
    <script type="text/javascript" src="./lib/js/jquery.js"></script>
    <script type="text/javascript" src="./lib/js/jqueryui.js"></script>
    <script type="text/javascript" src="./lib/js/jquery.form.js"></script>
    <script type="text/javascript" src="./lib/leaflet/leaflet.js"></script>
    <script type="text/javascript" src="./lib/leaflet/leaflet.label.js"></script>    
    <script type="text/javascript" src="./lib/js/bootstrap.min.js"></script>    
    <script type="text/javascript" src = "./js/interface.js"></script>
    <script type="text/javascript" src="./js/photo-upload.js"></script>

</head>

<body>

    <img src="./img/loading.gif" id="loading-indicator" style="display:none" />

    <!-- Navigation -->
    <nav class="navbar navbar-default" id = "navbar" role="navigation" style="height:78px">

        <div class="navbar-header"> 
            <a class="navbar-brand" href="#" style="margin-bottom:2px;margin-top: -5px;">                
                <img alt="Brand" src="img/KLL.png" style="margin-bottom:2px;height:60px;width:80px;" >
            </a>
            
            <!--<a href="./interface.php" title = "Click to go to Interface page" style="float:left;margin-top:15px;margin-left:0px;">
            	<button type="button" class="btn btn-default btn-lg">
                	<span class="glyphicon glyphicon-home"></span> Home 
                </button>
            </a>-->
            
            <a href="./profile-page.php" title= "Click to go to profile" style="float:left;margin-bottom:2px;margin-left:20px;margin-top:15px">
                <button type="button" class="btn btn-default btn-lg">
                    	<span class="glyphicon glyphicon-user"></span> Profile
                </button>
            </a>
            
            <a class="navbar-brand" data-toggle="modal" data-target="#notificationModal">  
                <button type="button" id="notifications" class="btn btn-default btn-lg" style="position:relative;right:-930px;" title= "Click to view Notifications">
                    <img title= "Click to view Notifications" name ="notification" alt="Brand" src="img/no-notification.png" style="height:20px;width:18px;" />
                </button>
            </a>
        </div>

        <span style="text-align:center"><p class="navbar-text"><h3 style="color:white"><strong>Welcome <?php echo $_SESSION['username']; ?></strong></h3></p></span>
        

        <div id="menu-toggle" title= "Click for more options" href="#" class="btn btn-dark btn-lg toggle"><span class="glyphicon glyphicon-align-justify"></span></div>
        <nav id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <a id="menu-close" title= "Click to close" href="#" class="btn btn-light btn-lg pull-right toggle"><i class="fa fa-times"></i></a>
                <li class="sidebar-brand">
                    <a href="#top">You are in Home</a>
                </li>
                
                
                <!--<li>
                        <a href="profile-page.php" title= "Click to go to profile page">Profile</a>
                </li>-->
                
                <br/>

                <li>
                    
                    <a data-toggle="modal" data-target="#photoModal" title= "Click to upload your profile picture">Upload Photo</a>
                    <!--<button class="btn btn-default" data-toggle="modal" data-target="#loginModal">Login</button>-->

                </li>
                
                <br/>

                <li>
                    <a href="./logout.php" title= "Click to logout the session">SignOut</a>
            
                </li>
            </ul>
        </nav>
    </nav>


    <!-- Home -->
    <header id="top" class="header">
        <div id="map"></div>
    </header>

    <div class="modal fade" id="photoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Choose Photo</h4>
                </div>

                <div class="modal-body">
                    <!-- The form is placed inside the body of modal -->
                    <form enctype="multipart/form-data" id="fileupload" method="post" class="form-horizontal" action="<?php echo $uploadHandler ?>" >
                        <div class="form-group">
                            <div class="col-md-5">
                                <input type="file" class="form-control" name="image_file" id="imageInput" />
                                <div class="context"><br/><h4><?php echo'Maximum file size is 1 MB'; ?></h4></div><br/>
                                <button class="btn btn-success btn-lg btn-primary btn-block" id="submit">Upload</button>
                                <img src="./img/loading_indicator.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
                                <div id="output"></div>
                            </div>
                        </div>
                    </form>
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