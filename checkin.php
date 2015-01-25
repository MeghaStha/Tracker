<?php

	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		if ((!empty($_POST['id'])) && (!empty($_POST['name'])) && (!empty($_POST['accuracy'])) && (!empty($_POST['timestamp'])) && (!empty($_POST['X'])) && 						(!empty($_POST['Y']))){
			$id = $_POST['id'];
			$name = $_POST['name'];
			$accuracy = $_POST['accuracy'];
			$timestamp = $_POST['timestamp'];
			$X = $_POST['X'];
			$Y = $_POST['Y'];
			//echo $id.$name.$accuracy.$timestamp.$X.$Y;
			//echo gettype($accuracy);
			//echo gettype($X);
			if ($id != 0){
				insertion($id, $name, $accuracy, $timestamp, $X, $Y);
			}
		}
		else{
			echo 'something is missing';
		}
	}
	
	function insertion ($idd, $namee, $accuracyy, $timestamp, $XX, $YY){
	
		include "connection.php";
	
	
		if (!$con){
			echo 'no connection';
		}
		else{
		
			$timee = date('Y-m-d H:i:s',strtotime($timestamp));
			//insert as a new row in the mobile_check-in table

			$sql1 = "INSERT INTO `mobile_check-in` ".
		       	"(person_id,username,X_coord,Y_coord,accuracy,time) ".
		       	"VALUES ".
		       	"('$idd','$namee','$XX','$YY','$accuracyy','$timee')";
		       	
		       	echo $sql1;
		
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