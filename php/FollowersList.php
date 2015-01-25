<?php 
	
	session_start();

  	if (isset($_SESSION['username']) && isset($_SESSION['id'])){

    	$user_name = $_SESSION['username'];
    	$id = $_SESSION['id'];

    	include "connection.php";
        
        $tracker_sql = "SELECT * FROM `relation` WHERE `person_id`= ' " .$id ." ' && `user_id` != ' " .$id. " ' && `p_2_u` = 1";
        $tracker_result = mysqli_query($con,$tracker_sql) or die(mysqli_error($con));
        
        if($tracker_result){
            while($row = mysqli_fetch_array($tracker_result)){
                $user_id = $row[0];
                $user_sql = "SELECT `username` FROM `user` WHERE `id` = $user_id ";
                $user_result = mysqli_query($con,$user_sql) or die(mysqli_error($con));
                $user_array = mysqli_fetch_array($user_result);
                $json_encoder[] = array($row[1] => array($user_array['username']));
            }
        }

        echo(json_encode($json_encoder));
    }	

	else{
  		echo 'not logged in';
	}
?>