<?php
if (isset($_GET['id'])) {
	$get_jobcard = dbq("select * from jobcards where job_id={$_GET['id']} and mechanic_id={$_SESSION['user']['user_id']}");
	if ($get_jobcard) {
		if (dbr($get_jobcard) > 0) {
			$jobcard_ = dbf($get_jobcard);
			$get_plant = dbq("select * from plants_tbl where plant_id={$jobcard_['plant_id']}");
			if ($get_plant) {
				if (dbr($get_plant)) {
					$plant_ = dbf($get_plant);
				} else {
					error("invalid plant.");
					go('dashboard.php?page=open-job');
				}
			} else {
				sqlError();
				go('dashboard.php?page=open-job');
			}
		} else {
			error("invalid job card.");
			go('dashboard.php?page=open-job');
		}
	} else {
		sqlError();
		go('dashboard.php?page=open-job');
	}
} else {
	go('dashboard.php?page=open-job');
}
?>
<div class="row">
	<div class="col-lg-6 mb-3">
		<form action="" id="addplant">
			<section class="card">
				<header class="card-header">
					<div class="row">
						<div class="col-md-10">
							<h2 class="card-title">Vew Jobcard</h2>
							<p class="card-subtitle">View Job Card</p>
						</div>
						<div class="col-md-2">
							<a class="mb-1 mt-1 mr-1 modal-basic" href="#modalCloseJob"><button type="button" class='btn btn-danger float-right'>Close</button></a>
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
							<input type="text" name="plantNumber" class="form-control" value="<?= $plant_['fleet_number'] ?>" disabled>
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
							$safety_audit = json_decode($jobcard_['safety_audit'], true);
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

	<!-- Modal add event -->
	<div id="modalAddEvent" class="modal-block modal-block-lg mfp-hide">
		<section class="card">
			<header class="card-header">
				<h2 class="card-title">Add Event</h2>
			</header>
			<div class="card-body">
				<h2 class="card-title">Events</h2><br>
				<div class="row">
					<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
						<label class="col-form-label" for="formGroupExampleInput">Date</label>
						<input type="date" name="Date" placeholder="Date" class="form-control">
					</div>
					<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
						<label class="col-form-label" for="formGroupExampleInput">Select Event</label>
						<select class="form-control mb-3" id="roll">
							<option value="">Select a Event</option>
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
					<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
						<label class="col-form-label" for="formGroupExampleInput">Time Worked</label>
						<input type="time" name="timeWorked" placeholder="Time Worked" class="form-control">
					</div>
					<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
						<label class="col-form-label" for="formGroupExampleInput">Quality Check</label>
						<input type="text" name="qualityCheck" placeholder="Quality Check" class="form-control">
					</div>
					<div class="col-sm-12 col-md-8 pb-sm-9 pb-md-0">
						<label class="col-lg-3 control-label" for="Comment">Comment</label>
						<div class="col-lg-12">
							<textarea class="form-control" rows="3" id="Comment"></textarea>
						</div>
					</div>
					<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
						<button class="btn btn-primary">Add Event</button>
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

	<!-- Modal Close Jobcard -->
	<div id="modalCloseJob" class="modal-block modal-block-lg mfp-hide">
		<section class="card">
			<header class="card-header">
				<h2 class="card-title">Close Job Card</h2>
			</header>
			<div class="card-body">
				<div class="modal-wrapper">
					<div class="modal-text">
						<div class="row">
							<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
								<label class="col-form-label" for="formGroupExampleInput">Date Completed</label>
								<input type="datetime-local" name="compDate" placeholder="Last Service Date" class="form-control" value="<?= date("Y-m-d\TH:i:s") ?>">
							</div>
							<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
								<label class="col-form-label" for="formGroupExampleInput">Closing KM</label>
								<input type="text" name="closingKM" placeholder="Closing KM" class="form-control">
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
						<button class="btn btn-default modal-dismiss">Cancel</button>
					</div>
				</div>
			</footer>
		</section>
	</div>
	<!-- Modal view End -->
	<!-- Modal view -->
	<div id="modalviewevent" class="modal-block modal-block-lg mfp-hide">
		<section class="card">
			<header class="card-header">
				<h2 class="card-title">View Event</h2>
			</header>
			<div class="card-body">
				<div class="modal-wrapper">
					<div class="modal-text">
						<p>Event info here...</p>

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
	<!-- Modal Delete -->
	<div id="modalHeaderColorDanger" class="modal-block modal-header-color modal-block-danger mfp-hide">
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
						<p>Are you sure that you want to delete this event?</p>
					</div>
				</div>
			</div>
			<footer class="card-footer">
				<div class="row">
					<div class="col-md-12 text-right">
						<button type="button" class="btn btn-danger">Confirm</button>
						<button type="button" class="btn btn-danger modal-dismiss" data-bs-dismiss="modal">Cancel</button>
					</div>
				</div>
			</footer>
		</section>
	</div>
	<!-- Modal Delete End -->
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
		<section class="card">
			<header class="card-header">
				<h2 class="card-title">Spares Requisition BO</h2>
			</header>
			<div class="card-body">
				<div class="modal-wrapper">
					<div class="modal-text">
						<div class="row">
							<div class="col-sm-12 col-md-4">
								<label class="col-form-label">Plant #</label>
								<input type="text" name="plantnumber" placeholder="plantnumber" class="form-control">
							</div>
							<div class="col-sm-12 col-md-4">
								<label class="col-form-label">Date</label>
								<input type="date" name="date" class="form-control">
							</div>
							<div class="col-sm-12 col-md-4">
								<label class="col-form-label">Site</label>
								<input type="text" name="site" placeholder="site" class="form-control">
							</div>
							<div class="col-sm-12 col-md-4">
								<label class="col-form-label">HRS</label>
								<input type="text" name="HRS" placeholder="HRS" class="form-control">
							</div>
							<div class="col-sm-12 col-md-4">
								<label class="col-form-label">KM</label>
								<input type="text" name="KM" placeholder="KM" class="form-control">
							</div>
							<!-- Pull From Job Card -->
							<div class="col-sm-12 col-md-4">
								<label class="col-form-label">Job Number</label>
								<input type="text" name="jobnumber" placeholder="jobnumber" class="form-control">
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-3 col-md-3">
								<label class="col-form-label">QTY</label>
								<input type="number" name="qty" placeholder="qty" class="form-control">
							</div>
							<div class="col-sm-3 col-md-3">
								<label class="col-form-label">Part Number</label>
								<input type="text" name="partnumber" placeholder="Part Number" class="form-control">
							</div>
							<div class="col-sm-6 col-md-6">
								<label class="col-form-label">Description</label>
								<input type="text" name="description" placeholder="Description" class="form-control">
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12 col-md-12">
								<label class="col-form-label">Comment</label>
								<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
							</div>
							<div class="col-sm-4 col-md-4"><br>
								<button type="button" class="btn btn-primary">Add Part</button>
							</div>
						</div>
						<hr>
						<div class="row">
							<p>Requested by: </p><br>
							<p>Approved by: </p><br>
							<p>BS REQ #: </p>
						</div>
					</div>
				</div>
			</div>
			<footer class="card-footer">
				<div class="row">
					<div class="col-md-12 text-right">
						<button class="btn btn-default">Submit BO</button>
						<button class="btn btn-default modal-dismiss">Cancel</button>
					</div>
				</div>
			</footer>
		</section>
	</div>
	<!-- Modal view End -->
	<div class="col-lg-6 mb-3">
		<section class="card">
			<header class="card-header">
				<h2 class="card-title">Events</h2>
			</header>

			<div class="card-body">
				<div class="header-right">
					<a class="mb-1 mt-1 mr-1 modal-basic" href="#modalAddEvent"><button class="btn btn-primary">Add Event</button></a>
				</div>

				<form action="#" class="search nav-form">
					<div class="input-group">
						<input type="text" class="form-control" name="q" id="q" placeholder="Search Event...">
						<button class="btn btn-default" type="submit"><i class="bx bx-search"></i></button>
					</div>
				</form>

				<table width="1047" class="table table-responsive-md mb-0">
					<thead>
						<tr>
							<th width="100">Date</th>
							<th width="100">Type</th>
							<th width="120">Time Worked</th>
							<th width="120">Quality Check</th>
							<th width="459">Comments</th>
							<th width="120">Action</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td class="actions">
								<!-- Modal Edit Event -->
								<a class="mb-1 mt-1 mr-1 modal-basic" href="#modalviewevent"><i class="fas fa-pencil-alt"></i></a>
								<!-- Modal Edit Event End -->
								<!-- Modal Delete -->
								<a class="mb-1 mt-1 mr-1 modal-basic" href="#modalHeaderColorDanger"><i class="far fa-trash-alt"></i></a>
								<!-- Modal Delete End -->
							</td>
						</tr>
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
				<table width="1047" class="table table-responsive-md mb-0">
					<thead>
						<tr>
							<th width="100">Date</th>
							<th width="100">Type</th>
							<th width="120">Time Worked</th>
							<th width="120">Quality Check</th>
							<th width="459">Comments</th>
							<th width="120">Action</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td class="actions">
								<!-- Modal Edit Event -->
								<a class="mb-1 mt-1 mr-1 modal-basic" href="#modaleditspare"><i class="fas fa-pencil-alt"></i></a>
								<!-- Modal Edit Event End -->
								<!-- Modal Delete -->
								<a class="mb-1 mt-1 mr-1 modal-basic" href="#modalviewspare"><i class="fa-solid fa-eye"></i></a>
								<!-- Modal Delete End -->
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</section>


	</div>
</div>