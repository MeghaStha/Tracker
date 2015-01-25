<?php 
	
	session_start();

  	if (isset($_SESSION['username']) && isset($_SESSION['id'])){

    	$user_name = $_SESSION['username'];
    	$id = $_SESSION['id'];

    	include "../connection.php";

        $track_sql = "SELECT distinct (track_id) FROM `mobile_tracks` WHERE `username`='$user_name' && `person_id`='$id'";
        $tracks = mysqli_query($con,$track_sql) or die(mysqli_error($con));
        
        $num_of_tracks = 0;
        
        if($tracks){
        	
		foreach ($tracks as $k=>$v){
		
			$tid = $v['track_id'];

			$query_coord = mysqli_query($con,"SELECT * FROM `mobile_tracks` WHERE `track_id` = '$tid' && `username`='$user_name' && `person_id`='$id'") or 		die(mysqli_error($con));
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
        
        $trackee_sql = "SELECT * FROM `relation` WHERE `user_id`= ' " .$id ." ' && `person_id` != ' " .$id. " ' && `p_2_u` = 1";
        $trackee_result = mysqli_query($con,$trackee_sql) or die(mysqli_error($con));

        $num_of_trackee = 0;

        $num = mysqli_num_rows($trackee_result);
        
        if($trackee_result){
            //if(!$trakee_content[0] == $id){
                $num_of_trackee = $num;
                //print_r($other_user_id);
            //}
        }
        else{
            $num_of_trackee = 0;
        }


        $tracker_sql = "SELECT * FROM `relation` WHERE `person_id`= '$id' && `user_id` != '$id' && `p_2_u` = 1 ";
        $tracker_result = mysqli_query($con,$tracker_sql) or die(mysqli_error($con));

        $num_of_tracker = 0;

        $num_ = mysqli_num_rows($tracker_result);
        
        if($tracker_result){
            $num_of_tracker = $num_;
        }
        else{
            $num_of_tracker = 0;
        }


        $sql_image = "SELECT * FROM `user` WHERE `username`='" . $user_name . "'";
        $result_image = mysqli_query($con,$sql_image) or die(mysqli_error($con));
        $content_image = mysqli_fetch_array($result_image);
        $image_link='';
        //$image_link = $content_image[5];
        if (!is_null($content_image[5])) {
            $image_link = $content_image[5];
        } else {
            $image_link='uploaded_files/person.jpg';
        }
        

    	$sql_user = "SELECT * FROM `mobile_check-in` WHERE `person_id`='" . $id . "'";
    	$result_user = mysqli_query($con,$sql_user) or die(mysqli_error($con));
        $row_user = mysqli_fetch_array($result_user);
        $num_rows1 = mysqli_num_rows($result_user);

        $num_rows = 0;

        if($row_user){
            $num_rows = $num_rows1;
            $result_user = mysqli_query($con,$sql_user) or die(mysqli_error($con));
            while($row=mysqli_fetch_array($result_user)){
                $X = $row[2];
                $Y = $row[3];
                $time = $row[5];

                $json_encoder[] = array($user_name => array($X,$Y,$num_rows,$image_link,$time,$num_of_trackee,$num_of_tracker,$num_of_tracks));
            }

            echo(json_encode($json_encoder));
        }
        else{
            //print_r('biplov');
            $num_rows = 0;
            $json_encoder[] = array($user_name => array(0,0,$num_rows,$image_link,('2014-09-09 12:12:12'),$num_of_trackee,$num_of_tracker,$num_of_tracks));
            echo(json_encode($json_encoder));
        }

    }
	
	else{
  		echo 'not logged in';
	}
?>