<!DOCTYPE html>
<head>

<!-- Basic Page Needs
================================================== -->
<title>Bid4myjob - Post a Job</title>
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
session_start();
$last_id = null;

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

if (isset($_SESSION['Id']))
{
if (isset($_POST['postjob']))
{

	#error checking code for now

  if (empty($_POST["title"]) or empty($_POST["description"]) or empty($_POST["budget"]))
  {
		
		$_SESSION['ErrorMessage'] = "You left a required field blank! It was either the title, description or budget. Click back on your browser to try again.";
		header("Location:refer-error.php");
		exit();
  }

    if (!is_numeric($_POST["budget"]))
  {
		
		$_SESSION['ErrorMessage'] = "Please do not enter any currency details, full stops or commas in the budget field. Click back on your browser to try again.";
		header("Location:refer-error.php");
		exit();
  }

  #prepared statements are made use of to prevent the use of MySQL injection
	
$stmt = $conn->prepare("INSERT INTO Jobs (Title,Description,Location,Postcode,PostDate,Budget,PosterId,CategoryId) 
	VALUES (?,?,?,?,?,?,?,?)");
$stmt->bind_param("sssssiii",$title,$description,$location,$postcode,$postdate,$budget,$posterid,$categoryID);

$title = mysql_real_escape_string($_POST["title"]);
$description = mysql_real_escape_string($_POST["description"]);
$location = mysql_real_escape_string($_POST["location"]);
$postcode = mysql_real_escape_string($_POST["postcode"]);
$budget = mysql_real_escape_string($_POST["budget"]);
$postdate = date('Y-m-d H:i:s');
$posterid = $_SESSION['Id'];
$categoryID = $_POST["category"];

$stmt->execute();
$last_id = $conn->insert_id;
}
}
else
{
header("Location:index.php");
}

?>

<!-- Wrapper -->

	<?php if ($last_id != null) { ?>

	<p style="margin:32px;">Thanks for posting a job. Here&apos;s the listing.</p>
	<p style="margin:32px;">If you are not re-directed within 5 seconds, please <a href="view-job.php?id=<?php echo $last_id ?>">click here.</a></p>
	<script>
	window.location = 'view-job.php?id=<?php echo $last_id ?>';
	</script>
	
	<?php } ?>

<div id="wrapper">

<?php include 'dashboard-header.php'; ?>

<!-- Dashboard -->
<div id="dashboard">

	<?php if ($last_id != null) { ?>
	<script>
	window.location = 'view-job.php?id=<?php echo $last_id ?>';
	</script>
	<?php } ?>

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
						<li><a href="dashboard-jobsall.php"> All <span class="nav-tag blue">6</span></a></li>
						<li><a href="dashboard-jobsprog.php"> In progress <span class="nav-tag blue">1</span></a></li>
						<li><a href="dashboard-jobscomplete.html"> Completed <span class="nav-tag green">2</span></a></li>
					</ul>	
				</li>
				<li class="active"><a href="dashboard-postjob.php"><i class="sl sl-icon-plus"></i> Post a job</a></li>
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
					<h2>Post a job</h2>
					<!-- Breadcrumbs -->
					<nav id="breadcrumbs">
						<ul>
							<li><a href="#">Home</a></li>
							<li><a href="#">Dashboard</a></li>
							<li>Post a job</li>
						</ul>
					</nav>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">

				<div id="add-listing">

					<!-- Section -->
					<div class="add-listing-section">
						<form action="dashboard-postjob.php" method="post">

						<!-- Headline -->
						<div class="add-listing-headline">
							<h3><i class="sl sl-icon-doc"></i>What needs completing?</h3>
						</div>

						<!-- Title -->
						<div class="row with-forms">
							<div class="col-md-12">
								<h5>Quickly describe the job. You can also use hashtags.<i class="tip" data-tip-content="For search results. No more than 24 words please."></i></h5>
								<input class="search-field" type="text" name="title" value=""/>
								Describe in more depth the task that needs completing. Please indicate if you can how long you expect it to take.<textarea rows="2" cols="30" name="description"></textarea>
							</div>
						</div>

						<!-- Row -->
						<div class="row with-forms">

							<!-- Status -->
							<div class="col-md-6">
								<h5>Category</h5>
								<select class="chosen-select-no-single" type="text" name="category" >


<?php
$sql = "SELECT * FROM Categories";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()) 
    {
        echo "<option value='" . $row["Id"] . "'>" . $row["Name"] . "</option>";
    }

?>

								</select>
							</div>

							<!-- Type -->
							<div class="col-md-6">
								<h5>Suggested budget for completion: <i class="tip" data-tip-content="(In digital credits. Please only enter whole numbers.)"></i></h5>
								<input type="text" name="budget">
							</div>

						</div>
						<!-- Row / End -->

					</div>
					<!-- Section / End -->

					<!-- Section -->
					<div class="add-listing-section margin-top-45">

						<!-- Headline -->
						<div class="add-listing-headline">
							<h3><i class="sl sl-icon-location"></i> Location</h3>
						</div>

						<div class="submit-section">

							<!-- Row -->
							<div class="row with-forms">


								<!-- Address -->
								<div class="col-md-6">
									<h5>Where is the job? (Displayed on the listing.)</h5>
									<input type="text" name="location">
								</div>

								<!-- City -->
								<div class="col-md-6">
									<h5>What about the postcode? (Not displayed. Only used to calculate distances.)</h5>
									<input type="text" name="postcode"><br>
								</div>


							</div>
							<!-- Row / End -->

						</div>
					</div>
					<!-- Section / End -->
					<input type="submit" class="button preview" value="Post Job!" name="postjob">
				</form>
				</div>
			</div>

			<!-- Copyrights -->
			<div class="col-md-12">
				<div class="copyrights">© 2018 Bid 4 My Job. All Rights Reserved.</div>
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

<!-- DropZone | Documentation: http://dropzonejs.com -->
<script type="text/javascript" src="scripts/dropzone.js"></script>


</body>
</html>