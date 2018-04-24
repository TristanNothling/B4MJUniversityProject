<!DOCTYPE html>
<head>

<!-- Basic Page Needs
================================================== -->
<title>Bid4myjob - My Bids</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSS
================================================== -->
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/colors/purple.css" id="colors">

</head>

<body>

<?php
$error = false;
$errorMessage = "";
$servername = "localhost";
$user = "root";
$pass = "";
$dbname = "bid4";
session_start();
if (!isset($_SESSION['Id'])){ header("Location:index.php");} 

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

$sql = "SELECT Bids.Id as bidid,Price,PosterId,Message,JobId,BidderId,DateTimeBid,Jobs.Id as jobid, Users.Id as userid,Username,Title FROM Bids,Jobs,Users WHERE Users.Id=PosterId AND Bids.JobId=Jobs.Id AND BidderId=" . $_SESSION['Id'] ;

#$sql = "SELECT * FROM Jobs WHERE PosterId=" . $_SESSION['Id'] ;
$result = $conn->query($sql);

?>


<!-- Wrapper -->
<div id="wrapper">

<?php include 'dashboard-header.php'; ?>

<!-- Dashboard -->
<div id="dashboard">

	<?php include 'dashboard-nav.php'; ?>

	<!-- Content
	================================================== -->
	<div class="dashboard-content">

		<!-- Titlebar -->
		<div id="titlebar">
			<div class="row">
				<div class="col-md-12">
					<h2>My Bids</h2>
					<!-- Breadcrumbs -->
					<nav id="breadcrumbs">
						<ul>
							<li><a href="#">Home</a></li>
							<li><a href="#">Dashboard</a></li>
							<li>My Bids</li>
						</ul>
					</nav>
				</div>
			</div>
		</div>

		<div class="row">
			
			<!-- Listings -->
			<div class="col-lg-12 col-md-12">
				<div class="dashboard-list-box margin-top-0">
					<h4>All Bids</h4>
					
					<ul>

<?php 

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) 
    {
    
?>

						<li>
							<div class="list-box-listing">

								<div class="list-box-listing-content">
									<div class="inner">
										<h3><a href='view-job.php?id=<?php echo $row["jobid"]; ?>'><?php echo $row["Title"]; ?></a></h3>
										<p style="color:#704FEC;">Posted by: <a href='view-user.php?id=<?php echo $row["PosterId"]; ?>'><?php echo $row["Username"]; ?></a></p> 
										  
										<span style="font-size:20px;margin:16px;color:#704FEC;">For <?php echo $row["Price"]; ?> credits.</span></br>
										<span>Your message: <?php if (strlen($row["Message"]) < 100) 
									{ 
										echo $row["Message"]; 
									} 
									else 
									{
										echo substr($row["Message"],0,100)."...";
									} ?></span>
									</div>
								</div>
							</div>
							<div class="buttons-to-right">
								<a href='view-job.php?id=<?php echo $row["jobid"]; ?>' class="button gray"><i class="sl sl-icon-note"></i>View Job</a>
							</div>
						</li>

<?php
}
}
else
{
	echo "<p style='padding:32px;'>It looks like you haven&apos;t bidded on any jobs. Why not <a href='browse-jobs.php'>bid on one now?</a></p>";
}
?>

					</ul>
				</div>
			</div>


			<!-- Copyrights -->
			<div class="col-md-12">
				<div class="copyrights">© 2018 Bid4MyJob. All Rights Reserved.</div>
			</div>
		</div>

	</div>
	<!-- Content / End -->


</div>
<!-- Dashboard / End -->


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