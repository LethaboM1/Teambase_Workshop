<div class="row">
	<div class="col-xl-12">
		<?php

		if ($_SESSION['user']['role'] == 'clerk') {
			$get_jobcards = dbq("select * from jobcards where status='allocated' and clerk_id={$_SESSION['user']['user_id']}");
		} else {
			$get_jobcards = dbq("select * from jobcards where status='allocated'");
		}

		if ($get_jobcards) {
			if (dbr($get_jobcards) > 0) {

				$mechanic_select_[] = ['name' => 'Choose Mechanic', 'value' => '0'];
				$get_mechanics = dbq("select concat(name,' ',last_name) as name, user_id as value from users_tbl where role='mechanic' and active=1");
				if ($get_mechanics) {
					if (dbr($get_mechanics) > 0) {
						while ($mechanic = dbf($get_mechanics)) {
							$mechanic_select_[] = $mechanic;
						}
					}
				}

				while ($jobcard = dbf($get_jobcards)) {
					/* Get Stuff */
					$plant_ = dbf(dbq("select * from plants_tbl where plant_id={$jobcard['plant_id']}"));
					$logged_by_ = dbf(dbq("select concat(name,' ',last_name) as name from users_tbl where user_id={$jobcard['logged_by']}"));
					$mechanic_ = get_user($jobcard['job_id']);
					$defect_report = get_record('ws_defect_reports', 'job_id', $jobcard['job_id'], "status='J'");
					switch ($jobcard['priority']) {
						case "1":
							$status_color = "danger";
							break;

						default:
							$status_color = "warning";
							break;
					}
					require "./includes/pages/manager/jobcards/list_new_allocated_jobcards.php";
				}
			} else {
				echo "<h4>No new job cards.</h4>";
			}
		}
