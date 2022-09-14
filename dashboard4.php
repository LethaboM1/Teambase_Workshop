<?php
switch ($_GET['page']) {

	case 'add-job':
		$page_title = 'Add New Job Card';
		$page_name = 'add-job-card';
		break;

	case 'new-job':
		$page_title = 'New Job Cards';
		$page_name = 'new-job-cards';
		break;

	case 'open-job':
		$page_title = 'Open Job Cards';
		$page_name = 'open-job-cards';
		break;

	case 'arch-job':
		$page_title = 'Job Cards Archives';
		$page_name = 'archive-job-cards';
		break;

	default:
		$page_title = 'Dashboard Overview';
		$page_name = 'dashboards/clerk_dash';
}
?>

<html class="fixed dark">

<head>

	<!-- Basic -->
	<meta charset="UTF-8">

	<title>TeamBase | Hillary Construction | Dashboard</title>
	<link rel="shortcut icon" type="image/png" href="img/logos/teambase_fav.png" />

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<!-- Web Fonts  -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

	<!-- Vendor CSS -->
	<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" href="vendor/animate/animate.compat.css">
	<link rel="stylesheet" href="vendor/font-awesome-6/css/all.min.css" />
	<link rel="stylesheet" href="vendor/boxicons/css/boxicons.min.css" />
	<link rel="stylesheet" href="vendor/magnific-popup/magnific-popup.css" />
	<link rel="stylesheet" href="vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css" />
	<link rel="stylesheet" href="vendor/jquery-ui/jquery-ui.css" />
	<link rel="stylesheet" href="vendor/jquery-ui/jquery-ui.theme.css" />
	<link rel="stylesheet" href="vendor/bootstrap-multiselect/css/bootstrap-multiselect.css" />
	<link rel="stylesheet" href="vendor/bootstrap-tagsinput/bootstrap-tagsinput.css" />
	<link rel="stylesheet" href="vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.css" />
	<link rel="stylesheet" href="vendor/bootstrap-timepicker/css/bootstrap-timepicker.css" />
	<link rel="stylesheet" href="vendor/bootstrap-fileupload/bootstrap-fileupload.min.css" />
	<link rel="stylesheet" href="vendor/dropzone/basic.css" />
	<link rel="stylesheet" href="vendor/dropzone/dropzone.css" />
	<link rel="stylesheet" href="vendor/bootstrap-markdown/css/bootstrap-markdown.min.css" />
	<link rel="stylesheet" href="vendor/summernote/summernote-bs4.css" />
	<link rel="stylesheet" href="vendor/codemirror/lib/codemirror.css" />
	<link rel="stylesheet" href="vendor/codemirror/theme/monokai.css" />

	<!-- Specific Page Vendor CSS -->
	<link rel="stylesheet" href="vendor/select2/css/select2.css" />
	<link rel="stylesheet" href="vendor/select2-bootstrap-theme/select2-bootstrap.min.css" />
	<link rel="stylesheet" href="vendor/pnotify/pnotify.custom.css" />

	<!-- Theme CSS -->
	<link rel="stylesheet" href="css/theme.css" />

	<!-- Skin CSS -->
	<link rel="stylesheet" href="css/skins/default.css" />

	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="css/custom.css">

	<!-- Head Libs -->
	<script src="vendor/modernizr/modernizr.js"></script>

</head>

