<?php
require_once('inc/db.php');
global $dbconn;
$username = get('username');
$password = get('password');

$errStr = ""; 
if ($username && $password) {
   $res = pg_query($dbconn, "select username from profile where username='".$username."' and password='".$password."';"); 
   if (is_resource($res)) {
       header("Location: index.php");
   } else {
       $errStr = "Login fejlede";
   } 
} 
?>

<html>
<head>
  Signup 
</head>
<body>

<?php
  if ($errStr) {
     print "fejl:".$errStr;
  }
?>
  Login
   <form action="login.php">
     <label for="username">Brugernavn:</label>
     <input type="text" name="username">
     <label for="password">Kodeord:</label>
     <input type="password" name="password">
     <input type="submit" value="Login"></input>
   </form>
</body>
</html>
