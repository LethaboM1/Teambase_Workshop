<div class="row">
	<div class="col-sm-6 col-md-4 pb-sm-3 pb-md-0">
		<label class="col-form-label" for="formGroupExampleInput">From</label>
		<input type="date" name="fromdate" placeholder="" class="form-control">
	</div>
	<div class="col-sm-6 col-md-4 pb-sm-3 pb-md-0">
		<label class="col-form-label" for="formGroupExampleInput">To</label>
		<input type="date" name="todate" placeholder="" class="form-control">
	</div>
	<div class="col-sm-6 col-md-4 pb-sm-3 pb-md-0">
		<button class="btn btn-primary">Print Report</button>
	</div>
</div>

<div class="row">
	<?php
	$get_jobcards = dbq("select * from jobcards where status='closed'");
	if ($get_jobcards) {
		if (dbr($get_jobcards) > 0) {
			while ($row = dbf($get_jobcards)) {
				require "./includes/pages/manager/jobcards/list_archive_jobcards.php";
			}
		} else {
			echo "<h4>No archive job cards.</h4>";
		}
	}
	?>
</div>