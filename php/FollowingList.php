<?php 
	
	session_start();

  	if (isset($_SESSION['username']) && isset($_SESSION['id'])){

    	$user_name = $_SESSION['username'];
    	$id = $_SESSION['id'];

    	include "connection.php";
        
        $trackee_sql = "SELECT * FROM `relation` WHERE `user_id`= ' " .$id ." ' && `person_id` != ' " .$id. " ' && `p_2_u` = 1";
        $trackee_result = mysqli_query($con,$trackee_sql) or die(mysqli_error($con));
        
        if($trackee_result){
            while($row = mysqli_fetch_array($trackee_result)){
                $user_id = $row[1];
                $user_sql = "SELECT `username` FROM `user` WHERE `id` = $user_id ";
                $user_result = mysqli_query($con,$user_sql) or die(mysqli_error($con));
                $user_array = mysqli_fetch_array($user_result);
                $json_encoder[] = array($row[0] => array($user_array['username']));
            }
        }

        echo(json_encode($json_encoder));
    }	

	else{
  		echo 'not logged in';
	}
?>