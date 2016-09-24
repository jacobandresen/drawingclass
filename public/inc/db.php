<?php
$dbconn = pg_connect("host=localhost port=5432 dbname=remake user=postgres password=hej22");

function get($name, $default = "") { 
  if (isset($_REQUEST[$name])) {
     return $_REQUEST[$name];
   } else {
     return $default;
   }
}

