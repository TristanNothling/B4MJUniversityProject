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

if (isset($_POST['choose']))
{

$sql = "SELECT * FROM Users WHERE Id=" . $_SESSION["Id"];
$result = $conn->query($sql);

if ($result->num_rows == 1) 
{
$row = $result->fetch_assoc();
}

$credits_amount = $row['Credits'];

$sql = "SELECT * FROM Bids WHERE Id=" . $_POST["winningbidid"];
$result = $conn->query($sql);

if ($result->num_rows == 1) 
{
$row = $result->fetch_assoc();
}

$bid_amount = $row['Price'];
$chosen_bidder_id = $row['BidderId'];
$job_id = $row['JobId'];

if ($credits_amount<$bid_amount)
{
	echo "<p>no funds</p>";
}
else
{

$stmt = $conn->prepare("INSERT INTO Transactions (Amount,EscrowStart,SenderId,RecipientId,JobId) VALUES (?,?,?,?,?)");
$stmt->bind_param("isiii",$amount,$escrowstart,$senderid,$recipientid,$jobid);

$amount = $bid_amount;
$escrowstart = date('Y-m-d H:i:s');
$senderid = $_SESSION['Id'];
$recipientid = $chosen_bidder_id;
$jobid = $job_id;

$stmt->execute();
#create transaction database entry.
$last_id = $conn->insert_id;

$sql = "UPDATE Jobs SET TransactionId=" . $last_id . " WHERE Jobs.Id=" . $_POST["jobid"]; 

if ($conn->query($sql) === TRUE) {
    echo "Created transaction.";
} else {
    echo "Error updating record: " . $conn->error;
}

$sql = "UPDATE Jobs SET WinnerId=" . $_POST['bidderid'] . " WHERE Jobs.Id=" . $_POST["jobid"]; 

if ($conn->query($sql) === TRUE) {
    echo "Chose winner.";
} else {
    echo "Error updating record: " . $conn->error;
}

$new_value= ($credits_amount-$bid_amount);
echo $new_value;

$sql = "UPDATE Users SET Credits=". $new_value . " WHERE Id=" . $_SESSION["Id"];

if ($conn->query($sql) === TRUE) {
    echo "credits set.";
    header("Location:view-job.php?id=" . $_POST["jobid"]);
} else {
    echo "Error updating record: " . $conn->error;
}
}

#all the above should probably be wrapped in a transaction object so that if there is an error
#there are no conflicts from half finished database modifications
#header("Location:purchase-credits.php");
}
else
{
	echo "<p>Oops, looks like no bidder was chosen.</p>";
}

?>