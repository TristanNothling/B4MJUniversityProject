<!DOCTYPE html>
<head>

<!-- Basic Page Needs
================================================== -->
<title>Bid4myjob - Error</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSS
================================================== -->
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/colors/purple.css" id="colors">

<?php session_start(); ?>
</head>

<body>

<!-- Wrapper -->
<div id="wrapper">

<?php include 'header.php'; ?>

<div class="clearfix"></div>
<!-- Header Container / End -->

<div style="width:280px;margin: 40px auto;">
<!-- Header Container / End -->
			
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
    echo "Connection failed: " . $conn->connect_error;
} 

$sql = "USE bid4";

if ((mysqli_query($conn, $sql))==false)
{
    echo "Error using database: " . mysqli_error($conn);
}


if (isset($_SESSION['ErrorMessage']))
{
			echo '<div class="notification error closeable">';
			echo '<p>' . $_SESSION['ErrorMessage'] . '</p>';
			echo '<a class="close" href="#"></a>';
			echo '</div>';
			unset($_SESSION['ErrorMessage']);
}
else
{

			echo '<p>No errors, yay!</p>';

}
?>

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
