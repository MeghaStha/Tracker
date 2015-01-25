<?php
	session_start();
	include 'connection.php';
	if (isset($_SESSION['username']) && isset($_SESSION['id'])){
		
		unset($_SESSION['username']);
		unset($_SESSION['id']);
		session_destroy();
		header ('Location: index.php');
	}
	else{
		$message = "You are not logged in \nRedirecting to Main Page";
		echo "<script type='text/javascript'>alert('$message');</script>";
		header ('Location: index.php');

	}
	mysqli_close($con);
	
?>