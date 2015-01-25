<?php
    if(isset($_POST["username"]))
    {
        //check if its an ajax request, exit if not
        if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
            die();
        }   

            //try connect to db
        include_once "connection.php";
        
        //trim and lowercase username
        $username =  strtolower(trim($_POST["username"])); 
        
        //sanitize username
        $username = filter_var($username, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH);
        
        //check username in db
        $results = mysqli_query($con,"SELECT username FROM user WHERE username='$username'");
        
        //return total count
        $username_exist = mysqli_num_rows($results); //total records
        
        //if value is more than 0, username is not available
        if($username_exist) {
            echo '<img src="img/not-available.png" height="50" width="50" />';
            echo "username is already taken. Please try other";
        }else{
            echo '<img src="img/available.png" height="50" width="50" />';
            echo "username is available";
        }
        
    }
?>