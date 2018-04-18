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
						<li><a href="browse-jobs.php">Browse jobs</a></li>
						<li><a href="#">About</a>
							<ul>
								<li><a href="hot-it-works.php">How it works</a></li>
								<li><a href="privacy-policy.php">Privacy policy</a></li>
								<li><a href="faq.php">FAQ</a></li>
								<li><a href="contact.php">Contact us</a></li>
						</li>
					</ul>
				</nav>
				<div class="clearfix"></div>
				<!-- Main Navigation / End -->
				
			</div>
			<!-- Left Side Content / End -->

			<!-- Right Side Content -->
			<div class="right-side">
				<div class="header-widget">
					<?php if (isset($_SESSION['Id'])){ ?>
					<div class="user-menu">
						<div class="user-name"><span><img src="images/dashboard-avatar.jpg" alt=""></span> My Account</div>
						<ul>
							<li><a href="dashboard.php"><i class="sl sl-icon-screen-desktop"></i> Dashboard</a></li>
							<li><a href="browse-jobs.php"><i class="sl sl-icon-magnifier"></i> Browse all jobs</a></li>
							<li><a href="dashboard-messages.php"><i class="sl sl-icon-envelope-open"></i> Messages</a></li>
							<li><a href="logout.php"><i class="sl sl-icon-power"></i> Logout</a></li>
						</ul>
					</div>
					<a href="dashboard-postjob.php" class="button border with-icon"> Post a job <i class="sl sl-icon-plus"></i></a>
					<?php } else { ?>
					<a href="register.php" class="sign-in"></i> Create account</a>
					<a href="#sign-in-dialog" class="sign-in popup-with-zoom-anim"><i class="sl sl-icon-login"></i> Sign In</a>
					<a href="#sign-in-dialog" class="sign-in popup-with-zoom-anim button border with-icon"> Post a job <i class="sl sl-icon-plus"></i></a>
					<?php } ?>
					
				</div>
			</div>
			<!-- Right Side Content / End -->

			<!-- Sign In Popup -->
			<div id="sign-in-dialog" class="zoom-anim-dialog mfp-hide">

				<div class="small-dialog-header">
					<h3> Sign In</h3>
				</div>

				<!--Tabs -->
				<div class="sign-in-form style-1">

					<ul class="tabs-nav">
						<li class=""><a href="#tab1"> Sign in</a></li>
						<li><a href="#tab2"> Register</a></li>
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
										<a href="lost-your-password.php" >Lost Your Password?</a>
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
								<label for="username2">Your Username:
									<i class="im im-icon-Male"></i>
									<input type="text" class="input-text" name="username" id="username" value="" />
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

</header>
<div class="clearfix"></div>
<!-- Header Container / End -->