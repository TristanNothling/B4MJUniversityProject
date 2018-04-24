<!DOCTYPE html>
<head>

<?php

$error = false;
$errorMessage = "";

$servername = "localhost";
$user = "root";
$pass = "";
$dbname = "bid4";
session_start();
$bidded=false;

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
$sql = "SELECT * FROM Jobs WHERE Id=" . $_GET["id"];
$result = $conn->query($sql);

if ($result->num_rows == 1) 
{
$row = $result->fetch_assoc();
}
else
{
	header("Location:no-job.php");
}
}

else
{
	header("Location:no-job.php");
}

?>	

<!-- Basic Page Needs
================================================== -->
<title>Bid4myjob - <?php echo $row["Title"];?></title>
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

<?php include 'header.php'; ?>

<!-- Slider
	================================================== -->

<!-- Content
================================================== -->
<div class="container">
	<div class="row sticky-wrapper">
		<div class="col-lg-8 col-md-8 padding-right-30">

			<!-- Titlebar -->
			<div id="titlebar" class="listing-titlebar">
				<div class="listing-titlebar-title">
					<h2><?php echo $row["Title"] ?>&nbsp;<span class="listing-tag">
					<?php $sql = "SELECT * FROM Categories WHERE Categories.Id=" . $row['CategoryId'];
					$result2 = $conn->query($sql);
					$catRow = $result2->fetch_assoc();
					echo $catRow["Name"]; ?>
					</span></h2>
					<span>

					<?php if (isset($row['Complete']))
					{ ?>	
						<h3 style="color:#29c457;">This job has been completed. <i class='sl sl-icon-check'></i></h3>

					<?php } else { ?>

						<a href="#listing-location" class="listing-address">
							<i class="fa fa-map-marker"></i>
							<?php echo $row["Location"] ?></a>, <?php echo $row['Postcode']; ?>
							
							<p>Suggested budget:<span style="color:#f48f42;font-size:24px;">&nbsp;
							<i class="im im-icon-Money"></i> <?php echo $row["Budget"] ?></span></p>
						
					<?php } ?>
					</span>
				</div>
			</div>

			<!-- Listing Nav -->
			<div id="listing-nav" class="listing-nav-container">
				<h3>Description</h3>
			</div>
			
			<!-- Overview -->
			<div id="listing-overview" class="listing-section">

				<!-- Description -->

				<p style="padding:16px;background-color:#f9f7f4"><?php echo $row["Description"] ?></p>

				<?php 
				if (isset($_SESSION['Id'])){ 
				if ($row['PosterId']==$_SESSION['Id'] && isset($row['WinnerId'])) 
					{ 
					if (!isset($row['Complete'])){
					?>
						<form id="markcomplete" name="mark-complete" action="mark-complete.php" method="POST">
						<input style="display:none;" type="text" name="jobid" value="<?php echo $row["Id"]; ?>"></input>
						<button type="submit" name="mark-complete" class="button">Mark as complete</button>
						</form>
				<?php 
					}
					else
					{
				?>
						<form id="reviewBidder" name="review-bidder" action="review-bidder.php" method="POST">
						<input style="display:none;" type="text" name="userid" value="<?php echo $row['WinnerId']; ?>"></input>
						<button type="submit" name="review" class="button">Review Bidder</button>
						</form>
				<?php
				}
				}
				if ($row['WinnerId']==$_SESSION['Id'] && isset($row['Complete']))
				{
					#ideally database code, check if review already exists for this job id and bidder
				?>
						<form id="reviewPoster" name="review-poster" action="review-poster.php" method="POST">
						<input style="display:none;" type="text" name="userid" value="<?php echo $row['PosterId']; ?>"></input>
						<button type="submit" name="review" class="button">Review Job Poster</button>
						</form>
				<?php  
				}
				}
				?>


				<h4 class="headline margin-top-70 margin-bottom-30">Bids</h4>
				<span id="whowon"></span>
				<table class="basic-table">

					<?php $sql = "SELECT a.BidderId, a.Price, a.Message, b.Username, b.Id, a.Id as bidId FROM Bids a, Users b WHERE a.BidderId=b.Id AND a.JobId=" . $_GET['id'];

					$bidresult = $conn->query($sql);

					if ($bidresult->num_rows > 0) { ?>

				<tr>
					<th>User </th>
					<th>Bid </th>
					<th>Message </th>
					<?php if (isset($_SESSION['Id']) && $_SESSION['Id'] == $row['PosterId'] && !isset($row["WinnerId"])) { ?>
					<th>Select Job taker </th>
					<?php }  ?>
				</tr>
				<?php

				while($bidrow = $bidresult->fetch_assoc()){ 

						if (isset($_SESSION['Id']) && $bidrow["BidderId"] == $_SESSION['Id']){
							$bidded=true;
						}
				?>
				<tr>
					<td data-label="Username">
						<a href="view-user.php?id=<?php echo $bidrow["BidderId"] ?>"><?php echo $bidrow["Username"]; ?></a>		
						<?php 
						if ($row["WinnerId"]==$bidrow["BidderId"]) 
						{ 
							$winner = $bidrow["Username"]
							?>
							<b style='color:#29c457;font-size:24px;'><i class='sl sl-icon-check'></i></b>
							
						<?php
						} 
						?>

					</td>
					<td data-label="Price"><?php echo $bidrow["Price"] ?></td>
					<td data-label="Message"><?php echo $bidrow["Message"] ?></td>
					<?php if (isset($_SESSION['Id']) && $_SESSION['Id'] == $row['PosterId'] && !isset($row["WinnerId"])) { ?>
						<td data-label="Select winner">
						<form id="choose" name="choose" action="choose-bidder.php" method="POST">
						<input style="display:none;" type="text" name="bidderid" value="<?php echo $bidrow["BidderId"] ?>"></input>
						<input style="display:none;" type="text" name="jobid" value="<?php echo $row["Id"]; ?>"></input>
						<input style="display:none;" type="text" name="winningbidid" value="<?php echo $bidrow["bidId"]; ?>"></input>
						<button type="submit" name="choose" class="button">Choose</button>
						</form>
						</td> 
						<?php } 
						?>
						</td>
				<?php } ?>
				</tr>

				<?php }else { ?> <p>No bids at the moment.</p> <?php } ?>

			</table>

					 

				<?php 
					$sql = "SELECT * FROM Jobs WHERE Id=" . $row["CategoryId"];
					$result2 = $conn->query($sql);
					$catRow = $result2->fetch_assoc();

					$sql = "SELECT * FROM Users WHERE Id=" . $row["PosterId"];
					$result3 = $conn->query($sql);
					$userRow = $result3->fetch_assoc(); 

					if (isset($_SESSION['Id'])) { 
						if ($_SESSION['Id'] != $row['PosterId']) { 
							if(!$bidded) {
								if (!isset($row["WinnerId"])){
								?>
				<a href="#small-dialog" class="send-message-to-owner button popup-with-zoom-anim"><i class="sl sl-icon-fire"></i>&nbsp;Bid on this job!</a>
					<?php } else { ?>
					<p style="margin-top:32px;">The poster has chosen a winning bidder.</p>
					<?php }} else { ?>
					<p style="margin-top:32px;">You can&apos;t bid again or once a winner has been chosen.</p>
					<?php }}
					 } else { ?>
					<p id="whowon2no" style="margin-top:32px;">Want to bid or choose a winning bidder? Please sign in.</p>
					<?php } ?>
					
				
			<!-- Location 
			<div id="listing-location" class="listing-section">
				
				<h3 class="listing-desc-headline margin-top-60 margin-bottom-30">Location</h3>

				<div id="map"><?php echo $row['Postcode']; ?></div>

			</div>
				-->

		</div>
			<!-- Add Review Box / End -->
		</div>

		<!-- Sidebar
		================================================== -->
		<div class="col-lg-4 col-md-4 margin-top-75 sticky">

			<!-- Contact -->
			<div class="boxed-widget margin-top-35">
				<div class="hosted-by-title">


					<h4><span>Posted by</span> <a href="view-user.php?id=<?php echo $userRow["Id"]; ?> "> <?php echo $userRow["Username"]; ?> </a></h4>
					<a href="pages-user-profile.html" class="hosted-by-avatar"><img src="images/dashboard-avatar.jpg" alt=""></a>
					</div>

				<!-- Bid on Job -->
				<div id="small-dialog" class="zoom-anim-dialog mfp-hide">
					<div class="small-dialog-header">
						<h3>Bidding on <?php echo $row["Title"]; ?></h3>
					</div>
					<div class="message-reply margin-top-0">
						<form id="biddingForm" name="bidsubmit" action="bid.php" method="POST">
						<input type="text" name="price" placeholder="Your bid amount"></input>
						<textarea cols="40" name="message" rows="3" placeholder="Your message to <?php echo ucwords($userRow["FirstName"]); ?>."></textarea>
						<input style="display:none;" type="text" name="jobid" value="<?php echo $row["Id"]; ?>"></input>
						<input type="submit" name="bidsubmit"></input></form>

					</div>
				</div>
				<p>This job was posted on <?php 
				
				$date = $row["PostDate"];
				$convertDate = date('F jS, Y', strtotime($date));
				$time = $row["PostDate"];
				$convertTime = date('h:i a', strtotime($time));
				echo $convertDate . ' at ' .$convertTime . '.';

				//if time permits, will introduce proper 
				?>

				<!-- <a href="#small-dialog" class="send-message-to-owner button popup-with-zoom-anim"><i class="sl sl-icon-envelope-open"></i> Send Message to job poster</a> -->
			</div>
			<!-- Contact / End-->

			<!-- Share / Like -->
			<div class="listing-share margin-top-40 margin-bottom-40 no-border">


					<!-- Share Buttons -->
					<ul class="share-buttons margin-top-40 margin-bottom-0">
						<li><a class="fb-share" href="#"><i class="fa fa-facebook"></i> Share</a></li>
						<li><a class="twitter-share" href="#"><i class="fa fa-twitter"></i> Tweet</a></li>
						<li><a class="gplus-share" href="#"><i class="fa fa-google-plus"></i> Share</a></li>
						<!-- <li><a class="pinterest-share" href="#"><i class="fa fa-pinterest-p"></i> Pin</a></li> -->
					</ul>
					<div class="clearfix"></div>
			</div>

		</div>
		<!-- Sidebar / End -->

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

