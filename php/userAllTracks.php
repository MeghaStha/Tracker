<?php 
  
  session_start();

    if (isset($_SESSION['username']) && isset($_SESSION['id'])){

        //$user_name = $_SESSION['username'];
        //$id = $_SESSION['id'];

        $user = $_SESSION['other_user'];

        include "connection.php";        

        $sql_user = "SELECT distinct (track_id) FROM `mobile_tracks` WHERE `username`='$user' ORDER BY `time` DESC";
        $tracks = mysqli_query($con,$sql_user) or die(mysqli_error($con));


        foreach ($tracks as $k=>$v){
            //echo $k;
            //echo("\n");
            $tid = $v['track_id'];
            //echo($tid);
            //echo("\n");

            //select all x, y with track_id as $v['track_id'] and current person_id
            $query_coord = mysqli_query($con,"SELECT X_coord,Y_coord,time FROM `mobile_tracks` WHERE `track_id` = '$tid' && `username`='$user'") or die(mysqli_error($con));
            
            $rows = mysqli_num_rows($query_coord);
            
            if($rows>=4){
	            while($result_coord = mysqli_fetch_assoc($query_coord)){
                	$json_encoder[] = array($result_coord['X_coord'],$result_coord['Y_coord'],$result_coord['time']);
            	}

            	$js = array($tid => $json_encoder);
            	$a[] = (($js));
            	unset($json_encoder);
            }
        }
        echo(json_encode($a));
    }
  
    else{
        echo 'not logged in';
    }
?>