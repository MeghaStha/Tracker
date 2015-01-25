<?php
        //for local mysql
	// $dbhost="localhost";
	// $dbuser="root@localhost";
	// $dbpass="nahsop";
	// $db = "test123";
	// $con=mysqli_connect($dbhost,$user,$dbpass);
	
	//for 000webhost mysql dbase
	
         
   /* $mysql_host = "localhost:3306";
	$mysql_database = "tracker-kll";
	$mysql_user = "root";
	$mysql_password = "";*/
	
	$mysql_host = "localhost";
	$mysql_database = "ktmlabs_tracker-kll";
	$mysql_user = "ktmlabs_biplov";
	$mysql_password = "BiplovBhandari12345";
	
	$con = mysqli_connect($mysql_host,$mysql_user,$mysql_password,$mysql_database);
    	if (!$con){
		// echo json_encode('I am done');
		echo "Failed to connect to MySQL: " . mysqli_connect_errno();
    		exit();
  	}
    	return $con;  
?>