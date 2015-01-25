<?php

	if (isset($_SESSION['username']) && isset($_SESSION['id'])){
		unset($_SESSION['username']);
		unset($_SESSION['id']);
		session_destroy();
	}
	session_start();

	$name_input=$password_input="";

	include 'connection.php';
	
	function test_input($data){
       	$data = trim($data);
       	$data = stripslashes($data);
       	$data = htmlspecialchars($data);
       	return $data;
    }
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
            $name_input = test_input(mysql_real_escape_string($_POST["username"]));
            $password_input = test_input(mysql_real_escape_string($_POST["password"]));
    }
   
	$query_for_the_user = "SELECT * FROM user WHERE username = '" . $name_input . "'";
	$result_of_user = mysqli_query($con, $query_for_the_user) or die(mysql_query($con));
	while ($rows = mysqli_fetch_array($result_of_user)){
		$password_from_db = $rows[4];
		$user_id = $rows[0];
	}

	
//check if the input password is same as the one in the dbase_close(dbase_identifier)
	if (md5($password_input) == $password_from_db){
	//if (crypt($password_input, $password_from_db) == $password_from_db) {
		//set the session variables namm and id and use them to check in the rest of page
		//better way is to use a randomized token rather than the usee's credentials

		$_SESSION['username'] = $name_input;
		$_SESSION['id'] = $user_id;
		echo $_SESSION['id'];

	}
	else{
		//echo 'username password dont match';
		echo('username-password combination doesnot match');
		
	}
?>