<?php
    session_start();
    if (isset($_SESSION['username']) && isset($_SESSION['id'])){
        header('Location:interface.php');
    }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Tracker Registration Page</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <link rel="stylesheet" type="text/css" href="./lib/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="./lib/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="./lib/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="./lib/css/bootstrap-formhelpers.min.css">
    <link rel="stylesheet" type="text/css" href="./lib/css/bootstrapValidator.min.css">
    <link rel="stylesheet" type="text/css" href="./css/signup.css" />

    <script type="text/javascript" src="./lib/js/jquery.min.js"></script>
    <script type="text/javascript" src="./lib/js/TweenLite.min.js"></script>
    <script type="text/javascript" src="./lib/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./lib/js/bootstrapValidator.min.js"></script>
    <script type="text/javascript" src="./js/signup.js"></script>

</head>

<body>
    <div class="container">
        <div class="row text-center pad-top ">
            <div class="col-md-12">
                <h2 style="color:yellow">Tracker Registration Page</h2>
            </div>
        </div>

        <div class="row pad-top">
            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>   Register Yourself </strong>
                    </div>

                    <div class="panel-body">
                        <form method="post" action="./upload.processor.php" id="defaultForm">

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"  ></i></span>
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Desired Username *" value="" pattern="[a-zA-Z0-9]+" required>
                                </div>
                                <span id="user-result"></span>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">@</span>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Your Email *" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"  ></i></span>
                                    <!--<select id="countries_phone1" class="form-control bfh-countries" data-country="Nepal"></select>
                                        <br/><br/> data-country="countries_phone1" -->
                                    <input type="text" name="phone" id="phone" class="form-control bfh-phone" maxlength="10" pattern="[0-9]{10}" placeholder="Phone Number">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"  ></i></span>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"  ></i></span>
                                    <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" placeholder="Retype Password" required>
                                </div>
                            </div>

                            <p height="1px">Note: * is Compulsory field</p>
                            <br/>
                            <hr/>
                            <div class="form-group">
                                <button id="register" class="btn btn-success btn-lg btn-primary btn-block" onclick="$('#loading').show();">Register Me</button>
                            </div>
                            <div id="loading" style="display:none;"><img src="./img/loading_indicator.gif" alt="" />Registering!</div>
                            <hr /> Already Registered ? <a href="./index.php" id="login_content">Login here</a>

                        </form>
                    </div>

                </div>
            </div>
            <div id="result"></div>
        </div>
    </div>

</body>

</html>