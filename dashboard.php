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

$sql = "SELECT * FROM Users WHERE Id=" . $_SESSION['Id'];
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
					<?php if ($error==false){ ?>
					<h2>Welcome to the dashboard, <?php echo ucwords($_SESSION['FirstName']); ?>.</h2>
					<?php } else { ?> <h2><?php echo $errorMessage; } ?> </h2>
					<!-- Breadcrumbs -->
					<nav id="breadcrumbs">
						<ul>
							<li><a href="index.php">Home</a></li>
							<li>Dashboard</li>
						</ul>
					</nav>
				</div>
			</div>
		</div>

		<!-- Content -->
		<div class="row">



<?php 

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) 
    {
    
?>
		<!-- Item -->
			<div class="col-lg-3 col-md-6">
				<div class="dashboard-stat color-1">
					<div class="dashboard-stat-content"><h4><?php echo $row["Credits"]; ?></h4> <span>Credits</span></div>
					<div class="dashboard-stat-icon"><i class="im im-icon-Token-"></i></div>
				</div>
			</div>

		<!-- Item calculate by selecting all reviews as poster and bidder, calculating result-->
			<div class="col-lg-3 col-md-6">
				<div class="dashboard-stat color-3">
					<div class="dashboard-stat-content"><h4>5</h4> <span>Average review score (out of 5)</span></div>
					<div class="dashboard-stat-icon"><i class="im im-icon-Add-UserStar"></i></div>
				</div>
			</div>


<?php 
	}}

	$sql = "SELECT * FROM Jobs WHERE Complete=TRUE AND WinnerId=" . $_SESSION['Id'];
	$result = $conn->query($sql);
	$numberJobs = $result->num_rows;
	?>

		<!-- Item select all jobs where bidderID=sessionID and complete=true, count number of rows-->
			<div class="col-lg-3 col-md-6">
				<div class="dashboard-stat color-5">
					<div class="dashboard-stat-content"><h4><?php echo $numberJobs; ?></h4> <span>Jobs you&apos;ve completed</span></div>
					<div class="dashboard-stat-icon"><i class="im im-icon-Tee-Mug"></i></div>
				</div>
			</div>

			<?php 
	
	$sql = "SELECT * FROM Bids WHERE BidderId=" . $_SESSION['Id'];
	$result = $conn->query($sql)->num_rows;

	$sql = "SELECT * FROM Jobs WHERE WinnerId=" . $_SESSION['Id'];
	$result2 = $conn->query($sql)->num_rows;

	$biddingRate = ($result/$result2)*100
	?>

		<!-- Item count rows of jobs you've bid on divided by number of jobs you won, * by 100-->
			<div class="col-lg-3 col-md-6">
				<div class="dashboard-stat color-4">
					<div class="dashboard-stat-content"><h4><?php echo $biddingRate; ?></h4> <span>Bidding success rate (&#37;)</span></div>
					<div class="dashboard-stat-icon"><i class="im im-icon-Money-Smiley"></i></div>
				</div>
			</div>



<div class="col-lg-6 col-md-12">
				<div class="dashboard-list-box invoices with-icons margin-top-20">
					<h4>Recent Payments Sent</h4>
					<ul>
<?php 
$sql = "SELECT * FROM Transactions WHERE SenderId=" . $_SESSION['Id']. " ORDER BY EscrowStart DESC LIMIT 5";

$result = $conn->query($sql);

if ($result->num_rows > 0) 
{
	while($recent_transactions = $result->fetch_assoc())
    { 

?>
						<li>
							<strong>Sent</strong>
							<ul>
								<li style="font-size:20px;" class="unpaid">-<?php echo $recent_transactions['Amount']; ?></li>
								<li>Transaction Id: <?php echo $recent_transactions['Id']; ?></li>
								<li>To: <?php echo $recent_transactions['RecipientId']; ?></li>
								<li>When: <?php echo $recent_transactions['EscrowStart']; ?></li></br></br>
								<li style="font-size:16px;" >Status: <?php if (isset($recent_transactions['Complete'])){ echo "Completed."; } else { echo "In Escrow.";} ?></li>
							</ul><?php if (isset($recent_transactions['Complete'])){ ?>
							<div class="buttons-to-right">
								<a href="view-job.php?id=<?php echo $recent_transactions['JobId']; ?>" class="button gray">View Job</a>
							</div>
							<?php } ?>
						</li>

						<?php 
	}
}
						 ?>


					</ul>
				</div>
			</div>

			<div class="col-lg-6 col-md-12">
				<div class="dashboard-list-box invoices with-icons margin-top-20">
					<h4>Recent Payments Received</h4>
					<ul>
<?php 
$sql = "SELECT * FROM Transactions WHERE RecipientId=" . $_SESSION['Id']. " ORDER BY EscrowFinish DESC LIMIT 5";

$result = $conn->query($sql);

if ($result->num_rows > 0) 
{
	while($recent_transactions = $result->fetch_assoc())
    { 

?>
						<li>
							<strong>Received</strong>
							<ul>
								<li style="font-size:20px;" class="paid"><?php echo $recent_transactions['Amount']; ?></li>
								<li>Transaction Id: <?php echo $recent_transactions['Id']; ?></li>
								<li>From: <?php echo $recent_transactions['SenderId']; ?></li>
								<li>When: <?php echo $recent_transactions['EscrowStart']; ?></li></br></br>
								<li style="font-size:16px;" >Status: <?php if (isset($recent_transactions['Complete'])){ echo "Completed."; } else { echo "In Escrow.";} ?></li>
							</ul><?php if (isset($recent_transactions['Complete'])){ ?>
							<div class="buttons-to-right">
								<a href="view-job.php?id=<?php echo $recent_transactions['JobId']; ?>" class="button gray">View Job</a>
							</div>
							<?php } ?>
						</li>

						<?php 
	}
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