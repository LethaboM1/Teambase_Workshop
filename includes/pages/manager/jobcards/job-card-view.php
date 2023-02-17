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
	<!-- Events -->
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


	<div class="col-lg-6 mb-3">
		<form method="post">
			<section class="card">
				<header class="card-header">
					<div class="row">
						<div class="col-md-9">
							<h2 class="card-title">Allocated Hours</h2>
							<p class="card-subtitle">Allocated Hours</p>
						</div>
					</div>
				</header>
				<div class="card-body">
					<div class="row">
						<div class="col-md-12 mb-4">
							<?= inp('allocated_hours', 'Allocated Hours', 'number', $jobcard_['allocated_hours'], '', 0, '', ' step="0.5"') ?>
						</div>
						<div class='col-md-12'>
							<?= inp('allocate_hours', '&nbsp', 'inline-submit', 'Allocate', 'btn-primary') ?>
						</div>
					</div>
				</div>
				<footer class="card-footer text-end">

				</footer>
			</section>
		</form>
	</div>
	<?php if ($jobcard_['jobcard_type'] != 'service') { ?>
		<!-- Modal add event -->
		<div id="modalAddEvent" class="modal-block modal-block-lg mfp-hide">
			<form method="post">
				<section class="card">
					<header class="card-header">
						<h2 class="card-title">Add Event</h2>
					</header>
					<div class="card-body">
						<h2 class="card-title">Events</h2><br>
						<div class="row">
							<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
								<label class="col-form-label" for="formGroupExampleInput">Event Date</label>
								<input type="date" name="event_date" class="form-control" value="<?= date('Y-m-d') ?>">
							</div>
							<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
								<label class="col-form-label" for="formGroupExampleInput">Hours Worked</label>
								<input type="number" name="total_hours" step="0.5" class="form-control" value="1">
							</div>
							<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
								<label class="col-form-label" for="formGroupExampleInput">Select Event</label>
								<select class="form-control mb-3" name="event" id="event">
									<option value="0">Select a Event</option>
									<option value="Engine">Engine</option>
									<option value="Clutch">Clutch</option>
									<option value="Gearbox">Gearbox/Drive Train</option>
									<option value="Axlerear">Axel + Suspension Rear</option>
									<option value="Axlefront">Axel + Suspension Front</option>
									<option value="Brakes">Brakes</option>
									<option value="Cab">Cab + Accessories</option>
									<option value="Electrical">Electrical</option>
									<option value="Hydraulics ">Hydraulics </option>
									<option value="Structure">Structure</option>
								</select>
							</div>
							<div class="col-sm-12 col-md-8 pb-sm-9 pb-md-0">
								<label class="col-lg-3 control-label" for="Comment">Comment</label>
								<div class="col-lg-12">
									<textarea name="comment" class="form-control" rows="3" id="Comment"></textarea>view eve
								</div>
							</div>
							<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">

							</div>
						</div>
					</div>
					<footer class="card-footer">
						<div class="row">
							<div class="col-md-12 text-right">
								<button type="submit" name="add_event" class="btn btn-primary">Add Event</button>&nbsp;<button class="btn btn-default modal-dismiss">Cancel</button>
							</div>
						</div>
					</footer>
				</section>
			</form>
		</div>
		<!-- Modal view End -->
	<?php } ?>

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


	<!-- Modal view -->
	<div id="modalrequestspare" class="modal-block modal-block-lg mfp-hide">
		<form method="post">
			<section class="card">
				<header class="card-header">
					<h2 class="card-title">Spares Requisition BO</h2>
				</header>
				<div class="card-body">
					<div class="modal-wrapper">
						<div class="modal-text">
							<div class="row">
								<div class="col-sm-12 col-md-4">
									<label class="col-form-label">Date/Time</label>
									<?php
									$datetime = date("Y-m-d\TH:i:s");
									echo inp('request_date', '', 'hidden', $datetime)
									?>
									<input type="datetime-local" name="date" class="form-control" value="<?= $datetime ?>" disabled>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-sm-3 col-md-3">
									<label class="col-form-label">Qty</label>
									<input type="number" name="qty" placeholder="qty" min='1' value="1" class="form-control">
								</div>
								<div class="col-sm-3 col-md-3">
									<label class="col-form-label">Part Number</label>
									<input type="text" name="part_number" placeholder="Part Number" class="form-control">
								</div>
								<div class="col-sm-6 col-md-6">
									<label class="col-form-label">Description</label>
									<input type="text" name="part_description" placeholder="Description" class="form-control">
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12 col-md-12">
									<label class="col-form-label">Comment</label>
									<textarea name="comment" class="form-control" rows="3" id="textareaDefault"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				<footer class="card-footer">
					<div class="row">
						<div class="col-md-12 text-right">
							<button name='add_part' type="submit" class="btn btn-primary">Add Part</button>
							&nbsp;<button class="btn btn-default modal-dismiss">Cancel</button>
						</div>
					</div>
				</footer>
			</section>
		</form>
	</div>
	<!-- Modal view End -->

	<div class="col-lg-12 mb-3">
		<?php if ($jobcard_['jobcard_type'] != 'service') {
			require_once "inc.evt.php";
		} ?>

		<?php if ($jobcard_['jobcard_type'] != 'sundry') {
			require_once "inc.sr.php";
		} ?>
	</div>
</div>
<?php
echo $modal;
