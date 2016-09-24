<?php
session_start();
?>
<html>
   <head>
      <title>Drawing class</title>
   </head>
   <body>
    <?php
    if (!isset($_SESSION['username'])) {
       print "<a href='login.php'>log ind</a>";
    } else {
       print "hej ".$_SESSION['username'];
    }

    //allow facets artist,year
    if(!isset($_POST['query'])) {
    ?>
    <form action="index.php" method="post">
       <input type="text" name="query" />
<!--       <input type="text" name="year" />
       <input type="text" name="artist" /> -->
    </form>

   <?php
   } else {
    //show search results
      //allow navigation to creator.php via unique id 
    // our first api will be SMK: http://solr.smk.dk/
		$soeg=$_POST['query'];

		$solr_string="q=$soeg&facet=true&fl=id, title_first,object_production_date_latest,object_production_date_earliest,medium_image_url,object_type_dk,artist_name&facet.mincount=1&start=0&facet.limit=-1&qf=collectorExact1^150 collectorExact2^30 collectorExact3^20 collector1^20 collector2^15 collector3^10 collector4^5&facet.field=artist_surname_firstname&wt=json&defType=edismax&rows=10";

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
			echo "<ul>\n";
			foreach($nye->response->docs as $cur_doc) {
				echo "<li>";
				if($cur_doc->medium_image_url)
					echo "<image src=\"$cur_doc->medium_image_url\" height=\"42\" width=\"42\" >";

				if($cur_doc->artist_name) {
					$nr=0;
					foreach($cur_doc->artist_name as $cur_artist) {
						if($nr==0)
							echo "$cur_artist";
						else
							echo ", $cur_artist";
					}
					echo ": ";
				}

				if($cur_doc->title_first)
					echo "$cur_doc->title_first";

				# print_r($cur_doc);
				echo "</li>";
			}
			echo "</ul>\n";

		}

		curl_close($ch);

   }
   ?>
   </body>

</html>
<?php


