<?php
	//this page is created for the deletion of the user who we are viewing me
	//or no more wants them to view my location
	//stop them from viewing my location
	

	session_start();
	include 'connection.php';
	$other_user = $_SESSION['other_user'];
	//step1
	//get the user id from the session
	$my_id = $_SESSION['id'];
 
	//step2
	//get the person id from the client side
	$other_id_query = "SELECT id FROM `user` WHERE `username`='" . $other_user . "'";
    $other_id_result = mysqli_query($con,$other_id_query) or die(mysqli_error($con));
    $other_id_row = mysqli_fetch_array($other_id_result);
	$other_user_id = $other_id_row[0];
	print_r($other_user_id);
	print_r($my_id);
	
	//remove this relation from relation table and also the request table
	
	//remove from relation where uid = $id_of_person_viewing_me and person_id = $my_id
	mysqli_query($con,"UPDATE `relation` SET p_2_u = 0 WHERE `user_id`='$my_id' AND `person_id` = '$other_user_id'");
	//$query = "DELETE FROM `relation` WHERE `person_id` = '" . $other_user_id . "' && `user_id` = '" . $my_id . "'";
	//mysqli_query($con,$query) or die(mysqli_error($con));
	

?>