<?php

$error = false;
$errorMessage = "";

$servername = "localhost";
$user = "root";
$pass = "";
$dbname = "bid4";
session_start();

if (!isset($_SESSION['Id']))
{
header("Location:index.php");
}

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

if (isset($_GET['id']))
{
$sql = "SELECT * FROM Users WHERE Id=" . $_GET["id"];
$result = $conn->query($sql);

if ($result->num_rows == 1) 

{
$row = $result->fetch_assoc();
}

else
{
	header("Location:index.php");
}
}



?>	

<!-- Basic Page Needs
================================================== -->
<title>Bid4myjob - <?php echo $row["FirstName"];?></title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSS
================================================== -->
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/colors/purple.css" id="colors">

</head>

<body>

<!-- Wrapper -->
<div id="wrapper">

<!-- Wrapper -->
<div id="wrapper">

<?php include 'header.php'; ?>

<!-- Titlebar
================================================== -->
<div id="titlebar" class="gradient">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<div class="user-profile-titlebar">
					<div class="user-profile-avatar"><img src="images/user-profile-avatar.jpg" alt=""></div>
					<div class="user-profile-name">
						<h2><?php echo $row["Username"];?></h2>
					<?php
					$sql = "SELECT * FROM PosterReviews, Users WHERE PosterReviews.PosterId=Users.Id AND PosterReviews.RecipientId=". $row['Id'];

					$posterresult = $conn->query($sql);

					$sql = "SELECT * FROM BidderReviews, Users WHERE BidderReviews.PosterId=Users.Id AND BidderReviews.RecipientId=". $row['Id'];

					$bidderresult = $conn->query($sql);

					$totalReviews = ($posterresult->num_rows + $bidderresult->num_rows);

					?>

						<div id="starRating" class="star-rating" >
							<div class="rating-counter"><?php echo $totalReviews; ?> review(s)</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>



<!-- Content
================================================== -->
<div class="container">
	<div class="row sticky-wrapper">





		<!-- Content
		================================================== -->


			<div class="col-lg-6 col-md-6 padding-left-30">

				<!-- Tabs Content -->
				<div id="posterrev" class="tabs-container">
					<div class="tab-content" id="tabposter">
						<!-- Reviews --><h3>Reviews received as a job poster</h3>
				<section class="comments listing-reviews">

				<?php


					if ($posterresult->num_rows > 0) {
    				// output data of each row
    				while($rowjc = $posterresult->fetch_assoc()) 
    			{
    			?>
					<ul>
						<li>
							<div class="avatar"><img src="http://www.gravatar.com/avatar/00000000000000000000000000000000?d=mm&amp;s=70" alt="" /></div>
							<div class="comment-content"><div class="arrow-comment"></div>
								<div class="comment-by">Review by <a href="view-user.php?id=<?php echo $rowjc['PosterId'];?>"><?php echo $rowjc['Username'];?></a><div class="comment-by-listing">&nbsp;<a href="view-job.php?id=<?php echo $rowjc['JobId'];?>">View Job</a></div> <span class="date"> <?php echo $rowjc['TimeAndDateStamp'];?></span>
									<div class="star-rating" data-rating="<?php echo $rowjc['Rating']; ?>"></div>
								</div>
								<p><?php echo $rowjc['Feedback'];?></p>
								

							</div>
						</li>

					 </ul>
					 			<?php }}
			else{
				echo "<p style='margin-top:64px;'>No reviews to show!</p>";
			} ?>
				</section>
				</div>
				</div>
			</div>

			


			<div class="col-lg-6 col-md-6 padding-left-30">

				<!-- Tabs Content -->
				<div id="posterrev" class="tabs-container">
					<div class="tab-content" id="tabposter">
						<!-- Reviews --><h3>Reviews received as winning bidder</h3>
				<section class="comments listing-reviews">

			<?php 
					


					if ($bidderresult->num_rows > 0) {
    				// output data of each row
    				while($rowjc = $bidderresult->fetch_assoc()) 
    			{
    			?>
					<ul>
						<li>
							<div class="avatar"><img src="http://www.gravatar.com/avatar/00000000000000000000000000000000?d=mm&amp;s=70" alt="" /></div>
							<div class="comment-content"><div class="arrow-comment"></div>
								<div class="comment-by">Review by <a href="view-user.php?id=<?php echo $rowjc['PosterId'];?>"><?php echo $rowjc['Username'];?></a><div class="comment-by-listing">&nbsp;<a href="view-job.php?id=<?php echo $rowjc['JobId'];?>">View Job</a></div> <span class="date"> <?php echo $rowjc['TimeAndDateStamp'];?></span>
									<div class="star-rating" data-rating="<?php echo $rowjc['Rating']; ?>"></div>
								</div>
								<p><?php echo $rowjc['Feedback'];?></p>
								

							</div>
						</li>

					 </ul>

					 			<?php }}
			else{
				echo "<p style='margin-top:64px;'>No reviews to show!</p>";
			} ?>
				</section>
				</div>
				</div>
			</div>


</div>
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


<!-- Style Switcher
================================================== -->
<script src="scripts/switcher.js"></script>

</body>
</html>