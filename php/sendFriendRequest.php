<?php

	session_start();
	include 'connection.php';
	$other_user = $_SESSION['other_user'];
	$my_id = $_SESSION['id'];
	
	//get the current timestamp
	date_default_timezone_set('Asia/Kathmandu');
	$date = date('Y-m-d H:i:s', time());
 
	//get the person id from the client side
	$other_id_query = "SELECT id FROM `user` WHERE `username`='" . $other_user . "'";
    $other_id_result = mysqli_query($con,$other_id_query) or die(mysqli_error($con));
    $other_id_row = mysqli_fetch_array($other_id_result);
	$other_user_id = $other_id_row[0];
	


	$query = "SELECT * FROM `relation` WHERE `user_id` = '$my_id' && `person_id` = '$other_user_id'";
	$result = mysqli_query($con,$query) or die(mysqli_error($con));
	$result_row = mysqli_fetch_array($result);

	if($result_row){
		//print("UPDATE `relation` SET p_2_u = 1,date = NOW() WHERE `person_id`=' " .$my_id. " ' && `user_id` = ' " .$other_user_id. "'");
		//exit();
		mysqli_query($con,"UPDATE `relation` SET p_2_u = 2,date = '$date' WHERE `user_id`=' " .$my_id. " ' && `person_id` = ' " .$other_user_id. "'");
	}
	else{
		mysqli_query($con,"INSERT INTO `relation` ".
				"(user_id,person_id,p_2_u,date) ".
                "VALUES ".
                "('$my_id','$other_user_id',2,'$date')");
	}
	

?>