<!-- Maps -->
<script type="text/javascript" src="scripts/infobox.min.js"></script>
<script type="text/javascript" src="scripts/markerclusterer.js"></script>


<!-- Script which sets the map data correctly -->
					<?php if (!isset($row['Complete']))
					{ ?>	
<script>$('#whowon').replaceWith("<p style='margin:16px;'> Well done <?php echo $winner; ?>, you were chosen to take on this job. Once complete, please remind the poster to mark the job as complete on this page to ensure payment is made.");</script>
<script>$('#whowon2').replaceWith("<p style='margin:16px;'> Bidding is no longer permitted as a winner has been chosen.</p>");
</script>
<?php } ?>
	
<!-- Date Picker - docs: http://www.vasterad.com/docs/listeo/#!/date_picker -->
<link href="css/plugins/datedropper.css" rel="stylesheet" type="text/css">
<script src="scripts/datedropper.js"></script>
<script>$('#booking-date').dateDropper();</script> 



<!-- Time Picker - docs: http://www.vasterad.com/docs/listeo/#!/time_picker -->
<script src="scripts/timedropper.js"></script>
<link rel="stylesheet" type="text/css" href="css/plugins/timedropper.css"> 
<script>
this.$('#booking-time').timeDropper({
	setCurrentTime: false,
	meridians: true,
	primaryColor: "#f91942",
	borderColor: "#f91942",
	minutesInterval: '15'
});

var $clocks = $('.td-input');
	_.each($clocks, function(clock){
	clock.value = null;
});
</script> 

<!-- Booking Widget - Quantity Buttons -->
<script src="scripts/quantityButtons.js"></script>

</body>
</html> <!-- blaze it -->