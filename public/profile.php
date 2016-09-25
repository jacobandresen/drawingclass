<?php
require_once('inc/db.php');
global $dbconn;
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
    $userid= get('id', $_SESSION['userid']);

    $res = pg_query($dbconn, "select username, email from profile where id=$userid;");
    $data = pg_fetch_object($res);
    print "<h2>".$data->username." : ".$data->email." </h2>";

	$query = "select adaptation.id, original_id, url, source_image_url from profile,adaptation, user_image, original_image where user_image_id=user_image.id and profile.id=profile_id and original_image_id = original_image.id and profile_id=$userid";
	$res = pg_query($dbconn, $query) or die('Query failed: ' . pg_last_error());
	echo "<ul>\n";
    while ($data=pg_fetch_object($res)) {
		echo "<li><image src=\"$data->url\" width=\"420\" /> <a href='creator.php?id=".$data->original_id."'><image src=\"$data->source_image_url\" width=\"420\" /></a></li>\n";
	}
	echo "</ul>\n";
   pg_free_result($res);

// show contact info 
?>
</body>
</html>
