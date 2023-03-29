<div class="row">
	<div class="col-xl-12">
		<?php

		$get_jobcards = dbq("select * from jobcards where status='defect-logged'");

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

				$clerk_select_[] = ['name' => 'Choose Clerk', 'value' => '0'];
				$get_clerks = dbq("select concat(name,' ',last_name) as name, user_id as value from users_tbl where role='clerk' and active=1");
				if ($get_clerks) {
					if (dbr($get_clerks) > 0) {
						while ($clerk = dbf($get_clerks)) {
							$clerk_select_[] = $clerk;
						}
					}
				}

				while ($jobcard = dbf($get_jobcards)) {
					/* Get Stuff */
					$plant_ = dbf(dbq("select * from plants_tbl where plant_id={$jobcard['plant_id']}"));
					$logged_by_ = dbf(dbq("select concat(name,' ',last_name) as name from users_tbl where user_id={$jobcard['logged_by']}"));

					switch ($jobcard['priority']) {
						case "1":
							$status_color = "danger";
							break;

						default:
							$status_color = "warning";
							break;
					}
					require "./includes/pages/manager/jobcards/list_new_defects.php";
				}
			} else {
				echo "<h4>No new defect reports.</h4>";
			}
		}
