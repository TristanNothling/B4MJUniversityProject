<?php

$error = false;
$errorMessage = "";
session_start();
if (!isset($_SESSION['Id'])){header("Location:index.php");} #if we're not logged in

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

if (isset($_POST['bidsubmit']))
{
$stmt = $conn->prepare("INSERT INTO Bids (Price,Message,JobId,BidderId,DateTimeBid) VALUES (?,?,?,?,?)");
$stmt->bind_param("isiis",$price,$message,$jobid,$userid,$postdate);

$jobid = $_POST["jobid"];
$userid = $_SESSION['Id'];
$price = $_POST["price"];
$message = $_POST["message"];
$postdate = date('Y-m-d H:i:s');

$stmt->execute();

header("Location:view-job.php?id=" . $_POST["jobid"]);

}
else
{
header("Location:bid-error.php");
}

?>