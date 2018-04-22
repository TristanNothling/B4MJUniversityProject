<!DOCTYPE html>
<head>

<!-- Basic Page Needs
================================================== -->
<title>Bid4myjob - Register</title>
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

if (isset($_SESSION['Id'])){header("Location:dashboard.php");}

if (isset($_POST['register']))
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

#If you're on this page, check if logged in and redirect if so.
#Here we check if all the fields contain data. At a later stage include javascript to validate fields before submitting.
#perform query of the database, count how many rows have username. if it's one, error message=true and username is taken.

if (empty($_POST["username"]) or empty($_POST["password2"]) or empty($_POST["email2"]))
  {
		
		$_SESSION['ErrorMessage'] = "You didn&apos;t enter all of the following: Username, Password, or Email.";
		header("Location:refer-error.php");
		exit();
  }

if ($_POST["email"]!=$_POST["email2"])
  {
		
		$_SESSION['ErrorMessage'] = "Emails did not match.";
		header("Location:refer-error.php");
		exit();
  }

  if ($_POST["password"]!=$_POST["password2"])
  {
		$_SESSION['ErrorMessage'] = "Passwords did not match.";
		header("Location:refer-error.php");
		exit();
  }

	$username = $_POST['username'];
	$result = $conn->query("SELECT * FROM Users WHERE Username='$username';");

	if ($result->num_rows == 1) 
{
		$_SESSION['ErrorMessage'] = "That username is taken already, sorry.";
		header("Location:refer-error.php");
		exit();
}

$stmt = $conn->prepare("INSERT INTO Users (Username,Password,FirstName,LastName,Email,RegDate,Credits) VALUES (?,?,?,?,?,?,?)");
$stmt->bind_param("ssssssi",$username,$password,$firstname,$lastname,$email,$regdate,$credits);
$username = $_POST["username"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$password = hash('sha512',$_POST["password2"]);
$email = $_POST["email2"];
$regdate = date('Y-m-d H:i:s');
$credits = 20;

$stmt->execute();

$result = $conn->query("SELECT * FROM Users WHERE Username='$username' AND Password='$password'");

if ($result->num_rows == 1) 

{
$row = $result->fetch_assoc();
session_start();
$_SESSION['Id'] = $row['Id'];
$_SESSION['FirstName'] = $row['FirstName'];
header("Location:dashboard.php");
} 
else 
{
$error = true;
$errorMessage = "Oops! Looks like there was a problem with registration";
}
}

?>

<!-- Wrapper -->
<div id="wrapper">

