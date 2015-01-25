<?php 
	
	session_start();

  	if (isset($_SESSION['username']) && isset($_SESSION['id'])){

    	$user_name = $_SESSION['username'];
    	$id = $_SESSION['id'];

        //echo($id);

    	include "../connection.php";        

    	$sql_notifications = "SELECT * FROM `relation` WHERE `person_id`= '$id' && `p_2_u` = 2 ";
    	$result_notifications = mysqli_query($con,$sql_notifications) or die(mysqli_error($con));
        //$row_notifications = mysqli_fetch_array($result_notifications);
        $rows_notifications = mysqli_num_rows($result_notifications);

        if($rows_notifications){

            while($row_notifications = mysqli_fetch_array($result_notifications)){
                $request_user_id = $row_notifications[0];
                //echo($request_user_id);
                $sql_user = "SELECT `username` FROM `user` WHERE `id` = '$request_user_id'";
                $result_sql_user = mysqli_query($con,$sql_user) or die(mysqli_error($con));
                $row_user = mysqli_fetch_array($result_sql_user)[0];
                //echo($row_user);

                $json_encoder[] = array($request_user_id => array($row_user));
            }

            echo(json_encode($json_encoder));
        }
        else{
            $request_user_id = 0;
            $json_encoder[] = array($request_user_id => array('none'));
            echo(json_encode($json_encoder));
        }

    }
	
	else{
  		echo 'not logged in';
	}
?>