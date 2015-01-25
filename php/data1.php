<?php

  session_start();

  if (isset($_SESSION['username']) && isset($_SESSION['id'])){

    $user_name = $_SESSION['username'];//name is stored in session not to loose in reload
    $id = $_SESSION['id'];

    include "connection.php";

    $sql2 = "SELECT * FROM `relation` WHERE `person_id`= '$id' AND `p_2_u` = 1 AND `person_id`!=`user_id`" ;

    $result2 = mysqli_query($con, $sql2) or die(mysqli_error($con)); 

    $num = mysqli_num_rows($result2);


    if ($num<=0){

        $json = array($user_name=>array("false"));
        echo(json_encode($json));
        exit();        
    }

    
    
    else{
      while ($rows = mysqli_fetch_array($result2)){

        $person_id = $rows[0];

        //echo "$person_id";

        $sql_time_check = "SELECT * FROM `mobile_check-in` WHERE `person_id` = '$person_id' ORDER BY `time` DESC LIMIT 1";
        $sql_result_check = mysqli_query($con,$sql_time_check) or die(mysqli_error($con));
        $row_result_check = mysqli_fetch_array($sql_result_check);
        $time_from_check = $row_result_check[5];  
              
        
        $sql_time_tracks = "SELECT * FROM `mobile_tracks` WHERE `person_id` = '$person_id' ORDER BY `time` DESC LIMIT 1";
        $sql_result_tracks = mysqli_query($con,$sql_time_tracks) or die(mysqli_error($con));
        $row_result_tracks = mysqli_fetch_array($sql_result_tracks);        
        $time_from_tracks = $row_result_tracks[5];
        
        
        date_default_timezone_set('Asia/Kathmandu');
	$date = date('Y-m-d H:i:s', time());
	
	$diff_from_check = strtotime($date) - strtotime($time_from_check);
	$minutes_passed_check = $diff_from_check/60;
	
	$diff_from_tracks = strtotime($date) - strtotime($time_from_tracks);
	$minutes_passed_tracks = $diff_from_tracks/60;
	
	$X = 0;
	$Y = 0;	
	$timee = '';
	
	if($minutes_passed_check >= $minutes_passed_tracks){
	
		$sql_time_tracks = "SELECT * FROM `mobile_tracks` WHERE `person_id` = '$person_id' ORDER BY `time` DESC LIMIT 1";
        	$sql_result_tracks = mysqli_query($con,$sql_time_tracks) or die(mysqli_error($con));
        	$row_result_tracks = mysqli_fetch_array($sql_result_tracks); 
        	$X = $row_result_tracks[2];
        	$Y = $row_result_tracks[3];
        	$timee = $row_result_tracks[5];
		
	}
	else{
		$sql_time_check = "SELECT * FROM `mobile_check-in` WHERE `person_id` = '$person_id' ORDER BY `time` DESC LIMIT 1";
	        $sql_result_check = mysqli_query($con,$sql_time_check) or die(mysqli_error($con));
        	$row_result_check = mysqli_fetch_array($sql_result_check);
	        $X = $row_result_check[2];
        	$Y = $row_result_check[3];
        	$timee = $row_result_check[5];
		
	}
	
        
        $sql = "SELECT * FROM `person`WHERE `person_id` = '" . $rows[0] . "'";
        $person_result = mysqli_query($con,$sql);
        //$rowsdata = mysqli_fetch_array($person_result);
        while($row1 = mysqli_fetch_array($person_result)){
          $acc = $row1[4];
          $imag_link = $row1[5]; 

          $W[] = array($row1[1] => array($rows[1],$X,$Y,$acc,$imag_link,$timee));     
        } 

        
                    
      } 
         echo (json_encode($W));             
    }

  }

  else{
    echo 'not logged in';
  }
?>