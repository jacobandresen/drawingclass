<?php
require_once('inc/db.php');
session_start();
?>
<html>
  <head>
     <title>Remake</title>
     <link rel="stylesheet" href="mock/forsidestyle.css"/>
  </head>
  <body>
  <form class="searchbar" action="index.php" id="searchinput" method="GET">
     <input type="text" class="searchbar__input" placeholder="Search for art" name="query">
     <button type="submit" class="searchbar__submit"><i class="fa fa-search" aria-hidden="true"></i></button>
   </form>
<?php
if (isset($_SESSION['userid'])) {
	$userid=$_SESSION['userid'];
//display a profile page
// show artwork by user
	$query = "select adaptation.id, url, source_image_url from adaptation, user_image, original_image where user_image_id=user_image.id and original_image_id = original_image.id and profile_id=$userid";
	$res = pg_query($query) or die('Query failed: ' . pg_last_error());

	echo "<ul>\n";
	while ($data=pg_fetch_object($res)) {
		echo "<li><image src=\"$data->url\" width=\"420\" />  <image src=\"$data->source_image_url\" width=\"420\" /></li>\n";
	}
	echo "</ul>\n";
pg_free_result($res);

// show contact info 
}
?>
</body>
</html>
