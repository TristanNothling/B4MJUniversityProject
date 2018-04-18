<!DOCTYPE html>
<head>

<!-- Basic Page Needs
================================================== -->
<title>Bid4myjob - Dashboard</title>
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

$sql = "SELECT Jobs.Id,PosterID,Title,Description,Location,Postcode,Name,Categories.Id as catid FROM Jobs, Categories WHERE Categories.Id=Jobs.CategoryId AND PosterId=" . $_SESSION['Id'] ;

#$sql = "SELECT * FROM Jobs WHERE PosterId=" . $_SESSION['Id'] ;
$result = $conn->query($sql);

?>


<!-- Wrapper -->
<div id="wrapper">

<?php include 'dashboard-header.php'; ?>

<!-- Dashboard -->
<div id="dashboard">

	<!-- Navigation
	================================================== -->

	<!-- Responsive Navigation Trigger -->
	<a href="#" class="dashboard-responsive-nav-trigger"><i class="fa fa-reorder"></i> Dashboard Navigation</a>

	<div class="dashboard-nav">
		<div class="dashboard-nav-inner">

			<ul data-submenu-title="Main">
				<li><a href="dashboard.php"><i class="sl sl-icon-settings"></i> Dashboard</a></li>
				<li><a href="dashboard-messages.php"><i class="sl sl-icon-envelope-open"></i> Messages <span class="nav-tag messages">1</span></a></li>
				<li><a><i class="sl sl-icon-layers"></i> My Bids</a>
					<ul>
						<li><a href="dashboard-bidsall.php"> All <span class="nav-tag blue">1</span></a></li>
						<li><a href="dashboard-bidswon.php"> Won <span class="nav-tag blue">1</span></a></li>
						<li><a href="dashboard-bidscomplete.php"> Completed <span class="nav-tag green">1</span></a></li>
					</ul>	
				</li>
			</ul>
			
			<ul data-submenu-title="Jobs">
				<li><a><i class="sl sl-icon-layers"></i> My Jobs</a>
					<ul>
						<li class="active"><a href="dashboard-jobsall.php"> All <span class="nav-tag blue">6</span></a></li>
						<li><a href="dashboard-jobsprog.php"> In progress <span class="nav-tag blue">1</span></a></li>
						<li><a href="dashboard-jobscomplete.html"> Completed <span class="nav-tag green">2</span></a></li>
					</ul>	
				</li>
				<li><a href="dashboard-postjob.php"><i class="sl sl-icon-plus"></i> Post a job</a></li>
			</ul>	

			<ul data-submenu-title="Account">
				<li><a href="dashboard-reviews.php"><i class="fa fa-calendar-check-o"></i> My Reviews</a></li>
				<li><a href="dashboard-profile.php"><i class="sl sl-icon-user"></i> My Profile</a></li>
				<li><a href="logout.php"><i class="sl sl-icon-power"></i> Logout</a></li>
			</ul>
			
		</div>
	</div>
	<!-- Navigation / End -->

	<!-- Content
	================================================== -->
	<div class="dashboard-content">

		<!-- Titlebar -->
		<div id="titlebar">
			<div class="row">
				<div class="col-md-12">
					<h2>My Jobs</h2>
					<!-- Breadcrumbs -->
					<nav id="breadcrumbs">
						<ul>
							<li><a href="#">Home</a></li>
							<li><a href="#">Dashboard</a></li>
							<li>My Jobs</li>
						</ul>
					</nav>
				</div>
			</div>
		</div>

		<div class="row">
			
			<!-- Listings -->
			<div class="col-lg-12 col-md-12">
				<div class="dashboard-list-box margin-top-0">
					<h4>All jobs</h4>
					
					<ul>

<?php 

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) 
    {
    
?>

						<li>
							<div class="list-box-listing">
								<div class="list-box-listing-img"><a href='view-job.php?id=<?php echo $row["Id"]; ?>'><img src="images/listing-item-01.jpg" alt=""></a></div>
								<div class="list-box-listing-content">
									<div class="inner">
										<h3><a href='view-job.php?id=<?php echo $row["Id"]; ?>'><?php echo $row["Title"]; ?> </a></h3>
										<span><?php echo $row["Location"]; ?></span>
										<p style="color:#704FEC;"><?php echo $row["Name"]; ?> </p>
									</div>
								</div>
							</div>
							<div class="buttons-to-right">
								<a href='view-job.php?id=<?php echo $row["Id"]; ?>' class="button gray"><i class="sl sl-icon-note"></i>0 Bids (View)</a>
								<a href='delete-job.php?id=<?php echo $row["Id"]; ?>' class="button gray"><i class="sl sl-icon-close"></i> Delete</a>
							</div>
						</li>

<?php
}
}
else
{
	echo "<p style='padding:32px;'>It looks like you haven&apos;t posted any jobs. Why not <a href='dashboard-postjob.php'>post one now?</a></p>";
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