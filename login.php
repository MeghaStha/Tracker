<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <link href="./bootstrap/css/bootstrap.css" rel="stylesheet" />
    <link href="./css/font-awesome.min.css" rel="stylesheet" />
    <!--<link href="./css/style.css" rel="stylesheet" />-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <!--<link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="./bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap-formhelpers.min.css">
    <script src="./jqueryui/js/jquery.min.js"></script>
    <script src="./jqueryui/js/jquery.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
    <script src="./bootstrap/js/bootstrap-formhelpers.min.js"></script>
    <title>Tracker Registration Page</title>


    <style>
        body {
            font-family: 'Open Sans', sans-serif;   
        }

        .pad-top {
            padding-top:40px;
        }

    </style>

</head>
<body>
    <div class="container">
        <div class="row text-center pad-top ">
            <div class="col-md-12">
                <h2>Tracker Registration Page</h2>
            </div>
        </div>
         <div class="row pad-top">
               
                <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                        <strong>   Register Yourself </strong>  
                            </div>
                            <div class="panel-body">
                                <form role="form">
    <br/>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"  ></i></span>
                                            <input type="text" class="form-control" placeholder="Desired Username" value="" pattern="[a-zA-Z0-9]+" required autofocus/>
                                        </div>
                                     <div class="form-group input-group">
                                            <span class="input-group-addon">@</span>
                                            <input type="text" class="form-control" placeholder="Your Email" />
                                     </div>
                                         <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"  ></i></span>
                                            <select id="countries_phone1" class="form-control bfh-countries" data-country="Nepal"></select>
                                            <br/><br/>
                                            <input type="text" class="form-control bfh-phone" placeholder="Phone Number" data-country="countries_phone1" />
                                        </div>
                                      <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"  ></i></span>
                                            <input type="password" class="form-control" placeholder="Enter Password" />
                                        </div>
                                     <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"  ></i></span>
                                            <input type="password" class="form-control" placeholder="Retype Password" />
                                        </div>
                                     
                                     <a href="#" class="btn btn-success ">Register Me</a>
                                    <hr />
                                    Already Registered ?  <a href="./index.php" >Login here</a>
                                </form>
                            </div>
                           
                        </div>
                    </div>
                
                
        </div>
    </div>

   
</body>
</html>
