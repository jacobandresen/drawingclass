<?php
require_once('inc/db.php');
global $dbconn;
session_start();
$username = get('username');
$password = get('password');
$email    = get('email');

?>
<html>
<head>
  Signup
</head>
<body>

<?php
  if ($username && $password) {
     $res = pg_query($dbconn, "insert into profile(username,password,email) values('".$username."','".$password."','".$email."') returning id"); 
     if (is_resource($res)) {
         $row = pg_fetch_object($res);
         $_SESSION['username']= $username;
         $_SESSION['userid'] = $row->id;
         header('Location: index.php');
     } else {
       print "Fejl! Har du allerede en konto?";
     }
  } else {
?>
   <form method="post" action="signup.php">
     <label for="username">Brugernavn:</label>
     <input type="text" name="username">
     <label for="password">Kodeord:</label>
     <input type="password" name="password">
     <label for="email">Email</label>
     <input type="text" name="email">
     <input type="submit" value="Lav ny konto"></input>
   </form>
<?php
  }
?>
</body>
</html>
