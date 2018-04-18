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

if (isset($_POST['mark-complete']))
{
    echo "<p> Let's go!</p>";

$sql = "SELECT * FROM Jobs WHERE Id=" . $_POST["jobid"];
$result = $conn->query($sql);

if ($result->num_rows == 1) 
{
$row = $result->fetch_assoc();
}

$transaction_id = $row['TransactionId'];

echo "<p>" . $transaction_id . "</p>";

$sql = "SELECT * FROM Transactions WHERE Id=" . $transaction_id;
$result = $conn->query($sql);

if ($result->num_rows == 1) 
{
$transaction_fields = $result->fetch_assoc();
}

$sender_id = $transaction_fields['SenderId']; #not used
$recipient_id = $transaction_fields['RecipientId'];

$sql = "SELECT * FROM Users WHERE Id=" . $recipient_id;
$result = $conn->query($sql);

if ($result->num_rows == 1) 
{
$recipient_fields = $result->fetch_assoc();
}

$new_balance = $recipient_fields['Credits']+$transaction_fields['Amount'];

$sql = "UPDATE Users SET Credits=" . $new_balance . " WHERE Id=" . $recipient_id; 

if ($conn->query($sql) === TRUE) {
    echo "Finished transaction.";
} else {
    echo "Error updating record: " . $conn->error;
}

$sql = "UPDATE Transactions SET Complete=TRUE WHERE Id=" . $transaction_id;

if ($conn->query($sql) === TRUE) {
    echo "Transaction is complete.";
} else {
    echo "Error updating record: " . $conn->error;
}

$cur_datetime = date('Y-m-d H:i:s');
$sql = "UPDATE Transactions SET EscrowFinish=" . $cur_datetime . " WHERE Id=" . $transaction_id;

if ($conn->query($sql) === TRUE) {
    echo "Transaction is complete.";
} else {
    echo "Error updating record: " . $conn->error;
}

$sql = "UPDATE Jobs SET Complete=TRUE WHERE Id=" . $_POST["jobid"];

if ($conn->query($sql) === TRUE) {
    echo "Transaction is complete.";
} else {
    echo "Error updating record: " . $conn->error;
}

header("Location:view-job.php?id=". $_POST["jobid"]);

}


?>