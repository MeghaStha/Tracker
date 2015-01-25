<?php 
  
  session_start();

    if (isset($_SESSION['username']) && isset($_SESSION['id'])){

        $user_name = $_SESSION['username'];
        //echo $user_name;
        $id = $_SESSION['id'];
	//echo $id;

        include "connection.php";        

        $sql_user = "SELECT distinct (track_id) FROM `mobile_tracks` WHERE `username`='$user_name' && `person_id`='$id' ORDER BY `time` DESC LIMIT 1";
        $tracks = mysqli_query($con,$sql_user) or die(mysqli_error($con));

        foreach ($tracks as $k=>$v){
            //print "array[".$k."]===";
            //echo $k."\n k";
            $tid = $v['track_id'];
            //echo $tid."\n v";

            //select all x, y with track_id as $v['track_id'] and current person_id
            $query_coord = mysqli_query($con,"SELECT X_coord,Y_coord,time FROM `mobile_tracks` WHERE `track_id` = '$tid' && `username`='$user_name' && `person_id`='$id'") or 		die(mysqli_error($con));
            while($result_coord = mysqli_fetch_assoc($query_coord)){
                $json_encoder[] = array($result_coord['X_coord'],$result_coord['Y_coord'],$result_coord['time']);
            }

            $js = array($tid => $json_encoder);
            $a[] = (($js));
            unset($json_encoder);
        }
        echo(json_encode($a));
    }
  
    else{
        echo 'not logged in';
    }
?>