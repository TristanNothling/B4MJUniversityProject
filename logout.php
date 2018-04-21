<!DOCTYPE HTML>

<head>
<meta charset="utf-8">
<title>Bid4MyJob</title>
</head>
<body>
<p>
  
<?php
$servername = "localhost";
$user = "root";
$pass = "";
$dbname = "bid4";

session_start();
session_unset();
session_destroy();

echo "Logged out.";

//perhaps a way to post back to index page with post variable logged_out = true. then display a little message like "See you again soon" if this var is set?

header("Location:index.php");
?>
</p>

</body>