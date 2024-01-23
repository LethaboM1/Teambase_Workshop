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

	<?php if ($jobcard_['jobcard_type'] == 'service') { ?>
	<div class="col-lg-12 mb-3">	
		<form id="service_checklist_frm" method="post">
		<section class="card">
			<header class="card-header">
				<div class="row">
						<div class="col-md-9">
							<h2 class="card-title">Service Sheet</h2>							
						</div>
				</div>
			</header>
			<div class="card-body">
				<div class="row">			
					<?= inp('cmd', '', 'hidden', 'save_service_checklist') ?>
					<?= inp('job_id', '', 'hidden', $_GET['id']) ?>
					<?= inp('service_type', '', 'hidden', $jobcard_['service_type']) ?>
				</div>
				<div class="row">
					<table class="table table-responsive-md table-bordered mb-0 dark">
						<thead>
							<tr>
								<th width="500">Task</th>
								<th width="150"><?= $jobcard_['service_type'] ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><strong>Hours</strong></td>
								<?php
								switch ($jobcard_['service_type']) {
									case "A":
								?>
										<td><strong>300</strong></td>
									<?php
										break;

									case "B":
									?>
										<td><strong>600</strong></td>
									<?php
										break;

									case "C":
									?>
										<td><strong>1200 / 2400</strong></td>
									<?php
										break;

									case "D":
									?>
										<td><strong>1200 / 2400</strong></td>
								<?php
										break;
								}
								?>
							</tr>
							<tr>
								<td><strong>Kilometres</strong></td>
								<?php
								switch ($jobcard_['service_type']) {
									case "A":
								?>
										<td><strong>5000</strong></td>
									<?php
										break;

									case "B":
									?>
										<td><strong>10000</strong></td>
									<?php
										break;

									case "C":
									?>
										<td><strong>20000 / 40000</strong></td>
									<?php
										break;

									case "D":
									?>
										<td><strong>20000 / 40000</strong></td>
								<?php
										break;
								}
								?>
							</tr>
							<tr>
								<td><strong>Kilometres</strong></td>
								<?php
								switch ($jobcard_['service_type']) {
									case "A":
								?>
										<td><strong>10000</strong></td>
									<?php
										break;

									case "B":
									?>
										<td><strong>20000</strong></td>
									<?php
										break;

									case "C":
									?>
										<td><strong>40000 / 80000</strong></td>
									<?php
										break;

									case "D":
									?>
										<td><strong>40000 / 80000</strong></td>
								<?php
										break;
								}
								?>
							</tr>
							<tr>
								<td><strong>Kilometres</strong></td>
								<?php
								switch ($jobcard_['service_type']) {
									case "A":
								?>
										<td><strong>15000</strong></td>
										<td></td>
									<?php
										break;

									case "B":
									?>
										<td><strong>30000</strong></td>
										<td></td>
									<?php
										break;

									case "C":
									?>
										<td><strong>45000 / 60000</strong></td>
										<td></td>
									<?php
										break;

									case "D":
									?>
										<td><strong>45000 / 60000</strong></td>
										<td></td>
								<?php
										break;
								}
								?>
							</tr>
							<?php
							//echo $jobcard_['service_checklist'];
							$jobcard_['service_checklist'] = rtrim($jobcard_['service_checklist'], "\0");
							$save_checklist = json_decode(base64_decode($jobcard_['service_checklist']), true); //, 512, JSON_UNESCAPED_UNICODE

							if ($save_checklist === null) {
								echo "Error: " . json_last_error_msg();
							}

							$toggle_select = [
								['name' => 'Yes', 'value' => 'Yes'],
								['name' => 'N/A', 'value' => 'N/A'],
							];

							//echo "<pre>xxx" . print_r($save_checklist, true) . "</pre>";
							$get_service_checklist = dbq("select * from service_checklist");
							if ($get_service_checklist) {
								if (dbr($get_service_checklist) > 0) {
									while ($item = dbf($get_service_checklist)) {
										$service_type = strtolower($jobcard_['service_type']) . '_service';
										switch ($item[$service_type]) {
											case "0":
							?>
												<tr>
													<td><?= $item['question'] ?></td>
													<td>0</td>
													<td>
														<?= inp("check_{$item['checklist_id']}", '', 'toggle-2', $save_checklist[$item['checklist_id']]['answer'], 'save', 0, $toggle_select, 'disabled="true"') ?>

												</tr>
											<?php
												break;

											case "C":
											?>
												<tr>
													<td><?= $item['question'] ?></td>
													<td>C</td>
													<td>
														<?= inp("check_{$item['checklist_id']}", '', 'toggle-2', $save_checklist[$item['checklist_id']]['answer'], 'save', 0, $toggle_select) ?>

												</tr>
							<?php
												break;
										}
									}
								}
							}

							?>
						</tbody>
					</table>
					<!-- <?= inp('save_progress', '', 'submit', 'Save', 'btn-primary') ?> -->				
				</div>
			</div>
			<footer class="card-footer text-end">
			</footer>
		</section>
		</form>
	</div>
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