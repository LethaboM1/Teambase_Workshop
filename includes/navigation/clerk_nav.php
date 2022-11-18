<?php
$get_requisitions = dbq("select request_id from jobcard_requisitions where (status!='completed' && status!='rejected'  && status!='canceled') and clerk_id={$_SESSION['user']['user_id']}");
$get_new = dbq("select job_id from jobcards where status='logged' and clerk_id={$_SESSION['user']['user_id']}");
$get_new_jobnumber = dbq("select job_id from jobcards where status='allocated'");
$get_open = dbq("select job_id from jobcards where status='open' and clerk_id={$_SESSION['user']['user_id']}");
$get_completed = dbq("select job_id from jobcards where status='completed' and clerk_id={$_SESSION['user']['user_id']}");

$total_jobs = dbr($get_requisitions) + dbr($get_new) + dbr($get_open) + dbr($get_completed);

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
						<span>Job Requisitions&nbsp;<span class='badge badge-danger'><?= dbr($get_new_requisitions) ?></span></span>
					</a>
					<ul class="nav nav-children">
						<li><a class="nav-link" href="dashboard.php?page=job-requisitions-new">New&nbsp;<span class='badge badge-danger float-end'><?= dbr($get_new_requisitions) ?></span></a></li>
						<li><a class="nav-link" href="dashboard.php?page=job-requisitions-open">Open&nbsp;<span class='badge badge-danger float-end'><?= dbr($get_open_requisitions) ?></span></a></li>
					</ul>
				</li>
				<li class="nav-parent">
					<a class="nav-link" href="#">
						<i class="bx bx-spreadsheet" aria-hidden="true"></i>
						<span>Job Cards&nbsp;<span class='badge badge-danger'><?= dbr($get_new) + dbr($get_new_jobnumber) ?></span></span>
					</a>
					<ul class="nav nav-children">
						<li><a class="nav-link" href="dashboard.php?page=add-job">Create</a></li>
						<li><a class="nav-link" href="dashboard.php?page=new-job">New&nbsp;<span class='badge badge-danger float-end'><?= dbr($get_new) ?></span></a></li>
						<li><a class="nav-link" href="dashboard.php?page=new-job-allocate">New - Require Job Number&nbsp;<span class='badge badge-danger float-end'><?= dbr($get_new_jobnumber) ?></span></a></li>
						<li><a class="nav-link" href="dashboard.php?page=open-job">Open&nbsp;<span class='badge badge-danger float-end'><?= dbr($get_open) ?></span></a></li>
						<li><a class="nav-link" href="dashboard.php?page=completed-job">Completed&nbsp;<span class='badge badge-danger float-end'><?= dbr($get_completed) ?></span></a></li>
						<li><a class="nav-link" href="dashboard.php?page=arch-job">Archived</a></li>
					</ul>
				</li>
				<li class="nav-parent">
					<a class="nav-link" href="#">
						<i class="bx bxs-report" aria-hidden="true"></i>
						<span>Reports</span>
					</a>
					<ul class="nav nav-children">
						<li><a class="nav-link" href="">Fuel Report</a></li>
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