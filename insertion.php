<?php

	include "connection.php";

	if ((!empty($_POST['fname']))&&(!empty($_POST['password']))){
		if ($_FILES[$fieldname]['error'] == 0)
		$name = $_POST["fname"];
		$phone = $_POST["phone"];
		$pass = $_POST["password"];

		
		function cryptPass ($input,$rounds=9){
			$salt = "";
			$saltChars = array_merge(range('A','Z'),range('a','z'),range(0,9));
			for ($i = 0; $i < 22; $i++){
				$salt .=$saltchars[array_rand($saltChars)];
			}
			return crypt ($input, sprintf('$2y$%02d$', $rounds) . $salt);
		}
		$hashedPassword = cryptPass($pass);
		$md5pass = md5($pass);
		//location from ip
		$location = file_get_contents('http://freegeoip.net/json/'.$_SERVER['REMOTE_ADDR']);
		$locatnDecoded = json_decode($location);
		$latitude = ($locatnDecoded->{'latitude'});
		$longitude = ($locatnDecoded->{'longitude'});
	
		$latitude1 = 27.6972;
		$longitude1 = 85.3380;
		
		
		$sql5 = "SELECT * FROM `user` WHERE name ='" . $name . "'";
		$result5 = mysqli_query($con,$sql5) or die (mysqli_error($con));
		$answer = mysqli_fetch_array($result5);
		if ($answer){
			echo 'username already exists ';
			echo '</br>';
			echo 'go back to <a href = "http://kathmandulivinglabs.org/tracker/"> login page </a> ';
			
		}
		else{
			//find out the highest value in the user table 
			$sql1 = "SELECT MAX( id ) AS max FROM `user`";
			$result1 = mysqli_query($con,$sql1) or die(mysqli_error($con));
			$roow = mysqli_fetch_array($result1);
			$max_id = (int)$roow['max'];
			$id = $max_id + 1;
			
			//find out the highest value in the person table
			$sql2 = "SELECT MAX( person_id ) AS max FROM `person`";
			$result2 = mysqli_query($con,$sql2) or die(mysqli_error($con));
			$rooow = mysqli_fetch_array($result2);
			$max_iid = (int)$rooow['max'];
			$pid = $max_iid + 1;
			
			
		
			//work on photo upload
				//echo $id;
				
				/*
				$sql = 
					"INSERT INTO `user` ".
		       			"(id,name,password) ".
		       			"VALUES ".
		       			"('$id','$name','$hashedPassword')";
		       		*/
		       		
		       		$sql = 
					"INSERT INTO `user` ".
		       			"(id,name,password) ".
		       			"VALUES ".
		       			"('$id','$name','$md5pass')";
				mysqli_query($con,$sql) or die(mysqli_error($con));
				
				
			//TODOS make same ID of person and user
				
			//also inserting to the person table with the default X,Y, accuracy value and same image link
			//in this case the default location are choosen (26,84) and accuracy value = 5,, but can be taken input 
			//from the user
			
				/*
				
				$sql3 = "INSERT INTO `person` ".
		       			"(person_id,name,X_coord,Y_coord,accuracy) ".
		       			"VALUES ".
		       			"('$pid','$name','$latitude1','$longitude1',5)";
		       			
		       			
		       		*/
				$sql3 = "INSERT INTO `person` ".
		       			"(person_id,name) ".
		       			"VALUES ".
		       			"('$pid','$name')";
				mysqli_query($con,$sql3) or die(mysqli_error($con));
			
			
			//if want to make visible to himself then insert the person id to the relatn table
				$sql4 = "INSERT INTO `relatn` ".
		       			"(uid,person_id,viewable,trackable,date) ".
		       			"VALUES ".
		       			"('$id','$id',1,1,NOW())";
				mysqli_query($con,$sql4) or die(mysqli_error($con));
		
			
			//setting session variables
			session_start();
			$_SESSION['namm'] = $name;
			$_SESSION['idd'] = $id;
			
			/*
			for indicating first load
			
			
			$_SESSION['first'] = 1;
			
			*/
			
			header('Location: query_mod.php');
		}	
	}
	else{
		header('Location: index.php');
	
	}
?>