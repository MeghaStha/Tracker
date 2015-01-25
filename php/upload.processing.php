<?php

session_start();
$username=$_SESSION['username'];
$id = $_SESSION['id'];

############ Configuration ##############
$thumb_square_size      = 200; //Thumbnails will be cropped to 200x200 pixels
$max_image_size         = 500; //Maximum image size (height and width)
$thumb_prefix           = "thumb_"; //Normal thumb Prefix
$destination_folder     = './uploaded_files/'; //upload directory ends with / (slash)
$jpeg_quality           = 100; //jpeg quality
##########################################

//continue only if $_POST is set and it is a Ajax request
if(isset($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
    //check $_FILES['ImageFile'] not empty
    if(!isset($_FILES['image_file']) || !is_uploaded_file($_FILES['image_file']['tmp_name'])){
        die('Image file is Missing!'); // output error when above checks fail.
    }
    
    
    //get uploaded file info before we proceed
    $image_name = $_FILES['image_file']['name']; //file name
    $image_size = $_FILES['image_file']['size']; //file size
    $image_temp = $_FILES['image_file']['tmp_name']; //file temp

    $image_size_info    = getimagesize($image_temp); //gets image size info from valid image file
    
    if($image_size_info){
        $image_width        = $image_size_info[0]; //image width
        $image_height       = $image_size_info[1]; //image height
        $image_type         = $image_size_info['mime']; //image type
    }else{
        die("Make sure image file is valid!");
    }

    //switch statement below checks allowed image type 
    //as well as creates new image from given file 
    switch($image_type){
        case 'image/png':
            $image_res =  imagecreatefrompng($image_temp); break;
        case 'image/gif':
            $image_res =  imagecreatefromgif($image_temp); break;           
        case 'image/jpeg': case 'image/pjpeg':
            $image_res = imagecreatefromjpeg($image_temp); break;
        default:
            $image_res = false;
    }

    if($image_res){
        //Get file extension and name to construct new file name 
        $image_info = pathinfo($image_name);
        $image_extension = strtolower($image_info["extension"]); //image extension
        $image_name_only = strtolower($image_info["filename"]);//file name only, no extension
        
        //create a random name for new image (Eg: fileName_293749.jpg) ;
        $new_file_name = $image_name_only. '_' .  rand(0, 9999999999) . '.' . $image_extension;
        
        //folder path to save resized images and thumbnails
        $thumb_save_folder  = $destination_folder . $thumb_prefix . $new_file_name; 
        $image_save_folder  = $destination_folder . $id . "_" . $new_file_name;
        
        //call normal_resize_image() function to proportionally resize image
        if(normal_resize_image($image_res, $image_save_folder, $image_type, $max_image_size, $image_width, $image_height, $jpeg_quality))
        {            
            include "../connection.php";
            
            $sql_person = "SELECT `image_link` FROM person WHERE `username`='$username' && `person_id`='$id'";
            $sql_user = "SELECT `image_link` FROM user WHERE `username`='$username' && `id`='$id'";

            $person_result = mysqli_query($con,$sql_person) or die(mysqli_error($con));
            $user_result = mysqli_query($con,$sql_user) or die(mysqli_error($con));

            $content_person = mysqli_fetch_array($person_result);
            $content_user = mysqli_fetch_array($user_result);

	    unlink($content_person['image_link']);
            unlink($content_user['image_link']);

            mysqli_query($con,"UPDATE user SET image_link='$image_save_folder' WHERE `username`='$username'");

            mysqli_query($con,"UPDATE person SET image_link='$image_save_folder' WHERE `username`='$username'");

            mysqli_close($con);
            
            echo "successfully uploaded";
        }
                    
        
        imagedestroy($image_res); //freeup memory
    }
}

#####  This function will proportionally resize image ##### 
function normal_resize_image($source, $destination, $image_type, $max_size, $image_width, $image_height, $quality){
    
    if($image_width <= 0 || $image_height <= 0){return false;} //return false if nothing to resize
    
    //do not resize if image is smaller than max size
    if($image_width <= $max_size && $image_height <= $max_size){
        if(save_image($source, $destination, $image_type, $quality)){
            return true;
        }
    }
    
    //Construct a proportional size of new image
    $image_scale    = min($max_size/$image_width, $max_size/$image_height);
    $new_width      = ceil($image_scale * $image_width);
    $new_height     = ceil($image_scale * $image_height);
    
    $new_canvas     = imagecreatetruecolor( $new_width, $new_height ); //Create a new true color image
    
    //Copy and resize part of an image with resampling
    if(imagecopyresampled($new_canvas, $source, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height)){
        save_image($new_canvas, $destination, $image_type, $quality); //save resized image
    }

    return true;
}

##### Saves image resource to file ##### 
function save_image($source, $destination, $image_type, $quality){
    switch(strtolower($image_type)){//determine mime type
        case 'image/png': 
            imagepng($source, $destination); return true; //save png file
            break;
        case 'image/gif': 
            imagegif($source, $destination); return true; //save gif file
            break;          
        case 'image/jpeg': case 'image/pjpeg': 
            imagejpeg($source, $destination, $quality); return true; //save jpeg file
            break;
        default: return false;
    }
}