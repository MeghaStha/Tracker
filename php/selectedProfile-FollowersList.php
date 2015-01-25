<?php 
	
	session_start();

  	if (isset($_SESSION['username']) && isset($_SESSION['id'])){

    	$user_name = $_SESSION['username'];
    	$id = $_SESSION['id'];
        $other_user = $_SESSION['other_user'];

    	include "connection.php";

        $other_id_query = "SELECT id FROM `user` WHERE `username`='" . $other_user . "'";
        $other_id_result = mysqli_query($con,$other_id_query) or die(mysqli_error($con));
        $other_id_row = mysqli_fetch_array($other_id_result);
        $other_user_id = $other_id_row[0];
        
        $tracker_sql = "SELECT * FROM `relation` WHERE `person_id`= ' " .$other_user_id ." ' && `user_id` != ' " .$other_user_id. " ' && `p_2_u` = 1";
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