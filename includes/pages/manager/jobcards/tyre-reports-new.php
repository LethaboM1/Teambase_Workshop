<?php

?>
<div class="row">
	<div class="header-right col-lg-4 col-md-4">

	</div>
	<div id="job_tyre_reports_list" class="col-xl-12">
		<?php
		$get_tyre_reports = dbq("select * from jobcard_tyre_reports where checked_by=0 order by date_time");


		if ($get_tyre_reports) {
			if (dbr($get_tyre_reports) > 0) {
				while ($row = dbf($get_tyre_reports)) {
					require "./includes/pages/manager/jobcards/list_job_tyre_reports.php";
				}
			} else {
				echo "<h4>No new tyre reports.</h4>";
			}
		}
		?>
	</div>
</div>