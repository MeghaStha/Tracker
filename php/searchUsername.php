<?php  

            //try connect to db
        include_once "connection.php";
        
        //trim and lowercase username
        $username =  $_GET["value"]; 
        
        
        //check username in db
        $results = mysqli_query($con,"SELECT username FROM user WHERE username='$username'");
        
        //return total count
        $username_exist = mysqli_num_rows($results); //total records
        
        //if value is more than 0, username is not available
        if($username_exist>0) {
            $json = array($username=>array(true));
            echo(json_encode($json));
        }

        else{
            $json = array($username=>array(false));
            echo(json_encode($json));        
        }
        
?>