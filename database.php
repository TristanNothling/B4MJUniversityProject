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
$conn = new mysqli($servername, $user, $pass);

// Check connection
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
} 
else
{
echo "Connected successfully.</br>";
}


$sql = "DROP DATABASE IF EXISTS bid4";

if (mysqli_query($conn, $sql)) {
    echo "Deleted database.</br>";
} else {
    echo "Error deleting database: " . mysqli_error($conn);
}

$sql = "
CREATE DATABASE IF NOT EXISTS bid4";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully.</br>";
} else {
    echo "Error creating database: " . $conn->error;
}

$conn = mysqli_connect($servername, $user, $pass, $dbname);

$sql = "CREATE TABLE IF NOT EXISTS Categories (
 Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 Name CHAR(32))";

 if (mysqli_query($conn, $sql)) {
    echo "Table Categories created successfully.</br>";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

#all categories defined below.

$sql = "INSERT INTO Categories (Name) VALUES ('Academic'), ('Advice'), ('Business'), ('Car mechanics'), ('Computer help'), ('Cooking and baking'),('Design'),('Health'),('Finance'),('Fitness'),('Gardening'),('Painting and decorating'),('Photography'),('Planning'),('Other');";

if (mysqli_query($conn, $sql)) {
    echo "New records created successfully</br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$sql = "CREATE TABLE IF NOT EXISTS Users (
    Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    Username CHAR(32) BINARY, #binary means case sensitive
    Password CHAR(128),
    FirstName CHAR(32),
    LastName CHAR(32),
    Address CHAR(128),
    Postcode CHAR(12),
    Email CHAR(128),
    RegDate DATETIME,
    ProfilePicture CHAR(64),
    Credits INT UNSIGNED);";

    #Possibly add role field to differentiate access levels.

if (mysqli_query($conn, $sql)) {
    echo "Table Users created successfully.</br>";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

$sql = "CREATE TABLE IF NOT EXISTS Transactions (
    Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    Amount INT UNSIGNED,
    EscrowStart DATETIME,
    EscrowFinish DATETIME,
    SenderId INT UNSIGNED,
    RecipientId INT UNSIGNED,
    Complete BOOLEAN,
    JobId INT UNSIGNED,
    FOREIGN KEY (JobId) REFERENCES Jobs(Id) ON UPDATE CASCADE ON DELETE SET NULL,
    FOREIGN KEY (SenderId) REFERENCES Users(Id) ON UPDATE CASCADE ON DELETE SET NULL,
    FOREIGN KEY (RecipientId) REFERENCES Users(Id) ON UPDATE CASCADE ON DELETE SET NULL
    )";

if (mysqli_query($conn, $sql)) {
    echo "Table Transactions created successfully.</br>";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

$sql = "CREATE TABLE IF NOT EXISTS Jobs (
    Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    CategoryId INT UNSIGNED,
    Title CHAR(128),
    Description TEXT,
    Location CHAR(128),
    Postcode CHAR(12),
    PostDate DATETIME,
    Budget INT UNSIGNED,
    Complete BOOL,
    PosterId INT UNSIGNED,
    WinnerId INT UNSIGNED,
    TransactionId INT UNSIGNED,
    FOREIGN KEY (CategoryId) REFERENCES Categories(Id) ON UPDATE CASCADE ON DELETE SET NULL,
    FOREIGN KEY (PosterId) REFERENCES Users(Id) ON UPDATE CASCADE ON DELETE SET NULL,
    FOREIGN KEY (WinnerId) REFERENCES Users(Id) ON UPDATE CASCADE ON DELETE SET NULL,
    FOREIGN KEY (TransactionId) REFERENCES Transactions(Id) ON UPDATE CASCADE ON DELETE RESTRICT
    )";

if (mysqli_query($conn, $sql)) {
    echo "Table Jobs created successfully.</br>";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

$sql = "CREATE TABLE IF NOT EXISTS Bids (
    Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    Price INT UNSIGNED,
    Message VARCHAR(256),
    JobId INT UNSIGNED,
    BidderId INT UNSIGNED,
    DateTimeBid DATETIME,
    FOREIGN KEY (JobId) REFERENCES Jobs(Id) ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (BidderId) REFERENCES Users(Id) ON UPDATE CASCADE ON DELETE RESTRICT
    )";

if (mysqli_query($conn, $sql)) {
    echo "Table Bids created successfully.</br>";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

$sql = "CREATE TABLE IF NOT EXISTS PosterReviews (
    Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    RecipientId INT UNSIGNED,
    PosterId INT UNSIGNED,
    Rating TINYINT UNSIGNED,
    Feedback VARCHAR(256),
    TimeAndDateStamp DATETIME,
    JobId INT UNSIGNED,
    FOREIGN KEY (JobId) REFERENCES Jobs(Id) ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (PosterId) REFERENCES Users(Id) ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (RecipientId) REFERENCES Users(Id) ON UPDATE CASCADE ON DELETE RESTRICT
    )";

if (mysqli_query($conn, $sql)) {
    echo "Table PosterReviews created successfully.</br>";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}


$sql = "CREATE TABLE IF NOT EXISTS BidderReviews (
    Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    RecipientId INT UNSIGNED,
    PosterId INT UNSIGNED,
    Rating TINYINT UNSIGNED,
    Feedback VARCHAR(256),
    TimeAndDateStamp DATETIME,
    JobId INT UNSIGNED,
    FOREIGN KEY (JobId) REFERENCES Jobs(Id) ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (PosterId) REFERENCES Users(Id) ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (RecipientId) REFERENCES Users(Id) ON UPDATE CASCADE ON DELETE RESTRICT
    )";

if (mysqli_query($conn, $sql)) {
    echo "Table PosterReviews created successfully.</br>";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);

?>
</p>

</body>