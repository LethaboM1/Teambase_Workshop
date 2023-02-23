<?php
$get_requisitions = dbq("select request_id from jobcard_requisitions where (status!='completed' && status!='rejected'  && status!='canceled') and buyer_id={$_SESSION['user']['user_id']}");

$total_jobs = dbr($get_requisitions);

?>
<div class="nano">
	<div class="nano-content">
		<nav id="menu" class="nav-main" role="navigation">
			<ul class="nav nav-main">
				<li>
					<a class="nav-link" href="dashboard.php">
						<i class="bx bx-home-alt" aria-hidden="true"></i>
						<span>Dashboard</span>
					</a>
				</li>
				<li class="nav-parent">
					<a class="nav-link" href="#">
						<i class="bx bx-spreadsheet" aria-hidden="true"></i>
						<span>Job Requisitions&nbsp;<span class='badge badge-danger'><?= $total_jobs ?></span></span>
					</a>
					<ul class="nav nav-children">
						<li><a class="nav-link" href="dashboard.php?page=job-requisitions">Open &nbsp;<span class='badge badge-danger'><?= $total_jobs ?></span></a></li>
						<li><a class="nav-link" href="dashboard.php?page=job-requisitions-completed">Completed </a></li>
					</ul>
				</li>
				<li class="nav-parent">
					<a class="nav-link" href="#">
						<i class="bx bxs-report" aria-hidden="true"></i>
						<span>Reports</span>
					</a>
					<ul class="nav nav-children">
						<li><a class="nav-link" href="">Report</a></li>
					</ul>
				</li>
			</ul>
		</nav>
		<hr class="separator" />
	</div>
	<script>
		// Maintain Scroll Position
		if (typeof localStorage !== 'undefined') {
			if (localStorage.getItem('sidebar-left-position') !== null) {
				var initialPosition = localStorage.getItem('sidebar-left-position'),
					sidebarLeft = document.querySelector('#sidebar-left .nano-content');

				sidebarLeft.scrollTop = initialPosition;
			}
		}
	</script>
</div>