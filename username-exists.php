<!DOCTYPE html>
<html>
<body>

<?php

if (isset($_GET['user']))
{
$servername = "localhost";
$user = "root";
$pass = "";
$dbname = "bid4";

// Create connection
$conn = mysqli_connect($servername, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) 
{
    $error = true;
    $errorMessage = "Oops! Looks like there was a problem connecting to the database.";
} 


$sql = "USE bid4";

if (!mysqli_query($conn, $sql)) {
    $error = true;
    $errorMessage = "Oops! Looks like the database could not be found!";
} 

date_default_timezone_set('Europe/London'); #To correct an error where registered users were given a reg date an hour late.


$username = $_GET['user'];
$result = $conn->query("SELECT * FROM Users WHERE Username='$username';");

//can't help but notice the AJAX query might be subject to MySQL injection as I pass the raw input from the user into a MySQL query.

if ($result->num_rows == 1) 
{
?>

<p style="color:red;" id="textHint">Sorry, that username is already taken!</p>

<?php
}
else
{
?>

<p style="color:#35ad61;" id="textHint">Awesome, that username is available!</p>

<?php 

}

mysqli_close($conn);

}

?>
</body>
</html>