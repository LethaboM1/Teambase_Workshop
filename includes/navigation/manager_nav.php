<?php
$get_new_requisitions = dbq("select request_id from jobcard_requisitions where status='requested'");
$get_open_requisitions = dbq("select request_id from jobcard_requisitions where (status!='completed' && status!='rejected' && status!='canceled' && status!='requested')");
$get_tyre_reports = dbq("select id from jobcard_tyre_reports where checked_by=0");

$get_new = dbq("select job_id from jobcards where status='logged'");

// $get_new_defect = dbq("select job_id from jobcards where status='defect-logged'");
$get_new_defect = dbq("select id from ws_defect_reports where status='F'");

$get_add_defect = dbq("select distinct job_id from jobcard_reports where reviewed=0");

$get_new_jobnumber = dbq("select job_id from jobcards where status='allocated'");
$get_open = dbq("select job_id from jobcards where status='open'");
$get_completed = dbq("select job_id from jobcards where status='completed'");

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
						<i class="bx bx-user-pin" aria-hidden="true"></i>
						<span>User Managment</span>
					</a>
					<ul class="nav nav-children">
						<li><a class="nav-link" href="dashboard.php?page=add-user">Add/Manage Users</a></li>
						<li><a class="nav-link" href="dashboard.php?page=add-plant">Add/Manage Plants</a></li>
						<li><a class="nav-link" href="dashboard.php?page=add-site">Add/Manage Sites</a></li>
					</ul>
				</li>
				<li class="nav-parent">
					<a class="nav-link" href="#">
						<i class="bx bx-list-check" aria-hidden="true"></i>
						<span>Check Lists&nbsp;<span class='badge badge-danger'></span></span>
					</a>
					<ul class="nav nav-children">
						<li><a class="nav-link" href="dashboard.php?page=plant-checklists">List&nbsp;<span class='badge badge-danger float-end'></span></a></li>
					</ul>
				</li>
				<li class="nav-parent">
					<a class="nav-link" href="#">
						<i class="bx bx-disc" aria-hidden="true"></i>
						<span>Tyre Reports&nbsp;<span class='badge badge-danger'><?= dbr($get_tyre_reports) ?></span></span>
					</a>
					<ul class="nav nav-children">
						<li><a class="nav-link" href="dashboard.php?page=tyre-reports-new">New&nbsp;<span class='badge badge-danger float-end'><?= dbr($get_tyre_reports) ?></span></a></li>
					</ul>
					<ul class="nav nav-children">
						<li><a class="nav-link" href="dashboard.php?page=tyre-reports-list">List</a></li>
					</ul>
				</li>
				<li class="nav-parent">
					<a class="nav-link" href="#">
						<i class="bx bx-spreadsheet" aria-hidden="true"></i>
						<span>Job Requisitions&nbsp;<span class='badge badge-danger'><?= dbr($get_new_requisitions) ?></span></span>
					</a>
					<ul class="nav nav-children">
						<li><a class="nav-link" href="dashboard.php?page=job-requisitions-new">New&nbsp;<span class='badge badge-danger float-end'><?= dbr($get_new_requisitions) ?></span></a></li>
						<li><a class="nav-link" href="dashboard.php?page=job-requisitions-open">Open&nbsp;<span class='badge badge-danger float-end'><?= dbr($get_open_requisitions) ?></span></a></li>
						<li><a class="nav-link" href="dashboard.php?page=job-requisitions-completed">Completed</a></li>
					</ul>
				</li>
				<li class="nav-parent">
					<a class="nav-link" href="#">
						<i class="bx bxs-car-crash" aria-hidden="true"></i>
						<span>Defect Reports&nbsp;<span class='badge badge-danger'>New&nbsp;<?= dbr($get_new_defect) ?></span></span>
					</a>
					<ul class="nav nav-children">
						<li><a class="nav-link" href="dashboard.php?page=new-defects">New Defect Reports&nbsp;<span class='badge badge-danger float-end'><?= dbr($get_new_defect) ?></span></a></li>
						<li><a class="nav-link" href="dashboard.php?page=list-defects">Reviewed Defect Reports</a></li>
					</ul>
				</li>
				<li class="nav-parent">
					<a class="nav-link" href="#">
						<i class="bx bxs-car-mechanic" aria-hidden="true"></i>
						<span>Job Cards&nbsp;<span class='badge badge-danger'><?= dbr($get_new) + dbr($get_new_jobnumber)  +  dbr($get_add_defect) ?></span></span>
					</a>
					<ul class="nav nav-children">
						<li><a class="nav-link" href="dashboard.php?page=add-job">Create</a></li>
						<li><a class="nav-link" href="dashboard.php?page=new-job">New Job cards&nbsp;<span class='badge badge-danger float-end'><?= dbr($get_new) ?></span></a></li>
						<li><a class="nav-link" href="dashboard.php?page=new-job-allocate">New - Require Job Number&nbsp;<span class='badge badge-danger float-end'><?= dbr($get_new_jobnumber) ?></span></a></li>
						<li><a class="nav-link" href="dashboard.php?page=additional-defects">Additional Defects&nbsp;<span class='badge badge-danger float-end'><?= dbr($get_add_defect) ?></span></a></li>
						<li><a class="nav-link" href="dashboard.php?page=additional-defects-archive">Additional Defects - Archive</a></li>
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
						<li><a class="nav-link" target="_blank" href="print.php?type=open-requisitions">Open Requisitions</a></li>
						<li><a class="nav-link" href="dashboard.php?page=rep-jobcard-events">Job Card Events</a></li>
						<li><a class="nav-link" href="dashboard.php?page=rep-operator-log">Plant Operator Logs</a></li>
						<li><a class="nav-link" href="print.php?type=next-service">Next Service Report</a></li>
						<li><a class="nav-link" href="dashboard.php?page=rep-plant-inspection">Plant Inspection</a></li>
						<!-- target="_blank" href="print.php?type=plant-inspection" -->
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