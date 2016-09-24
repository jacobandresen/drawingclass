<?php
require_once('inc/db.php');
// upload image and associate to profile + original image
if (isset($_SESSION['userid'])) {
    $imagename = $_REQUEST['imagename']; 
}

