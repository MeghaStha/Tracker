<?php  

    //htmlspecialchars($_SERVER["PHP_SELF"]);

    // define variables and set to empty values
    $username=$email=$phone=$password="";
    function test_input($data) {
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }

    /*
    function cryptPass ($input,$rounds=9){
        $salt = "";
        $saltChars = array_merge(range('A','Z'),range('a','z'),range(0,9));
        for ($i = 0; $i < 22; $i++){
            $salt .=$saltchars[array_rand($saltChars)];
        }
        return crypt ($input, sprintf('$2y$%02d$', $rounds) . $salt);
    }
    */

    include "connection.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
            $username = test_input(($_POST["username"]));
            $email = test_input(($_POST["email"]));
            $phone = test_input(($_POST["phone"]));
            $password = test_input(($_POST["password"]));
    }


    //$hashedPassword = cryptPass($password);
    $md5password = md5($password);

    /*
    //location from ip
    $location = file_get_contents('http://freegeoip.net/json/'.$_SERVER['REMOTE_ADDR']);
    $locatnDecoded = json_decode($location);
    $lat_from_id = ($locatnDecoded->{'latitude'});
    $lng_from_id = ($locatnDecoded->{'longitude'});
    
    $lat_default = 27.6972;
    $lng_default = 85.3380;
    */
        
    //check if username already exist    
    $query_username = "SELECT * FROM `user` WHERE username like '" . $username . "' ";
    $result_username = mysqli_query($con,$query_username) or die (mysqli_error($con));
    $answer_username = mysqli_fetch_array($result_username);

    if ($answer_username){
        echo 'username already exists ';
        echo '</br>';
        echo 'go back to <a href = "./index.php"> login page </a> ';
    }

    else{

        //find out the highest value in the user table 
        $query_id = "SELECT MAX( id ) AS max FROM `user`";
        $result_id = mysqli_query($con,$query_id) or die(mysqli_error($con));
        $row_id = mysqli_fetch_array($result_id);
        $max_id = (int)$row_id['max'];
        $id = $max_id + 1;

        //find out the highest value in the person table
        /*$person_id = "SELECT MAX( person_id ) AS max FROM `person`";
        $result_person_id = mysqli_query($con,$person_id) or die(mysqli_error($con));
        $row_person_id = mysqli_fetch_array($result_person_id);
        $max_person_id = (int)$row_person_id['max'];
        $pid = $max_person_id+ 1;*/
                    
        $sql_user = 
            "INSERT INTO `user` ".
            "(id,username,email,phone,password) ".
            "VALUES ".
            "('$id','$username','$email','$phone','$md5password')";

        mysqli_query($con,$sql_user) or die(mysqli_error($con));

        $sql_person =
            "INSERT INTO `person` ".
            "(person_id,username) ".
            "VALUES".
            "('$id','$username') ";

        mysqli_query($con,$sql_person) or die(mysqli_error($con));        
            
        //setting session variables
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $id;
        header('Location: interface.php');
           
    }
    
    if (isset($_SESSION['username']) && isset($_SESSION['id'])){
            header('Location: interface.php');
    }
    else{
        header('Location: index.php');    
    }
?>