<body>
	<section class="body">

		<!-- start: header -->
		<header class="header">
			<div class="logo-container">
				<a href="#" class="logo">
					<img src="img/logos/teambase_logo_long.png" width="202" height="45" alt="TeamBase Logo" />
				</a>
				<div class="d-md-none toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
					<i class="fas fa-bars" aria-label="Toggle sidebar"></i>
				</div>
			</div>

			<!-- start: user box -->
			<div class="header-right">

				<span class="separator"></span>

				<ul class="notifications">
					<li>
						<a href="#" class="dropdown-toggle notification-icon" data-bs-toggle="dropdown">
							<i class="bx bx-list-ol"></i>
							<span class="badge">3</span>
						</a>

						<div class="dropdown-menu notification-menu large">
							<div class="notification-title">
								<span class="float-end badge badge-default">3</span>
								Tasks
							</div>

							<div class="content">
								<ul>
									<li>
										<p class="clearfix mb-1">
											<span class="message float-start">Generating Sales Report</span>
											<span class="message float-end text-dark">60%</span>
										</p>
										<div class="progress progress-xs light">
											<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
										</div>
									</li>

									<li>
										<p class="clearfix mb-1">
											<span class="message float-start">Importing Contacts</span>
											<span class="message float-end text-dark">98%</span>
										</p>
										<div class="progress progress-xs light">
											<div class="progress-bar" role="progressbar" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100" style="width: 98%;"></div>
										</div>
									</li>

									<li>
										<p class="clearfix mb-1">
											<span class="message float-start">Uploading something big</span>
											<span class="message float-end text-dark">33%</span>
										</p>
										<div class="progress progress-xs light mb-1">
											<div class="progress-bar" role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width: 33%;"></div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</li>
					<li>
						<a href="#" class="dropdown-toggle notification-icon" data-bs-toggle="dropdown">
							<i class="bx bx-bell"></i>
							<span class="badge">3</span>
						</a>

						<div class="dropdown-menu notification-menu">
							<div class="notification-title">
								<span class="float-end badge badge-default">3</span>
								Alerts
							</div>

							<div class="content">
								<ul>
									<li>
										<a href="#" class="clearfix">
											<div class="image">
												<i class="fas fa-thumbs-down bg-danger text-light"></i>
											</div>
											<span class="title">Server is Down!</span>
											<span class="message">Just now</span>
										</a>
									</li>
									<li>
										<a href="#" class="clearfix">
											<div class="image">
												<i class="bx bx-lock bg-warning text-light"></i>
											</div>
											<span class="title">User Locked</span>
											<span class="message">15 minutes ago</span>
										</a>
									</li>
									<li>
										<a href="#" class="clearfix">
											<div class="image">
												<i class="fas fa-signal bg-success text-light"></i>
											</div>
											<span class="title">Connection Restaured</span>
											<span class="message">10/10/2021</span>
										</a>
									</li>
								</ul>

								<hr />

								<div class="text-end">
									<a href="#" class="view-more">View All</a>
								</div>
							</div>
						</div>
					</li>
				</ul>

				<span class="separator"></span>

				<div id="userbox" class="userbox">
					<a href="#" data-bs-toggle="dropdown">
						<figure class="profile-picture">
							<img src="img/staff/Jack.jpg" alt="Joseph Doe" class="rounded-circle" data-lock-picture="img/staff/Jack.jpg" />
						</figure>
						<div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@okler.com">
							<span class="name">John Doe Junior</span>
							<span class="role">Administrator</span>
						</div>

						<i class="fa custom-caret"></i>
					</a>

					<div class="dropdown-menu">
						<ul class="list-unstyled mb-2">
							<li class="divider"></li>
							<li>
								<a role="menuitem" tabindex="-1" href="pages-user-profile.html"><i class="bx bx-user-circle"></i> My Profile</a>
							</li>
							<li>
								<a role="menuitem" tabindex="-1" href="#" data-lock-screen="true"><i class="bx bx-lock"></i> Lock Screen</a>
							</li>
							<li>
								<a role="menuitem" tabindex="-1" href="pages-signin.html"><i class="bx bx-power-off"></i> Logout</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!-- end: search & user box -->
		</header>
		<!-- end: header -->

		<div class="inner-wrapper">
			<!-- start: sidebar -->
			<aside id="sidebar-left" class="sidebar-left">

				<div class="sidebar-header">
					<div class="sidebar-title">
						Navigation
					</div>
					<div class="sidebar-toggle d-none d-md-block" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
						<i class="fas fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>
				<!-- Navigation Start -->
				<? include('navigation/clerk_nav.php'); ?>

				<!-- Navigation end -->
			</aside>
			<!-- end: sidebar -->

			<section role="main" class="content-body">
				<header class="page-header">
					<h2><?= $page_title ?></h2>
				</header>

				<!-- start: page -->
				<?php
				include("{$page_name}.php");
				?>
				<!-- end: page -->
			</section>
		</div>
	</section>

	<!-- Vendor -->
	<script src="vendor/jquery/jquery.js"></script>
	<script src="vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
	<script src="vendor/popper/umd/popper.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="vendor/common/common.js"></script>
	<script src="vendor/nanoscroller/nanoscroller.js"></script>
	<script src="vendor/magnific-popup/jquery.magnific-popup.js"></script>
	<script src="vendor/jquery-placeholder/jquery.placeholder.js"></script>
	<script src="vendor/jquery.easy-pie-chart/jquery.easypiechart.js"></script>
	<script src="vendor/jquery-ui/jquery-ui.js"></script>
	<script src="vendor/jqueryui-touch-punch/jquery.ui.touch-punch.js"></script>
	<script src="vendor/jquery-appear/jquery.appear.js"></script>
	<script src="vendor/jquery-maskedinput/jquery.maskedinput.js"></script>
	<script src="vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
	<script src="vendor/bootstrapv5-multiselect/js/bootstrap-multiselect.js"></script>
	<script src="vendor/flot/jquery.flot.js"></script>
	<script src="vendor/flot.tooltip/jquery.flot.tooltip.js"></script>
	<script src="vendor/flot/jquery.flot.pie.js"></script>
	<script src="vendor/flot/jquery.flot.categories.js"></script>
	<script src="vendor/flot/jquery.flot.resize.js"></script>
	<script src="vendor/jquery-sparkline/jquery.sparkline.js"></script>
	<script src="vendor/raphael/raphael.js"></script>
	<script src="vendor/morris/morris.js"></script>
	<script src="vendor/gauge/gauge.js"></script>
	<script src="vendor/snap.svg/snap.svg.js"></script>
	<script src="vendor/liquid-meter/liquid.meter.js"></script>
	<script src="vendor/chartist/chartist.js"></script>

	<!-- Specific Page Vendor -->
	<script src="vendor/select2/js/select2.js"></script>
	<script src="vendor/pnotify/pnotify.custom.js"></script>

	<!-- Theme Base, Components and Settings -->
	<script src="js/theme.js"></script>

	<!-- Theme Custom -->
	<script src="js/custom.js"></script>

	<!-- Theme Initialization Files -->
	<script src="js/theme.init.js"></script>

	<!-- Examples -->
	<script src="js/examples/examples.dashboard.js"></script>
	<script src="js/examples/examples.modals.js"></script>
	<script src="js/examples/examples.charts.js"></script>

	<!-- Examples -->
	<style>
		#ChartistCSSAnimation .ct-series.ct-series-a .ct-line {
			fill: none;
			stroke-width: 4px;
			stroke-dasharray: 5px;
			-webkit-animation: dashoffset 1s linear infinite;
			-moz-animation: dashoffset 1s linear infinite;
			animation: dashoffset 1s linear infinite;
		}

		#ChartistCSSAnimation .ct-series.ct-series-b .ct-point {
			-webkit-animation: bouncing-stroke 0.5s ease infinite;
			-moz-animation: bouncing-stroke 0.5s ease infinite;
			animation: bouncing-stroke 0.5s ease infinite;
		}

		#ChartistCSSAnimation .ct-series.ct-series-b .ct-line {
			fill: none;
			stroke-width: 3px;
		}

		#ChartistCSSAnimation .ct-series.ct-series-c .ct-point {
			-webkit-animation: exploding-stroke 1s ease-out infinite;
			-moz-animation: exploding-stroke 1s ease-out infinite;
			animation: exploding-stroke 1s ease-out infinite;
		}

		#ChartistCSSAnimation .ct-series.ct-series-c .ct-line {
			fill: none;
			stroke-width: 2px;
			stroke-dasharray: 40px 3px;
		}

		@-webkit-keyframes dashoffset {
			0% {
				stroke-dashoffset: 0px;
			}

			100% {
				stroke-dashoffset: -20px;
			}

			;
		}

		@-moz-keyframes dashoffset {
			0% {
				stroke-dashoffset: 0px;
			}

			100% {
				stroke-dashoffset: -20px;
			}

			;
		}

		@keyframes dashoffset {
			0% {
				stroke-dashoffset: 0px;
			}

			100% {
				stroke-dashoffset: -20px;
			}

			;
		}

		@-webkit-keyframes bouncing-stroke {
			0% {
				stroke-width: 5px;
			}

			50% {
				stroke-width: 10px;
			}

			100% {
				stroke-width: 5px;
			}

			;
		}

		@-moz-keyframes bouncing-stroke {
			0% {
				stroke-width: 5px;
			}

			50% {
				stroke-width: 10px;
			}

			100% {
				stroke-width: 5px;
			}

			;
		}

		@keyframes bouncing-stroke {
			0% {
				stroke-width: 5px;
			}

			50% {
				stroke-width: 10px;
			}

			100% {
				stroke-width: 5px;
			}

			;
		}

		@-webkit-keyframes exploding-stroke {
			0% {
				stroke-width: 2px;
				opacity: 1;
			}

			100% {
				stroke-width: 20px;
				opacity: 0;
			}

			;
		}

		@-moz-keyframes exploding-stroke {
			0% {
				stroke-width: 2px;
				opacity: 1;
			}

			100% {
				stroke-width: 20px;
				opacity: 0;
			}

			;
		}

		@keyframes exploding-stroke {
			0% {
				stroke-width: 2px;
				opacity: 1;
			}

			100% {
				stroke-width: 20px;
				opacity: 0;
			}

			;
		}
	</style>
</body>

</html>