<!-- Header Container
================================================== -->
<header id="header-container">

	<!-- Header -->
	<div id="header">
		<div class="container">
			
			<!-- Left Side Content -->
			<div class="left-side">
				
				<!-- Logo -->
				<div id="logo">
					<a href="index.php"><img src="images/logo.png" alt=""></a>
				</div>

				<!-- Mobile Navigation -->
				<div class="mmenu-trigger">
					<button class="hamburger hamburger--collapse" type="button">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</button>
				</div>


				<!-- Main Navigation -->
				<nav id="navigation" class="style-1">
					<ul id="responsive">


						<li><a href="browse-jobs.php">Browse jobs</a>

						</li>
						

						<li><a href="#">About</a>
							<ul>
								<li><a href="#">How it works</a></li>
								<li><a href="pages-user-profile.html">Privacy policy</a></li>
								<li><a href="pages-user-profile.html">FAQ</a></li>
								<li><a href="pages-contact.html">Contact us</a></li>
						</li>
					</ul>
				</nav>
				<div class="clearfix"></div>
				<!-- Main Navigation / End -->
				
			</div>
			<!-- Left Side Content / End -->


			<!-- Right Side Content / End -->
			<div class="right-side">
				<div class="header-widget">
					<a href="#sign-in-dialog" class="sign-in popup-with-zoom-anim"><i class="sl sl-icon-login"></i> Sign In</a>
					</a>
				</div>
			</div>
			<!-- Right Side Content / End -->

			<!-- Sign In Popup -->
			<div id="sign-in-dialog" class="zoom-anim-dialog mfp-hide">

				<div class="small-dialog-header">
					<h3>Sign In</h3>
				</div>

				<!--Tabs -->
				<div class="sign-in-form style-1">

					<ul class="tabs-nav">
						<li class=""><a href="#tab1">Log In</a></li>
						<li><a href="#tab2">Register</a></li>
					</ul>

					<div class="tabs-container alt">

						<!-- Login -->
						<div class="tab-content" id="tab1" style="display: none;">
							<form method="post" class="login" action="login.php">

								<p class="form-row form-row-wide">
									<label for="username">Username:
										<i class="im im-icon-Male"></i>
										<input type="text" class="input-text" name="username" id="username" value=""/>
									</label>
								</p>

								<p class="form-row form-row-wide">
									<label for="password">Password:
										<i class="im im-icon-Lock-2"></i>
										<input class="input-text" type="password" name="password" id="password"/>
									</label>
									<span class="lost_password">
										<a href="#" >Lost Your Password?</a>
									</span>
								</p>

								<div class="form-row">
									<input type="submit" class="button border margin-top-5" name="login" value="Login" />
									<div class="checkboxes margin-top-10">
										<input id="remember-me" type="checkbox" name="check">
										<label for="remember-me">Remember Me</label>
									</div>
								</div>
							</form>
						</div>

						<!-- Register -->
						<div class="tab-content" id="tab2" style="display: none;">

							<form method="post" action="register.php" class="register">

							<p class="form-row form-row-wide">
								<label for="username2">Your firstname:
									<i class="im im-icon-Male"></i>
									<input type="text" class="input-text" name="firstname" id="firstname" value="" />
								</label>
							</p>

							<p class="form-row form-row-wide">
								<label for="username2">Your lastname:
									<i class="im im-icon-Male"></i>
									<input type="text" class="input-text" name="lastname" id="lastname" value="" />
								</label>
							</p>
								
							<p class="form-row form-row-wide">
								<label id="texthint" for="username2">Username:
									<i class="im im-icon-Male"></i>
									<input type="text" class="input-text" name="username" onfocusout="checkUser('regusername2','hintText2')" id="regusername2" value="" /><p id="hintText2">

								</label>
							</p>
								
							<p class="form-row form-row-wide">
								<label for="email2">Your Email Address:
									<i class="im im-icon-Mail"></i>
									<input type="text" class="input-text" name="email" id="email" value="" />
								</label>
							</p>

							<p class="form-row form-row-wide">
								<label for="email2">Confirm your Email Address:
									<i class="im im-icon-Mail"></i>
									<input type="text" class="input-text" name="email2" id="email2" value="" />
								</label>
							</p>

							<p class="form-row form-row-wide">
								<label for="password1">Your Password:
									<i class="im im-icon-Lock-2"></i>
									<input class="input-text" type="password" name="password" id="password"/>
								</label>
							</p>

							<p class="form-row form-row-wide">
								<label for="password2">Confirm your Password:
									<i class="im im-icon-Lock-2"></i>
									<input class="input-text" type="password" name="password2" id="password2"/>
								</label>
							</p>

							<input type="submit" class="button border fw margin-top-10" name="register" value="Register" />
	
							</form>
						</div>

					</div>
				</div>
			</div>
			<!-- Sign In Popup / End -->

		</div>
	</div>
	<!-- Header / End -->


<div class="clearfix"></div>
<!-- Header Container / End -->


<!-- Banner
================================================== -->
<div style="width:280px;margin: 40px auto;"><h2>Register an account</h2>

	<form method="post" class="register" action="register.php">
			
