<?php

  session_start();

  if (isset($_SESSION['username']) && isset($_SESSION['id'])){

    $user_name = $_SESSION['username'];//name is stored in session not to loose in reload
    $id = $_SESSION['id'];

    include "connection.php";

    $sql2 = "SELECT * FROM `relation` WHERE `user_id`= '$id' AND `p_2_u` = 1 AND `person_id`!=`user_id`" ;

    $result2 = mysqli_query($con, $sql2) or die(mysqli_error($con)); 

    $num = mysqli_num_rows($result2);


    if ($num<=0){

        $json = array($user_name=>array("false"));
        echo(json_encode($json));
        exit();        
    }

    
    
    else{
      while ($rows = mysqli_fetch_array($result2)){

        $sql = "SELECT * FROM `person`WHERE `person_id` = '" . $rows[1] . "'";
        $person_result = mysqli_query($con,$sql);
	while($row1 = mysqli_fetch_array($person_result)){        	
          $X = $row1[2]; 
          $Y = $row1[3];
          $acc = $row1[4];
          $imag_link = $row1[5]; 
          $timee = $row1[6];
          
          if($X != null && $Y != null){

          	$W[] = array($row1[1] => array($X,$Y,$acc,$imag_link,$timee));     
          }
          
        }        
                    
      } 
         
         echo (json_encode($W));             
    }

  }

  else{
    echo 'not logged in';
  }
?>