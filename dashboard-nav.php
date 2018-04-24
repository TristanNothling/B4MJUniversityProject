	<!-- Navigation
	================================================== -->

	<!-- Responsive Navigation Trigger -->
	<a href="#" class="dashboard-responsive-nav-trigger"><i class="fa fa-reorder"></i> Dashboard Navigation</a>

	<div id="nav" class="dashboard-nav">
		<div class="dashboard-nav-inner">

			<ul data-submenu-title="Main">
				<li><a href="dashboard.php"><i class="sl sl-icon-settings"></i> Dashboard</a></li>
				<li><a><i class="sl sl-icon-layers"></i> My Bids</a>
					<ul>
						<li><a href="dashboard-bidsall.php"> All <!--<span class="nav-tag blue">1</span>--></a></li>
						<li><a href="dashboard-bidswon.php"> Won </a></li>
						<li><a href="dashboard-bidscomplete.php"> Completed </a></li>
					</ul>	
				</li>
			</ul>
			
			<ul data-submenu-title="Jobs">
				<li><a><i class="sl sl-icon-layers"></i> My Jobs</a>
					<ul>
						<li><a href="dashboard-jobsall.php"> All </a></li>
						<li><a href="dashboard-jobsprog.php"> In progress </a></li>
						<li><a href="dashboard-jobscomplete.php"> Completed </a></li>
					</ul>	
				</li>
				<li><a href="dashboard-postjob.php"><i class="sl sl-icon-plus"></i> Post a job</a></li>
			</ul>	

			<ul data-submenu-title="Account">
			<!--	<li><a href="dashboard-reviews.php"><i class="fa fa-calendar-check-o"></i> My Reviews</a></li>
				<li><a href="dashboard-profile.php"><i class="sl sl-icon-user"></i> My Profile</a></li>-->
				<li><a href="logout.php"><i class="sl sl-icon-power"></i> Logout</a></li>
			</ul>
			
		</div>
	</div>
	<!-- Navigation / End -->