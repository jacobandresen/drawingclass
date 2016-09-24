<?php
require_once('inc/db.php');
session_start();

if (isset($_SESSION['userid']))
{
    $fileToUpload = get('fileToUpload', null);
    $orig_image_id = get('image_id', -1); 
    $title = get('title', '');
    $artist = get('artist', '');
    $user_title = get('user_title', '');
    $source_image_url = get('url', '');

    print "<img src='".$source_image_url."'>";

    $target_dir = "files/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

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
	    $url = "files/".basename($_FILES["fileToUpload"]["name"]);
            //echo '<img src="files/'.$_FILES["fileToUpload"]["name"].'">';
            echo '<img src="'.$url.'">';

	    $res = pg_query("select id from original_image where source_image_url='".$source_image_url."';");
            if($res && isset($row['id'])) {
                print "A:".$source_image_url;
                print_r($res);
         
                $row = pg_fetch_assoc($res);
                $orig_image_id = $row['id'];
            } else {
                $res = pg_query("insert into original_image(archive_id,title,artist,source_image_url) values(1,'".$title."','".$artist."','".$source_image_url."') returning id");
	        $row = pg_fetch_assoc($res);
                $orig_image_id = $row['id'];
            }  

	    $res = pg_query("insert into user_image(profile_id,title,url) values(".$_SESSION['userid'].",'".$user_title."','".$url."') returning id");
	    $row = pg_fetch_assoc($res);
	    $user_image_id = $row['id'];
 	    
            $res = pg_query("insert into adaptation(user_image_id,original_image_id) values($user_image_id, $orig_image_id)");
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
