<?php
session_start();
require_once('inc/db.php');
if (isset($_SESSION['userid'])) {
  $userid = $_SESSION['userid'];
} else {
	header('Location: login.php');
}

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
  $url ="";


      $ch = curl_init();

      // set URL and other appropriate options
      curl_setopt($ch, CURLOPT_URL, "http://demoapi.smk.dk/api/artworks?refnum=$id&start=0&rows=10");

      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HEADER, 0);

      // grab URL and pass it to the browser
      $apidata_ind=curl_exec($ch);

      $nye = json_decode($apidata_ind);

      if(isset($nye->error)) {
          print_r($nye);
	  die($nye->error);
      }
      else {
		# print_r($nye->response->docs);
		foreach($nye->response->docs as $cur_doc) {
			$url = $cur_doc->medium_image_url;
			$nr = 0;
                	echo "<image src=\"$cur_doc->medium_image_url\" height=\"420\" width=\"420\" >";
                     	foreach($cur_doc->artist_name as $cur_artist) {
		         if($nr==0)
		             echo "<br />$cur_artist";
                         else
			     echo ", $cur_artist";
			$nr++;
                     	}
			echo ": ";

                 	if($cur_doc->title_first)
                     		echo "$cur_doc->title_first";

                 	if($cur_doc->object_type_dk)
		     		echo " ($cur_doc->object_type_dk)";
			
		}
      }

?>

<img id="preview" />

<form class="uploadform" action="image.php" method="post" enctype="multipart/form-data" onchange="loadFile(event)">
	<label id="uploadbtn" class="uploadform__btn uploadform__btn--fileuploadbtn" for="fileToUpload">Upload</label>
	<input class="uploadform__fileinput" type="file" name="fileToUpload" id="fileToUpload">
        <input type="hidden" name="image_id" value="<?php print $id; ?>">
        <input type="hidden" name="profile_id" value="<?php print $userid; ?>">
        <input type="hidden" name="title" value="<?php print $title; ?>"> 
        <input type="hidden" name="artist" value="<?php print $artist; ?>"> 
        <input type="hidden" name="url" value="<?php print $url; ?>">
        <input type="hidden" name="user_title" value="<?php $title;?>">

	<div id="accept">
	<button class="uploadform__btn uploadform__btn--accept" type="submit" name="submit">Accept</button>
	<button class="uploadform__btn uploadform__btn--decline" type="button" name="submit" onclick="deleteimg()">Delete</button>
	</div>
</form>

</body>
</html>
