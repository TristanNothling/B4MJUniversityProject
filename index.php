<?php session_start(); ?>

<!DOCTYPE html>
<head>

<!-- Basic Page Needs
================================================== -->
<title>Bid4myjob - Home</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSS
================================================== -->
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/colors/purple.css" id="colors">

</head>

<body>

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
    $error = true;
	$errorMessage = "There was a problem connecting to the database.";
} 

$sql = "USE bid4";

if (!mysqli_query($conn, $sql)) 
{
    $error = true;
	$errorMessage = "The database can't be found!";
} 

date_default_timezone_set('Europe/London'); #To correct an error where registered users were given a reg date an hour late.
?>

<!-- Wrapper -->
<div id="wrapper">

<?php include 'header.php'; ?> <!-- For -->

<!-- Banner
================================================== -->
<div class="main-search-container" data-background-image="images/main-search-background-01.jpg">
	<div class="main-search-inner">

		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2>Need a little hand with something?</h2>
					<h4>Let&apos;s help you find someone to do it.</h4>

					<div class="main-search-input">

						<div class="main-search-input-item">
							<input type="text" placeholder="Describe the job" value=""/>
						</div>

						<div class="main-search-input-item location">
							<input type="text" placeholder="Where is it?" value=""/>
							<a href="#"><i class="fa fa-dot-circle-o"></i></a>
						</div>



						<button class="button" onclick="window.location.href='dashboard-postjob.php'">Post your job</button>

					</div>
				</div>
			</div>
		</div>

	</div>
</div>


<!-- Content
================================================== -->
<div class="container">
	<div class="row">

		<div class="col-md-12">
			<h3 class="headline centered margin-top-75">
				Want to earn some extra cash?
				<span>Browse <i>jobs that are live and can be bidded on</i> now!</span>
			</h3>
		</div>

	</div>
</div>


<!-- Categories Carousel -->
<div class="fullwidth-carousel-container margin-top-25">
	<div class="fullwidth-slick-carousel category-carousel">

		<!-- Item -->
		<div class="fw-carousel-item">

			<!-- this (first) box will be hidden under 1680px resolution -->
			<div class="category-box-container half">
				<a href="browse-jobs.php" class="category-box" data-background-image="images/category-box-01.jpg">
					<div class="category-box-content">
						<h3>Hotels</h3>
						<span>64 listings</span>
					</div>
					<span class="category-box-btn">Browse</span>
				</a>
			</div>

			<div class="category-box-container half">
				<a href="browse-jobs.php" class="category-box" data-background-image="images/category-box-02.jpg">
					<div class="category-box-content">
						<h3>Shops</h3>
						<span>14 listings</span>
					</div>
					<span class="category-box-btn">Browse</span>
				</a>
			</div>
		</div>

		<!-- Item -->
		<div class="fw-carousel-item">
			<div class="category-box-container">
				<a href="browse-jobs.php" class="category-box" data-background-image="images/category-box-03.jpg">
					<div class="category-box-content">
						<h3>Events</h3>
						<span>67 listings</span>
					</div>
					<span class="category-box-btn">Browse</span>
				</a>
			</div>
		</div>

		<!-- Item -->
		<div class="fw-carousel-item">
			<div class="category-box-container">
				<a href="browse-jobs.php" class="category-box" data-background-image="images/category-box-04.jpg">
					<div class="category-box-content">
						<h3>Fitness</h3>
						<span>27 listings</span>
					</div>
					<span class="category-box-btn">Browse</span>
				</a>
			</div>
		</div>

		<!-- Item -->
		<div class="fw-carousel-item">
			<div class="category-box-container">
				<a href="browse-jobs.php" class="category-box" data-background-image="images/category-box-05.jpg">
					<div class="category-box-content">
						<h3>Nightlife</h3>
						<span>22 listings</span>
					</div>
					<span class="category-box-btn">Browse</span>
				</a>
			</div>
		</div>

		<!-- Item -->
		<div class="fw-carousel-item">
			<div class="category-box-container">
				<a href="browse-jobs.php" class="category-box" data-background-image="images/category-box-06.jpg">
					<div class="category-box-content">
						<h3>Eat & Drink</h3>
						<span>130 listings</span>
					</div>
					<span class="category-box-btn">Browse</span>
				</a>
			</div>
		</div>

	</div>
</div>
<!-- Categories Carousel / End -->

<!-- Info Section -->
<div class="container">

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h2 class="headline centered margin-top-80">
				You can find someone to help you complete that task.
				<span class="margin-top-25">Here&apos;s how easy it is with bid4myjob.</span>
			</h2>
		</div>
	</div>

	<div class="row icons-container">
		<!-- Stage -->
		<div class="col-md-4">
			<div class="icon-box-2 with-line">
				<i class="im im-icon-Map2"></i>
				<h3>Post a job</h3>
				<p>It will appear live amongst other jobs that users have posted and potential bidders will see it.</p>
			</div>
		</div>

		<!-- Stage -->
		<div class="col-md-4">
			<div class="icon-box-2 with-line">
				<i class="im im-icon-Mail-withAtSign"></i>
				<h3>Potential helpers bid</h3>
				<p>They might cite certain conditions or a lower budget than you specified. It&apos;s up to you who takes on the job.</p>
			</div>
		</div>

		<!-- Stage -->
		<div class="col-md-4">
			<div class="icon-box-2">
				<i class="im im-icon-Checked-User"></i>
				<h3>Job done!</h3>
				<p>Payment is only processed once you confirm you are happy with the quality of the completed job.</p>
			</div>
		</div>
	</div>

</div>
<!-- Info Section / End -->


<?php include 'blog-posts-section.php'; ?> 

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