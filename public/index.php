<?php
session_start();
require_once('inc/db.php');
?>
<html>
   <head>
      <title>Remake</title>
      <link rel="stylesheet" href="mock/forsidestyle.css" />
   </head>
   <body>
   <?php
    $query=get('query');
    if ($query == "") $query = "Wilhelm Heuer";
    ?>
    <form class="searchbar" id="searchinput" method="GET">
       <input type="text" class="searchbar__input" placeholder="Search for art " name="query" />
       <button type="submit" class="searchbar__submit"><i class="fa fa-search " aria-hidden="true"></i></button>
    </form>

 <h1 class="title">Explore</h1>
 <div class="explore">
   <?php
      //show search results
        if(isset($_GET['next']))
          $next = $_GET['next'];
      else
   	$next = 0;
      $solr_string="q=$query&facet=true&fl=id, title_first,object_production_date_latest,object_production_date_earliest,medium_image_url,object_type_dk,artist_name&facet.mincount=1&start=$next&facet.limit=-1&qf=collectorExact1^150 collectorExact2^30 collectorExact3^20 collector1^20 collector2^15 collector3^10 collector4^5&facet.field=artist_surname_firstname&wt=json&defType=edismax&rows=20";

      # $solr_string="q=Jorn&start=0&rows=5&facet.field=artist_name";
      $solr_string_konv=urlencode($solr_string);
      echo "<!-- solr_string_konv: $solr_string_konv -->\n";

      $ch = curl_init();

      // set URL and other appropriate options
      curl_setopt($ch, CURLOPT_URL, "http://demoapi.smk.dk/api/search?solr_string=$solr_string_konv");

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
        // echo "<ul>\n";
	 foreach($nye->response->docs as $cur_doc) {
             if(isset($cur_doc->medium_image_url)) {
	        // echo "<li>";
		 echo '<a class="explore__box" href="creator.php?id='.$cur_doc->id.'">';
                 echo "<image src=\"$cur_doc->medium_image_url\" >";


                 //if(isset($cur_doc->title_first))
                 //    echo "$cur_doc->title_first";

                 //if(isset($cur_doc->object_type_dk))
		 //    echo " ($cur_doc->object_type_dk)";
		 echo "</a>";

                 //echo "</li>\n";
 	     }
	}
        //echo "</ul>\n";
    }

curl_close($ch);
?>
</div>
    <form action="index.php" method="GET">
       <input type="hidden" name="query" value="<?php echo urlencode($query) ?>" />
       <input type="hidden" name="next" value="<?php echo $next+20 ?>" />
       <input type="submit" value="N&aelig;ste" />
    </form>
<?php
if($next>0) {
?>
    <form action="index.php" method="GET">
       <input type="hidden" name="query" value="<?php echo urlencode($query) ?>" />
       <input type="hidden" name="next" value="<?php echo $next-20 ?>" />
       <input type="submit" value="Forrige" />
    </form>
<?php
}


if (!isset($_SESSION['userid'])) {

?>

<form class="login" action="login.php">
        <h1 class="login__header">Login</h1>
        <input class="login__inp login__inpfld" placeholder="User" type="text" name="username">
        <input class="login__inp login__inpfld" placeholder="Password" type="password" name="password">
        <input class="login__inp login__submit login__inpbtn" type="submit" value="Login">

<div class="login__btns">
        <a class="login__newuser login__inpbtn" href="signup.php">Ny bruger</a>
        </div>
</form>

<?php
}
?>

   </body>

</html>
