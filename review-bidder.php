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

if (isset($_POST['review']))
{


  if ($_POST["rating"]<0 || $_POST["rating"]>5)
  {
		
		$_SESSION['ErrorMessage'] = "You can only enter a whole number between 1 and 5 when reviewing a user. Please hit back to try again.";
		header("Location:refer-error.php");
		exit();
  }


$stmt = $conn->prepare("INSERT INTO BidderReviews (RecipientId,PosterId,Rating,Feedback,TimeAndDateStamp,JobId) VALUES (?,?,?,?,?,?)");

$stmt->bind_param("iiissi",$recipientid,$posterid,$rating,$feedback,$datetimerev,$jobid);

$recipientid = $_POST['recipientid'];
$posterid = $_SESSION['Id'];
$rating = $_POST["rating"];
$feedback = $_POST["feedback"];
$datetimerev = date('Y-m-d H:i:s');
$jobid = $_POST["jobid"];

$stmt->execute();

header("Location:dashboard.php");
}
else
{
header("Location:review-error.php");
}

?>