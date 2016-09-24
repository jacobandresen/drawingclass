<?php
require_once('inc/db.php');

print_r($_REQUEST);

if (isset($_SESSION['userid'])) {
    $fileToUpload = get('fileToUpload', null);
    $imageId = get('image_id', -1); 
    $title = get('title', '');
    $artist = get('artist', '');
    $user_title = get('user_title', '');

    //TODO: insert into database
}

// TODO: show original image
// TODO: show adaptations


