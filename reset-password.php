<!DOCTYPE html>
<head>

<!-- Basic Page Needs
================================================== -->
<title>Bid4myjob - Login</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSS
================================================== -->
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/colors/purple.css" id="colors">

</head>

<body>

<?php
session_start();
$error = false;
$errorMessage = "";

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
	$errorMessage = "There was a problem connecting to the database.";
} 

$sql = "USE bid4";

if (!mysqli_query($conn, $sql)) {
    $error = true;
	$errorMessage = "The database could not be found!";
} 

date_default_timezone_set('Europe/London'); #To correct an error where registered users were given a reg date an hour late.

if (isset($_SESSION['Id'])){header("Location:dashboard.php");}

if (isset($_POST['stage1']))
{
	if ($_POST['emailreset1'] == $_POST['emailreset2'])
	{

	$email_address = $_POST['emailreset1'];

$result = $conn->query("SELECT * FROM Users WHERE Email='$email_address'");

if ($result->num_rows == 1) 
{
$to = $_POST['emailreset2'];
$subject = "Password reset link for bid4myjob";
$txt = "Hello world!";
$headers = "From: support@bid4myjob.com" . "\r\n" ;

if (mail($to,$subject,$txt,$headers))
{
	$sent_email_success = true;
}
else
{
	//set error message to email not sent
}
}

else
{
	//no user exists with that email address
}
}
else
{
	//set error message to emails did not match
}
}


if (isset($_GET['reset-link']))

{
if (!$error){

$username = $_POST["username"];
$password = hash('sha512',$_POST["password"]); #sha512 is used, which was deemed to be the one of highest security.
$result = $conn->query("SELECT * FROM Users WHERE Username='$username' AND Password='$password'");

if ($result->num_rows == 1) 

{
$row = $result->fetch_assoc();

$_SESSION['Id'] = $row['Id'];
$_SESSION['FirstName'] = $row['FirstName'];
header("Location:dashboard.php");

} 
else 
{
$error = true;
$errorMessage = "Sorry, the username or password you entered was incorrect.";
}
}
}


?>

<!-- Wrapper -->
<div id="wrapper">

<?php include 'header.php'; ?> 


<!-- Banner
================================================== -->
<div style="width:340px;margin: 40px auto;">

	<form method="post" class="login" name="stage1" action="reset-password.php"><h2>Forgotten your password?</h2><h3>Reset it here.</h3>
			
<?php 
if ($error == true)
{
			echo '<div class="notification error closeable">';
			echo '<p>' . $errorMessage . '</p>';
			echo '<a class="close" href="#"></a>';
			echo '</div>';
}
?>

<?php 
if ($sent_email_success == true) //this if should check whether a user with that email exists above, then set a var
{
			echo '<div class="notification notice closeable">';
			echo '<p>Please check your email inbox for a password reset link.</p>';
			echo '<a class="close" href="#"></a>';
			echo '</div>';
}
?>

								<p class="form-row form-row-wide">
									<label for="emailreset1">Please enter your email address:
										<i class="im im-icon-Male"></i>
										<input type="text" class="input-text" name="emailreset1" id="em1" value=""/>
									</label>
								</p>

								<p class="form-row form-row-wide">
									<label for="emailreset2">Please confirm your email address:
										<i class="im im-icon-Lock-2"></i>
										<input class="input-text" type="text" name="emailreset2" id="em2"/>
									</label>

								</p>

								<div class="form-row">
									<input type="submit" class="button border margin-top-5" name="stage1" value="Send Reset Email" />
								</div>
	</form>
</div>


<?php include 'footer.php'; ?> 

<!-- Back To Top Button -->
<div id="backtotop"><a href="#"></a></div>

</div>
<!-- Wrapper / End -->

<!-- Scripts
================================================== -->
<script type="text/javascript" src="scripts/jquery-2.2.0.min.js"></script>
<script type="text/javascript" src="scripts/mmenu.min.js"></script>
<script type="text/javascript" src="scripts/chosen.min.js"></script>
<script type="text/javascript" src="scripts/slick.min.js"></script>
<script type="text/javascript" src="scripts/rangeslider.min.js"></script>
<script type="text/javascript" src="scripts/magnific-popup.min.js"></script>
<script type="text/javascript" src="scripts/waypoints.min.js"></script>
<script type="text/javascript" src="scripts/counterup.min.js"></script>
<script type="text/javascript" src="scripts/jquery-ui.min.js"></script>
<script type="text/javascript" src="scripts/tooltips.min.js"></script>
<script type="text/javascript" src="scripts/custom.js"></script>

</body>
</html>