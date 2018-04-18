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

// Create connection
$conn = mysqli_connect($servername, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
} 
else
{
echo "Connected successfully.</br>";
}

$sql = "USE bid4";

if (mysqli_query($conn, $sql)) {
    echo "Using bid4 database.</br>";
} else {
    echo "Error using database: " . mysqli_error($conn);
}

if (isset($_SESSION['Id']))
{
echo "Successfully logged in as user with ID " . $_SESSION['Id'] . "<br>";
}

#If you're on this page, check if logged in and redirect if so.
#Here we check if all the fields contain data. At a later stage include javascript to validate fields before submitting.

$sql = "SELECT * FROM Bids";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) 
    {
        echo "Job: " . $row["JobId"] . " - BidderID: " . $row["BidderId"] . " - message: " . $row["Message"] . " - price: " . $row["Price"] . "</br>";
    }
} else {
    echo "0 results.";
}
?>

</p>
</body>
