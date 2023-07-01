<div class="row">
	<div class="col-lg-12 mb-3">
		<form method="post" id="addplant">
			<section class="card">
				<header class="card-header">
					<div class="row">
						<div class="col-md-9">
							<h2 class="card-title">Vew Jobcard</h2>
							<p class="card-subtitle">View Job Card</p>
						</div>
						<div class="col-md-3">
							<?php if (is_array($defect_report) > 0) { ?>
								<a class="mb-1 mt-1 mr-1" target="_blank" href="print.php?type=defect-report&id=<?= $defect_report['id'] ?>"><button type="button" class='btn btn-info float-right'>Defect Report</button></a>
							<?php } ?>
							<a class="mb-1 mt-1 mr-1 modal-basic" href="#modalCloseJob"><button type="button" class='btn btn-danger float-right'>Completed</button></a>
						</div>
					</div>
				</header>
				<div class="card-body">
					<div class="row">
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Job Number</label>
							<input type="text" name="jobnumber" class="form-control" value="<?= $jobcard_['jobcard_number'] ?>" disabled>
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Date/Time</label>
							<input type="datetime-local" name="date" placeholder="" class="form-control" value="<?= $jobcard_['job_date'] ?>" disabled>
						</div>
						<?php
						if ($jobcard_['jobcard_type'] != 'sundry') {
							if ($jobcard_['jobcard_type'] == 'contract') {
						?>
								<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
									<label class="col-form-label" for="formGroupExampleInput">Site</label>
									<input type="text" name="plantNumber" class="form-control" value="<?= $site_['name'] ?>" disabled>
								</div>
							<?php
							} else {
							?>
								<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
									<label class="col-form-label" for="formGroupExampleInput">Plant Number</label>
									<input type="text" name="plantNumber" class="form-control" value="<?= $plant_['plant_number'] ?>" disabled>
								</div>
								<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
									<label class="col-form-label" for="formGroupExampleInput">(<?= strtoupper($plant_['reading_type']) ?>) Reading</label>
									<input type="text" class="form-control" value="<?= $plant_[$plant_['reading_type'] . '_reading'] ?>" disabled>
								</div>
								<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
									<label class="col-form-label" for="formGroupExampleInput">Site</label>
									<input type="text" name="site" class="form-control" value="<?= $jobcard_['site'] ?>" disabled>
								</div>
							<?php
							}
							?>
							<?php
							if ($_SESSION['user']['role'] == 'clerk' || $_SESSION['user']['role'] == 'manager'  || $_SESSION['user']['role'] == 'system') {
							?>

								<?= inp('mechanic', 'Mechanic', 'select', $jobcard_['mechanic_id'], '', 0, $mechanic_list, 'disabled') ?>

						<?php
							}
						}
						?>
					</div>
					<hr>

					<?php
					if ($jobcard_['jobcard_type'] != 'sundry') {
					?>
						<h2 class="card-title">Extras</h2><br>
						<div class="row">
							<?php
							if (strlen($jobcard_['safety_audit']) > 0) {
								if (is_json($jobcard_['safety_audit'])) {
									$safety_audit = json_decode($jobcard_['safety_audit'], true);
								} else {
									$safety_audit = json_decode(base64_decode($jobcard_['safety_audit']), true);
								}
							} else {
								$safety_audit = [];
							}

							if (count($safety_audit) > 0) {
								foreach ($safety_audit as $line) {
							?>
									<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
										<div class="checkbox-custom checkbox-default">
											<input type="checkbox" <?php if ($line['answer'] == 'Yes') {
																		echo "checked='checked'";
																	} ?> disabled>
											<label for="checkboxExample1"><?= $line['name'] ?></label>
										</div>
									</div>
								<?php
								}
							} else {
								?>
								<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
									Nothing to list
								</div>
							<?php
							}


							?>
						</div>
					<?php
					}
					?>
				</div>
				<footer class="card-footer text-end">

				</footer>
			</section>
		</form>
	</div>

	<?php
	if ($jobcard_['status'] == 'logged' || is_null($jobcard_['clerk_id']) || $jobcard_['clerk_id'] == 0) {
	?><div class="col-lg-6 mb-3">
			<section class="card">
				<header class="card-header">
					<div class="row">
						<div class="col-md-9">
							<h2 class="card-title">Allocate Clerk</h2>
							<p class="card-subtitle">Allocate Clerk</p>
						</div>
					</div>
				</header>
				<div class="card-body">
					<div class="row">
						<form method="post">
							<?php
							$get_clerks = dbq("select name, user_id as value from users_tbl where role='clerk'");
							if ($get_clerks) {
								$clerk_select_[] = ['name' => 'Select One', 'value' => 0];
								if (dbr($get_clerks)) {
									while ($clerk = dbf($get_clerks)) {
										$clerk_select_[] = $clerk;
									}
								}

								echo "<div class='col-sm-12 col-md-4 pb-sm-3 pb-md-0'>"
									. inp('clerk_id', 'Clerk', 'select', $jobcard_['clerk_id'], '', 0, $clerk_select_)
									. inp('allocate_clerk', '&nbsp', 'inline-submit', 'Allocate', 'btn-primary')
									. "</div>";
							}
							?>
							<div class='col-sm-12 col-md-6 pb-sm-3 pb-md-0'>
							</div>
						</form>
					</div>
				</div>
				<footer class="card-footer text-end">

				</footer>
			</section>
		</div>
	<?php } ?>




	<h3>Allocated Hours: <span id="jobcard_allocated_hours"><?= $jobcard_['allocated_hours'] ?></span></h3>

	<?php if ($jobcard_['type'] != 'service') { ?>
		<!-- Modal Close Jobcard -->
		<div id="modalCloseJob" class="modal-block modal-block-lg mfp-hide">
			<form method="post">
				<section class="card">
					<header class="card-header">
						<h2 class="card-title">Complete Job Card</h2>
					</header>
					<div class="card-body">
						<div class="modal-wrapper">
							<div class="modal-text">
								<div class="row">
									<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
										<label class="col-form-label" for="formGroupExampleInput">Date Completed</label>
										<?= inp('compdate', '', 'hidden', date("Y-m-d\TH:i:s")) ?>
										<input type="datetime-local" name="compdate_" placeholder="Last Service Date" class="form-control" value="<?= date("Y-m-d\TH:i") ?>">
									</div>

									<?php
									if ($jobcard_['jobcard_type'] != 'sundry') {
									?>
										<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
											<label class="col-form-label" for="formGroupExampleInput">(<?= strtoupper($plant_['reading_type']) ?>) Reading</label>
											<input type="text" name="reading" placeholder="Reading" class="form-control">
										</div>
									<?php
									}
									?>
								</div>
							</div>
						</div>
					</div>
					<footer class="card-footer">
						<div class="row">
							<div class="col-md-12 text-right">
								<button type="submit" name="complete_jobcard" class="btn btn-primary">Completed</button>&nbsp;<button class="btn btn-default modal-dismiss">Cancel</button>
							</div>
						</div>
					</footer>
				</section>
			</form>
		</div>
		<!-- Modal view End -->
	<?php } ?>

	<div class="col-lg-12 mb-3">
		<?php
		require_once "inc.reps.php";
		require_once "inc.evt.php";

		require_once "inc.sr.php";

		require_once "inc.ra.php";
		require_once "inc.tr.php";

		?>
	</div>
</div>
<?php
echo $modal;
$jscript_function .= "
function update_sys(id, value) {
    $.ajax({
        method:'post',
        url:'includes/ajax.php',
        data: {
            cmd:'update_sys',
            id: id,
            value: value ,

        },
        success: function (result) {
            
        } 

    });
}
";

$jscript_function .= "
					function print_request (request_id) {
						$.ajax({
							method:'get',
							url:'includes/ajax.php',
							data: {
								cmd:'print_request',
								id: request_id
							},
							success: function (result) {
								let data = JSON.parse(result);
								if (data.status=='ok') {
									window.open(data.path,`_blank`);
								} else if (data.status=='error') {
									console.log(`Error: `. data.message);
								} else {																						
									console.log(`Error: API error`);
								}
							}	
						});
					}
					";
?>