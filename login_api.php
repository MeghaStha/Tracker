<?php

	if (isset($_SESSION['username']) && isset($_SESSION['id'])){
		unset($_SESSION['username']);
		unset($_SESSION['id']);
		session_destroy();
	}
	session_start();

	$name_input=$password_input=$password_from_db=$user_id="";

	include 'connection.php';
	
	function test_input($data){
       		$data = trim($data);
       		$data = stripslashes($data);
       		$data = htmlspecialchars($data);
       		return $data;
    	}
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
            $name_input = test_input(($_POST["username"]));
            $password_input = test_input(($_POST["password"]));
    	}
   
	$query_for_the_user = "SELECT * FROM user WHERE username = '" . $name_input . "'";
	$result_of_user = mysqli_query($con, $query_for_the_user) or die(mysqli_query($con));
	while ($rows = mysqli_fetch_array($result_of_user)){
		$password_from_db = $rows[4];
		$user_id = $rows[0];
	}
	
	$query_for_track_id = "SELECT MAX(track_id) AS max FROM `mobile_tracks` WHERE username = '".$name_input."' && person_id = '".$user_id."' ";
	$result_for_track_id = mysqli_query($con,$query_for_track_id) or die(mysqli_query($con));
	$rows_for_track_id = mysqli_fetch_array($result_for_track_id);
	$max_track_id = (int)$rows_for_track_id['max'];

	
//check if the input password is same as the one in the dbase_close(dbase_identifier)
	if (md5($password_input) == $password_from_db){

		$_SESSION['username'] = $name_input;
		$_SESSION['id'] = $user_id;
		echo $user_id.",".$max_track_id;

	}
	else{
		echo 0;
	}
?>