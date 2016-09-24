<?php
session_start();
require_once('inc/db.php');
?>
<html>
<head>
   <title>upload</title>
</head>
<body>

<?php
  $id = get('id', -1);
  $title = get('title', '');
  $artist = get('artist', '');

if (isset($_SESSION['userid'])) {
  $userid = $_SESSION['userid'];
?>

<img id="preview" />

<form class="uploadform" action="image.php" method="post" enctype="multipart/form-data" onchange="loadFile(event)">
	<label id="uploadbtn" class="uploadform__btn uploadform__btn--fileuploadbtn" for="fileToUpload">Upload</label>
	<input class="uploadform__fileinput" type="file" name="fileToUpload" id="fileToUpload">
        <input type="hidden" name="image_id" value="<?php print $id; ?>">
        <input type="hidden" name="profile_id" value="<?php print $userid; ?>">
        <input type="hidden" name="title" value="<?php print $title; ?>"> 
        <input type="hidden" name="artist" value="<?php print $artist; ?>"> 
        <label for="user_title">Titel</label>
        <input type="text" name="user_title" value="<?php $title;?>">

	<div id="accept">
	<button class="uploadform__btn uploadform__btn--accept" type="submit" name="submit">Accept</button>
	<button class="uploadform__btn uploadform__btn--decline" type="button" name="submit" onclick="deleteimg()">Delete</button>
	</div>
</form>

<?php
}
?>
   <script src="inc/uploadform.js"/>
</body>
</html>
