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


if (isset($_SESSION['ErrorMessage']))
{
			echo '<div class="notification error closeable">';
			echo '<p>' . $_SESSION['ErrorMessage'] . '</p>';
			echo '<a class="close" href="#"></a>';
			echo '</div>';
			unset($_SESSION['ErrorMessage']);
}
?>

</p>
</body>