<?php
require_once('inc/db.php');
session_start();
print_r($_SESSION);

if (isset($_SESSION['userid']))
 {
    $fileToUpload = get('fileToUpload', null);
    $imageId = get('image_id', -1); 
    $title = get('title', '');
    $artist = get('artist', '');
    $user_title = get('user_title', '');

    $target_dir = "files/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    //$target_file = $_SESSION['userid'] . $target_file;

    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            //echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
     }
     // Check if file already exists
     //if (file_exists($target_file)) {
     //    echo "Sorry, file already exists.";
     //    $uploadOk = 0;
     //}
     // Check file size
     if ($_FILES["fileToUpload"]["size"] > 500000) {
         //echo "Sorry, your file is too large.";
         $uploadOk = 0;
     }
     // Allow certain file formats
     if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
     }
     // Check if $uploadOk is set to 0 by an error
     if ($uploadOk == 0) {
         echo "Sorry, your file was not uploaded.";
         // if everything is ok, try to upload file
     } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
            echo '<a href="files/'.$_FILES["fileToUpload"]["name"].'">link</a>';
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// TODO: show original image
// TODO: show adaptations
