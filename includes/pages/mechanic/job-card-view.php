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
							<label class="col-form-label" for="formGroupExampleInput">Plant Number</label>
							<input type="text" name="plantNumber" class="form-control" value="<?= $plant_['plant_number'] ?>" disabled>
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Date/Time</label>
							<input type="datetime-local" name="date" placeholder="" class="form-control" value="<?= $jobcard_['job_date'] ?>" disabled>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">(<?= strtoupper($plant_['reading_type']) ?>) Reading</label>
							<input type="text" class="form-control" value="<?= $plant_[$plant_['reading_type'] . '_reading'] ?>" disabled>
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Allocated Hours</label>
							<input type="text" name="hours" class="form-control" value="<?= $jobcard_['allocated_hours'] ?>" disabled>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Site</label>
							<input type="text" name="site" class="form-control" value="<?= $jobcard_['site'] ?>" disabled>
						</div>
					</div>

					<!-- <div class="row">
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Time In</label>
							<input type="text" name="timeIn" placeholder="Time In" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Travel Time</label>
							<input type="text" name="travelTime" placeholder="Travel Time" class="form-control">
						</div>
					</div>-->
					<hr>
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
				</div>
				<footer class="card-footer text-end">

				</footer>
			</section>
		</form>
	</div>
	<!-- Events -->
	<?php
	if ($jobcard_['status'] == 'logged' || is_null($jobcard_['clerk_id']) || $jobcard_['clerk_id'] == 0) {
	?>
		<div class="row">

			<?php
			$get_clerks = dbq("select name, user_id as value from users_tbl where role='clerk'");
			if ($get_clerks) {
				$clerk_select_[] = ['name' => 'Select One', 'value' => 0];
				if (dbr($get_clerks)) {
					while ($clerk = dbf($get_clerks)) {
						$clerk_select_[] = $clerk;
					}
				}

				echo "<div class='col-sm-12 col-md-4 pb-sm-3 pb-md-0'>" . inp('clerk_id', 'Clerk', 'select', $jobcard_['clerk_id'], '', 0, $clerk_select_) . "</div>";
			}
			?>
			<div class='col-sm-12 col-md-6 pb-sm-3 pb-md-0'>
				<?= inp('allocate_clerk', '', 'submit', 'Allocate')	?>
			</div>
		</div>
	<?php } ?>
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
							<label class="col-form-label" for="formGroupExampleInput">Start Date/Time</label>
							<input type="datetime-local" name="start_date" class="form-control" value="<?= date("Y-m-d\TH:i") ?>">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">End Date/Time</label>
							<input type="datetime-local" name="end_date" class="form-control" value="<?= date("Y-m-d\TH:i") ?>">
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
								<option value="Hydrolics">Hydrolics</option>
								<option value="Structure">Structure</option>
							</select>
						</div>
						<div class="col-sm-12 col-md-8 pb-sm-9 pb-md-0">
							<label class="col-lg-3 control-label" for="Comment">Comment</label>
							<div class="col-lg-12">
								<textarea name="comment" class="form-control" rows="3" id="Comment"></textarea>
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
								<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
									<label class="col-form-label" for="formGroupExampleInput">(<?= strtoupper($plant_['reading_type']) ?>) Reading</label>
									<input type="text" name="reading" placeholder="Reading" class="form-control">
								</div>
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


	<!-- Modal view -->
	<div id="modaleditspare" class="modal-block modal-block-lg mfp-hide">
		<section class="card">
			<header class="card-header">
				<h2 class="card-title">Edit Spares</h2>
			</header>
			<div class="card-body">
				<div class="modal-wrapper">
					<div class="modal-text">
						<p>Spare info here...</p>

					</div>
				</div>
			</div>
			<footer class="card-footer">
				<div class="row">
					<div class="col-md-12 text-right">
						<button class="btn btn-default modal-dismiss">Cancel</button>
					</div>
				</div>
			</footer>
		</section>
	</div>
	<!-- Modal view End -->
	<!-- Modal view -->
	<div id="modalviewspare" class="modal-block modal-block-lg mfp-hide">
		<section class="card">
			<header class="card-header">
				<h2 class="card-title">View Spares</h2>
			</header>
			<div class="card-body">
				<div class="modal-wrapper">
					<div class="modal-text">
						<p>spares info here...</p>

					</div>
				</div>
			</div>
			<footer class="card-footer">
				<div class="row">
					<div class="col-md-12 text-right">
						<button class="btn btn-default modal-dismiss">Cancel</button>
					</div>
				</div>
			</footer>
		</section>
	</div>
	<!-- Modal view End -->
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
		<section class="card">
			<header class="card-header">
				<h2 class="card-title">Events</h2>
			</header>

			<div class="card-body">
				<div class="header-right">
					<a class="mb-1 mt-1 mr-1 modal-basic" href="#modalAddEvent"><button class="btn btn-primary">Add Event</button></a>
				</div>
				<!-- <form action="#" class="search nav-form">
					<div class="input-group">
						<input type="text" class="form-control" name="q" id="q" placeholder="Search Event...">
						<button class="btn btn-default"><i class="bx bx-search"></i></button>
					</div>
				</form> -->

				<table width="1047" class="table table-responsive-md mb-0">
					<thead>
						<tr>
							<th width="100">Date</th>
							<th width="100">Type</th>
							<th width="120">Time Worked</th>
							<th width="459">Comments</th>
							<th width="120">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$get_job_events = dbq("select * from jobcard_events where job_id={$_GET['id']}");
						if ($get_job_events) {
							if (dbr($get_job_events) > 0) {
								while ($event = dbf($get_job_events)) {
						?>
									<tr>
										<td><?= $event['start_datetime'] ?></td>
										<td><?= $event['event'] ?></td>
										<td><?= $event['total_hours'] ?></td>
										<td><?= $event['comment'] ?></td>
										<td class="actions">
											<a class="mb-1 mt-1 mr-1 modal-basic" href="#modalViewEvent_<?= $event['event_id'] ?>"><i class="fas fa-pencil-alt"></i></a>
											<!-- Modal Edit Event End -->
											<!-- Modal Delete -->
											<a class="mb-1 mt-1 mr-1 modal-basic" href="#modalDeleteEvent_<?= $event['event_id'] ?>"><i class="far fa-trash-alt"></i></a>
											<!-- Modal Delete End -->
										</td>
									</tr>
						<?php
									$modal .= '<div id="modalDeleteEvent_' . $event['event_id'] . '" class="modal-block modal-header-color modal-block-danger mfp-hide">
												<form method="post">
													<section class="card">
														<header class="card-header">
															<h2 class="card-title">Are you sure?</h2>
														</header>
														<div class="card-body">
															<div class="modal-wrapper">
																<div class="modal-icon">
																	<i class="fas fa-times-circle"></i>
																</div>
																<div class="modal-text">
																	<h4>Danger</h4>
																	' . inp('event_id', '', 'hidden', $event['event_id']) . '
																	<p>Are you sure that you want to delete this event?</p>
																</div>
															</div>
														</div>
														<footer class="card-footer">
															<div class="row">
																<div class="col-md-12 text-right">
																	<button name="delete_event" type="submit" class="btn btn-danger">Confirm</button>
																	<button type="button" class="btn btn-danger modal-dismiss" data-bs-dismiss="modal">Cancel</button>
																</div>
															</div>
														</footer>
													</section>
												</form>
											</div>
											
											<div id="modalViewEvent_' . $event['event_id'] . '" class="modal-block modal-block-lg mfp-hide">
												<section class="card">
													<header class="card-header">
														<h2 class="card-title">View Event</h2>
													</header>
													<div class="card-body">
														<div class="modal-wrapper">
															<div class="modal-text">
																<b>Start Date/Time</b>&nbsp;' . $event['start_datetime'] . '<br>
																<b>End Date/Time</b>&nbsp;' . $event['end_datetime'] . '<br>
																<b>Event Type</b>&nbsp;' . $event['event'] . '<br>
																<b>Total Hours</b>&nbsp;' . $event['total_hours'] . '<br>
																<b>Comment</b><br>' . $event['comment'] . '<br>

															</div>
														</div>
													</div>
													<footer class="card-footer">
														<div class="row">
															<div class="col-md-12 text-right">
																<button class="btn btn-default modal-dismiss">Cancel</button>
															</div>
														</div>
													</footer>
												</section>
											</div>
											';
								}
							}
						}
						?>
						<!--<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td class="actions">
								 Modal Edit Event 
								<a class="mb-1 mt-1 mr-1 modal-basic" href="#modalviewevent"><i class="fas fa-pencil-alt"></i></a>-->
						<!-- Modal Edit Event End -->
						<!-- Modal Delete 
								<a class="mb-1 mt-1 mr-1 modal-basic" href="#modalHeaderColorDanger"><i class="far fa-trash-alt"></i></a>-->
						<!-- Modal Delete End 
							</td>
						</tr>-->
					</tbody>
				</table>
			</div>
		</section>

		<section class="card">
			<header class="card-header">
				<h2 class="card-title">Spares Requisition BO</h2>
			</header>
			<div class="card-body">
				<div class="header-right">
					<a class="mb-1 mt-1 mr-1 modal-basic" href="#modalrequestspare"><button class="btn btn-primary">Request Spares</button></a>
				</div>
				<table class="table table-responsive-md mb-0">
					<thead>
						<tr>
							<th>Date/Time</th>
							<th>Part No.</th>
							<th>Description</th>
							<th>Qty</th>
							<th>Comment</th>
							<th>Status</th>
							<th>Status:Comment</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$get_jobcard_requesitions = dbq("select * from jobcard_requisitions where job_id={$_GET['id']}");
						if ($get_jobcard_requesitions) {
							if (dbr($get_jobcard_requesitions) > 0) {
								while ($row = dbf($get_jobcard_requesitions)) {
									if ($row['status'] != 'requested') {
										$comment_ = $row[$row['status'] . '_by_comment'];
									} else {
										$comment_ = '';
									}
									echo "<tr>
													<td>{$row['datetime']}</td>
													<td>{$row['part_number']}</td>
													<td>{$row['part_description']}</td>
													<td>{$row['qty']}</td>
													<td>{$row['comment']}</td>
													<td>" . ucfirst($row['status']) . "</td>
													<td>{$comment_}</td>
													<td class='actions'>
														<a class='mb-1 mt-1 mr-1 modal-basic' href='#modalViewRequest_" . $row['request_id'] . "'><i class='fas fa-pencil-alt'></i></a>
														<!-- Modal Edit Event End -->
														<!-- Modal Delete -->
														<a class='mb-1 mt-1 mr-1 modal-basic' href='#modalDeleteRequest_" .  $row['request_id'] . "'><i class='far fa-trash-alt'></i></a>
														<!-- Modal Delete End -->
													</td>
											</tr>";

									$modal .= '<div id="modalDeleteRequest_' . $row['request_id'] . '" class="modal-block modal-header-color modal-block-danger mfp-hide">
												<form method="post">
													<section class="card">
														<header class="card-header">
															<h2 class="card-title">Are you sure?</h2>
														</header>
														<div class="card-body">
															<div class="modal-wrapper">
																<div class="modal-icon">
																	<i class="fas fa-times-circle"></i>
																</div>
																<div class="modal-text">
																	<h4>Danger</h4>
																	' . inp('request_id', '', 'hidden', $row['request_id']) . '
																	<p>Are you sure that you want to delete this part request?</p>
																</div>
															</div>
														</div>
														<footer class="card-footer">
															<div class="row">
																<div class="col-md-12 text-right">
																	<button name="delete_request" type="submit" class="btn btn-danger">Confirm</button>
																	<button type="button" class="btn btn-danger modal-dismiss" data-bs-dismiss="modal">Cancel</button>
																</div>
															</div>
														</footer>
													</section>
												</form>
											</div>
											
											<div id="modalViewRequest_' . $row['request_id'] . '" class="modal-block modal-block-lg mfp-hide">
												<section class="card">
													<header class="card-header">
														<h2 class="card-title">View Request</h2>
													</header>
													<div class="card-body">
														<div class="modal-wrapper">
															<div class="modal-text">
																<b>Date/Time</b>&nbsp;' . $row['datetime'] . '<br>
																<b>Part Number</b>&nbsp;' . $row['part_number'] . '<br>
																<b>Part Description</b>&nbsp;' . $row['part_description'] . '<br>
																<b>Qty</b>&nbsp;' . $row['qty'] . '<br>
																<b>Comment</b>&nbsp;' . $row['comment'] . '<br>
																<b>Status</b><br>' . $row['status'] . '<br>
																<b>Status:Comment</b><br>' . $comment_ . '<br>
															</div>
														</div>
													</div>
													<footer class="card-footer">
														<div class="row">
															<div class="col-md-12 text-right">
																<button class="btn btn-default modal-dismiss">Cancel</button>
															</div>
														</div>
													</footer>
												</section>
											</div>
											';
								}
							} else {
								echo "<tr><td colspan='7'>Nothing to list...</td></tr>";
							}
						} else {
							echo "<tr><td colspan='7'>Error: " . dbe() . "</td></tr>";
						}

						?>
					</tbody>
				</table>
				<hr>
			</div>
		</section>
	</div>
</div>
<?php
echo $modal;
