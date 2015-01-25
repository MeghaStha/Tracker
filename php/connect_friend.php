<?php

	session_start();
	include 'connection.php';
	$my_id = $_SESSION['id'];

	$request_id = $_POST['request_id'];
	
	//get the current timestamp
	date_default_timezone_set('Asia/Kathmandu');
	$date = date('Y-m-d H:i:s', time());
 
 	$sql = "UPDATE `relation` SET p_2_u = 1,date = '$date' WHERE `person_id`='$my_id' && `user_id` = '$request_id'";
 	$result = mysqli_query($con,$sql) or die(mysqli_error($con));
 	
?>