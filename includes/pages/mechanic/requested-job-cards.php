<div class="row">
	<div class="col-xl-12">
		<?php
		$get_jobcards = dbq("select * from jobcards where (status='logged' || status='allocated') and mechanic_id={$_SESSION['user']['user_id']}");

		if ($get_jobcards) {
			if (dbr($get_jobcards) > 0) {
				while ($row = dbf($get_jobcards)) {
					require "./includes/pages/mechanic/list_requested_jobcards.php";
				}
			} else {
				echo "<h4>No requested job cards.</h4>";
			}
		}
