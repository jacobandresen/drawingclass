<html>
   <head>
      <title>Drawing class</title>
   </head>
   <body>
    <?php
    //entry page: Explorer (search)
    //show search button
    //allow facets artist,year
    ?>
    <form action="index.php" method="post">
       <input type="text" name="query" />
       <input type="text" name="year" />
       <input type="text" name="artist" />
       <input type="number" name="archive" />
    </form>

   <?php
    //show search results
      //allow navigation to creator.php via unique id 
    // our first api will be SMK: http://solr.smk.dk/
    // Aagards billeder
   ?>
   </body>
</html>
<?php


