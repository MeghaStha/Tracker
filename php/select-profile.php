<?php 
	session_start();

    $other_user = $_SESSION['other_user'];
    $current_user = $_SESSION['username'];
    $id = $_SESSION['id'];
    //echo $other_user;

    include "connection.php";

    $other_id_query = "SELECT id FROM `user` WHERE `username`='" . $other_user . "'";
    $other_id_result = mysqli_query($con,$other_id_query) or die(mysqli_error($con));
    $other_id_row = mysqli_fetch_array($other_id_result);
    $other_user_id = $other_id_row[0];
    //print_r($other_id_row);

    $trackee_sql = "SELECT * FROM `relation` WHERE `user_id`= ' " .$other_user_id ." ' && `person_id` != ' " .$other_user_id. " ' && `p_2_u` = 1";
    $trackee_result = mysqli_query($con,$trackee_sql) or die(mysqli_error($con));

    $num_of_trackee = 0;

    $num = mysqli_num_rows($trackee_result);
        
    if($trackee_result){
        $num_of_trackee = $num;
    }
    else{
        $num_of_trackee = 0;
    }

    $tracker_sql = "SELECT * FROM `relation` WHERE `person_id`= ' " .$other_user_id ." ' && `user_id` != ' " .$other_user_id. " ' && `p_2_u` = 1 ";
    $tracker_result = mysqli_query($con,$tracker_sql) or die(mysqli_error($con));

    $num_of_tracker = 0;

    $num_ = mysqli_num_rows($tracker_result);
        
    if($trackee_result){
        $num_of_tracker = $num_;
    }
    else{
        $num_of_tracker = 0;
    }

    $track_sql = "SELECT distinct (track_id) FROM `mobile_tracks` WHERE `person_id`='" . $other_user_id . "'";
    $tracks = mysqli_query($con,$track_sql) or die(mysqli_error($con));

    $num_of_tracks = 0;
    
    if($tracks){
        	
		foreach ($tracks as $k=>$v){
		
			$tid = $v['track_id'];

			$query_coord = mysqli_query($con,"SELECT * FROM `mobile_tracks` WHERE `track_id` = '$tid' && `person_id`='$other_user_id'") or 		die(mysqli_error($con));
            		$rows = mysqli_num_rows($query_coord);
            	
            		if($rows>=4){
                		$num_of_tracks++;
            		}
            	}
    }
    
    else{
        	$num_of_tracks = 0;
    }

    /*$num_of_Tracks = mysqli_num_rows($tracks);

    if($tracks){
        $num_of_tracks = $num_of_Tracks;
    }

    else{
        $num_of_tracks=0;
    }*/

    $sql_image = "SELECT * FROM `user` WHERE `username`='" . $other_user . "'";
    $result_image = mysqli_query($con,$sql_image) or die(mysqli_error($con));
    $content_image = mysqli_fetch_array($result_image);
    $image_link='';
    
    if (!is_null($content_image[5])) {
        $image_link = $content_image[5];
    }
    else{
        $image_link='uploaded_files/person.jpg';
    }

    $viewable = 0;

    $query = "SELECT * FROM `relation` WHERE `user_id` = '" . $id . "' && `person_id` = '" . $other_user_id . "'";
    $query_result = mysqli_query($con,$query) or die(mysqli_error($con));
    $check_row = mysqli_fetch_array($query_result);

    if($check_row){
        $query_result = mysqli_query($con,$query) or die(mysqli_error($con));
        $check_row = mysqli_fetch_array($query_result);
        if($check_row[2]==1){
            $viewable=1;
        }
        elseif($check_row[2]==0){
            $viewable=0;
        }
        elseif($check_row[2]==2){
            $viewable = 2;
        }
    }
    else{
        $viewable = 0;
    }    

    //print_r($viewable);
    	
    	//starts here
    	$query_for_track_id = "SELECT MAX(track_id) AS max FROM `mobile_tracks` WHERE username = '".$current_user."' && person_id = '".$id."' ";
	$result_for_track_id = mysqli_query($con,$query_for_track_id) or die(mysqli_query($con));
	$rows_for_track_id = mysqli_fetch_array($result_for_track_id);
	$max_track_id = (int)$rows_for_track_id['max'];
	//ends here

        $num_rows=0;
        $sql_user = "SELECT * FROM `mobile_check-in` WHERE `person_id`='" . $other_user_id . "'";
        $result_user = mysqli_query($con,$sql_user) or die(mysqli_error($con));
        $checkin_row = mysqli_fetch_array($result_user);

        $number1 = mysqli_num_rows($result_user);

        if($checkin_row){
            $num_rows = $number1;
            $result_user = mysqli_query($con,$sql_user) or die(mysqli_error($con));
            while($row=mysqli_fetch_array($result_user)){
                $X = $row[2];
                $Y = $row[3];
                $time = $row[5];

                $json_encoder[] = array($row[0] => array($X,$Y,$num_rows,$image_link,$time,$num_of_trackee,$num_of_tracker,$num_of_tracks,$viewable));
            }
            echo(json_encode($json_encoder));
        }
        else{
            $num_rows=0;
            $json_encoder[] = array($id => array(0,0,$num_rows,$image_link,('2014-09-09 12:12:12'),$num_of_trackee,$num_of_tracker,$num_of_tracks,$viewable));
            echo(json_encode($json_encoder));
        }

?>