<?php 
if ($error == true)
{
			echo '<div class="notification error closeable">';
			echo '<p>' . $errorMessage . '</p>';
			echo '<a class="close" href="#"></a>';
			echo '</div>';
}
?>

								<p class="form-row form-row-wide">
								<label for="username2">Your firstname:
									<i class="im im-icon-Male"></i>
									<input type="text" class="input-text" name="firstname" id="firstname" value="" />
								</label>
							</p>

							<p class="form-row form-row-wide">
								<label for="username2">Your lastname:
									<i class="im im-icon-Male"></i>
									<input type="text" class="input-text" name="lastname" id="lastname" value="" />
								</label>
							</p>
								
							<p id="userpar" class="form-row form-row-wide">
								<label for="username2">Your Username:
									<i class="im im-icon-Male"></i>
									<input type="text" class="input-text" name="username" onfocusout="checkUser('regusername','hintText')" id="regusername" value="" /><p id="hintText"></p>
								</label>
							</p>
								
							<p class="form-row form-row-wide">
								<label for="email2">Your Email Address:
									<i class="im im-icon-Mail"></i>
									<input type="text" class="input-text" name="email" id="email" value="" />
								</label>
							</p>

							<p class="form-row form-row-wide">
								<label for="email2">Confirm your Email Address:
									<i class="im im-icon-Mail"></i>
									<input type="text" class="input-text" name="email2" id="email2" value="" />
								</label>
							</p>

							<p class="form-row form-row-wide">
								<label for="password1">Your Password:
									<i class="im im-icon-Lock-2"></i>
									<input class="input-text" type="password" name="password" id="password"/>
								</label>
							</p>

							<p class="form-row form-row-wide">
								<label for="password2">Confirm your Password:
									<i class="im im-icon-Lock-2"></i>
									<input class="input-text" type="password" name="password2" id="password2"/>
								</label>
							</p>

							<input type="submit" class="button border fw margin-top-10" name="register" value="Register" />
	</form>
</div>


<!-- Footer
================================================== -->
<div id="footer" class="sticky-footer">
	<!-- Main -->
	<div class="container">
		<div class="row">
			<div class="col-md-5 col-sm-6">
				<img class="footer-logo" src="images/logo.png" alt="">
				<br><br>
				<p>Morbi convallis bibendum urna ut viverra. Maecenas quis consequat libero, a feugiat eros. Nunc ut lacinia tortor morbi ultricies laoreet ullamcorper phasellus semper.</p>
			</div>

			<div class="col-md-4 col-sm-6 ">
				<h4>Helpful Links</h4>
				<ul class="footer-links">
					<li><a href="#">Login</a></li>
					<li><a href="#">Sign Up</a></li>
					<li><a href="#">My Account</a></li>
					<li><a href="#">Add Listing</a></li>
					<li><a href="#">Pricing</a></li>
					<li><a href="#">Privacy Policy</a></li>
				</ul>

				<ul class="footer-links">
					<li><a href="#">FAQ</a></li>
					<li><a href="#">Blog</a></li>
					<li><a href="#">Our Partners</a></li>
					<li><a href="#">How It Works</a></li>
					<li><a href="#">Contact</a></li>
				</ul>
				<div class="clearfix"></div>
			</div>		

			<div class="col-md-3  col-sm-12">
				<h4>Contact Us</h4>
				<div class="text-widget">
					<span>12345 Little Lonsdale St, Melbourne</span> <br>
					Phone: <span>(123) 123-456 </span><br>
					E-Mail:<span> <a href="#">office@example.com</a> </span><br>
				</div>

				<ul class="social-icons margin-top-20">
					<li><a class="facebook" href="#"><i class="icon-facebook"></i></a></li>
					<li><a class="twitter" href="#"><i class="icon-twitter"></i></a></li>
					<li><a class="gplus" href="#"><i class="icon-gplus"></i></a></li>
					<li><a class="vimeo" href="#"><i class="icon-vimeo"></i></a></li>
				</ul>

			</div>

		</div>
		
		<!-- Copyright -->
		<div class="row">
			<div class="col-md-12">
				<div class="copyrights">© 2018 Bid4myjob. All Rights Reserved.</div>
			</div>
		</div>

	</div>

</div>
<!-- Footer / End -->

<!-- Back To Top Button -->
<div id="backtotop"><a href="#"></a></div>

</div>
<!-- Wrapper / End -->

<!-- Scripts
================================================== -->
<script>
function checkUser(whichInput,whichHint) {
    var x = document.getElementById(whichInput);
    var username = x.value;
    if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
    xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById(whichHint).innerHTML = this.responseText;
            }
        };

        xmlhttp.open("GET","username-exists.php?user="+username,true);
        xmlhttp.send();
}
</script>


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

</body>