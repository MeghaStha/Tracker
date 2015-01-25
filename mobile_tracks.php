<?php
	

	//for the insertion of data into the database from the mobile


	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		if ((!empty($_POST['id'])) && (!empty($_POST['name'])) && (!empty($_POST['accuracy'])) && (!empty($_POST['timestamp'])) && (!empty($_POST['X'])) && (!empty($_POST['Y'])) && (!empty($_POST['flag']))){
			$id = $_POST['id'];
			$name = $_POST['name'];
			$accuracy = $_POST['accuracy'];
			$timestamp = $_POST['timestamp'];
			$X = $_POST['X'];
			$Y = $_POST['Y'];
			$flag = $_POST['flag'];
			
			if ($id != 0){
				insertion($id, $name, $accuracy, $timestamp, $X, $Y,$flag);
			}
		}
		else{
			$msg = 'something is missing';
			echo $msg;
		}
	}

//type conversion to do

//check if it already exists

function insertion ($idd, $namee, $accuracyy, $timestampp, $XX, $YY){
	include "connection.php";
	//update in the person_table
	
	$timee = date('Y-m-d H:i:s',strtotime($timestampp));
	if (!$con){
		echo 'no connection';
	}
	else{

		//insert as a new row in the mobile_check-in table

		$sql1 = "INSERT INTO `mobile_tracks` ".
		       "(person_id,X_coord,Y_coord,accuracy,time,flag) ".
		       "VALUES ".
		       "('$idd','$XX','$YY','$accuracyy',$timee','$flag')";
		
		mysqli_query($con,$sql1) or die(mysqli_error($con));

		
		if (mysqli_error($con)){
			echo 'sorry';
		}	
		else{
			echo 'insertion successful';
		}	
	}		
}
	
?>