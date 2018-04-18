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

date_default_timezone_set('Europe/London'); #To correct an error where registered users were given a reg date an hour late.

#If you're on this page, check if logged in and redirect if so.
#Here we check if all the fields contain data. At a later stage include javascript to validate fields before submitting.

if (isset($_POST['register']))
{
$stmt = $conn->prepare("INSERT INTO Users (Username,Password,FirstName,LastName,Address,Postcode,Email,RegDate) VALUES (?,?,?,?,?,?,?,?)");
$stmt->bind_param("ssssssss",$username,$password,$firstname,$lastname,$address,$postcode,$email,$regdate);
$username = $_POST["username"];
$password = hash('sha512',$_POST["password"]);
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$address = $_POST["address"];
$postcode = $_POST["postcode"];
$email = $_POST["email"];
$regdate = date('Y-m-d H:i:s');
$stmt->execute();
echo "New user registered!<br>";
}

?>


<form action="register.php" method="post">
Username: <input type="text" name="username"><br>
Password: <input type="password" name="password"><br>
First name: <input type="text" name="firstname"><br>
Last name: <input type="text" name="lastname"><br>
Address: <input type="text" name="address"><br>
Postcode: <input type="text" name="postcode"><br>
Email address: <input type="text" name="email"><br>
Confirm email address: <input type="text" name="email2"><br>
<input type="submit" value="Register!" name="register">
</form>
</p>

</body>