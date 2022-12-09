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
		<button class="btn btn-primary">Filter</button>
	</div>
</div>

<div class="row">
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Date</th>
				<th>Job No.</th>
				<th>PLant No.</th>
				<th>Mechanic</th>
				<th>Hrs(Aloc)</th>
				<th>Hrs(Worked)</th>
				<th>Job Type</th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
			if ($_SESSION['user']['role'] == 'clerk') {
				$get_jobcards = dbq("select * from jobcards where status='closed' and clerk_id={$_SESSION['user']['user_id']} order by complete_datetime DESC");
			} else {
				$get_jobcards = dbq("select * from jobcards where status='closed' order by complete_datetime DESC");
			}

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
		</tbody>
	</table>

</div>