<?php
	

	//for the insertion of data into the database from the mobile


	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		if ((!empty($_POST['id'])) && (!empty($_POST['name'])) && (!empty($_POST['accuracy'])) && (!empty($_POST['timestamp'])) && (!empty($_POST['X'])) && (!empty($_POST['Y'])) && (!empty($_POST['track_id']))){
			$id = $_POST['id'];
			$name = $_POST['name'];
			$accuracy = $_POST['accuracy'];
			$timestamp = $_POST['timestamp'];
			$X = $_POST['X'];
			$Y = $_POST['Y'];
			$track_id = $_POST['track_id'];
			
			if ($id != 0){
				insertion($id, $name, $accuracy, $timestamp, $X, $Y,$track_id);
			}
		}
		else{
			echo 'something is missing';
		}
	}

	function insertion ($idd, $namee, $accuracyy, $timestampp, $XX, $YY,$track_id){
	
		include "connection.php";		
		
		if (!$con){
			echo 'no connection';
		}
		
		else{
			
			$timee = date('Y-m-d H:i:s',strtotime($timestampp));
	
			$sql1 = "INSERT INTO `mobile_tracks` ".
			       "(person_id,username,X_coord,Y_coord,accuracy,time,track_id) ".
			       "VALUES ".
			       "('$idd','$namee','$XX','$YY','$accuracyy','$timee','$track_id')";
			
			mysqli_query($con,$sql1) or die(mysqli_error($con));
			
			$sql = "UPDATE `person`
		        SET `X_coord` ='" . $XX . "', `Y_coord` ='" . $YY . "', `accuracy` ='" . $accuracyy . "' , `time` ='" . $timee ."'" . 
	        	" WHERE `person_id` = '" . $idd . "'";
	
			mysqli_query($con,$sql) or die(mysqli_error($con));
	
			
			if (mysqli_error($con)){
				echo 'failed';
			}	
			else{
				echo 'insertion successful';
			}	
		}		
	}
	
?>