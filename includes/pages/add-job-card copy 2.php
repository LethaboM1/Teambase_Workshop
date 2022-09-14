<div class="row">
	<div class="col-lg-12 mb-12">
		<form action="" id="addplant">
			<section class="card">
				<header class="card-header">
					<h2 class="card-title">Add New Job Card</h2>
					<p class="card-subtitle">Add new job card.</p>
				</header>
				<div class="card-body">
					<div class="row">
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Job Number</label>
							<input type="text" name="jobnumber" placeholder="HG5452" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">

							<?php
							$get_plants = dbq("select concat(reg_number,' - ',vehicle_type,' ',make,' ',model) as name, plant_id as value from plants_tbl where active=1");
							if ($get_plants) {
								if (dbr($get_plants) > 0) {
									while ($plant = dbf($get_plants)) {
										$plant_select_[] = $plant;
									}
								}
							}
							echo inp('plant_id', 'Plant Number', 'datalist', '', '', 0, $plant_select_);
							$jscript .= "
										$('#plant_id').change(function () {
											console.log('Changed!');
											$.ajax({
												method:'post',
												url:'includes/ajax.php',
												data: {
													cmd:'get_plant_details',
													plant_id: $(this).val()
												},
												success: function (result) {
													let data = JSON.parse(result);
													if (data.status == 'ok') {
														if (data.result.hr_reading == null) {
															data.result.hr_reading = 0;
														}
														$('#hr_reading').val(data.result.hr_reading);
														$('#km_reading').val(data.result.km_reading);

													} else {
														console.log(data.message);
													}
												}
											});
										});
										";
							?>
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Date</label>
							<input type="date" name="date" placeholder="" class="form-control" value="<?= date('Y-m-d') ?>">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">HR Reading</label>
							<input id="hr_reading" type="text" name="hrreading" placeholder="HR Reading" class="form-control" disabled>
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">KM Reading</label>
							<input id="km_reading" type="text" name="kmreading" placeholder="KM Reading" class="form-control" disabled>
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Allocated Hours</label>
							<input type="text" name="hours" placeholder="Allocated Hours" class="form-control">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Date Completed</label>
							<input type="date" name="compDate" placeholder="Last Service Date" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Vehicle Used to Site</label>
							<input type="text" name="vehicleUsed" placeholder="Vehicle Used to Site" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Open KM</label>
							<input type="text" name="openKM" placeholder="Open KM" class="form-control">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Closing KM</label>
							<input type="text" name="closingKM" placeholder="Closing KM" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Total KM</label>
							<input type="text" name="totalKM" placeholder="Total KM" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Time Out</label>
							<input type="text" name="timeOut" placeholder="Time Out" class="form-control">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Time In</label>
							<input type="text" name="timeIn" placeholder="Time In" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Travel Time</label>
							<input type="text" name="travelTime" placeholder="Travel Time" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Select Mechanic</label>
							<select class="form-control mb-3" id="roll">
								<option value="">Select a Mechanic</option>
								<option value="Mechanic1">Mechanic1</option>
								<option value="Mechanic2">Mechanic2</option>
								<option value="Mechanic3">Mechanic3</option>
								<option value="Mechanic4">Mechanic4</option>
							</select>
						</div>
					</div>
					<hr>
					<h2 class="card-title">Extras</h2><br>
					<div class="row">
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<div class="checkbox-custom checkbox-default">
								<input type="checkbox" id="sparewheele">
								<label for="checkboxExample1">Spare Wheele</label>
							</div>
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<div class="checkbox-custom checkbox-default">
								<input type="checkbox" id="wheelespanner">
								<label for="checkboxExample1">Wheele Spanner</label>
							</div>
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<div class="checkbox-custom checkbox-default">
								<input type="checkbox" id="jack">
								<label for="checkboxExample1">Jack</label>
							</div>
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<div class="checkbox-custom checkbox-default">
								<input type="checkbox" id="wheelespanner">
								<label for="checkboxExample1">Triangle</label>
							</div>
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<div class="checkbox-custom checkbox-default">
								<input type="checkbox" id="extinguisher">
								<label for="checkboxExample1">Fire Extinguisher</label>
							</div>
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<div class="checkbox-custom checkbox-default">
								<input type="checkbox" id="belt">
								<label for="checkboxExample1">Safety Belt</label>
							</div>
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<div class="checkbox-custom checkbox-default">
								<input type="checkbox" id="beacon">
								<label for="checkboxExample1">Rotating Beacon</label>
							</div>
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<div class="checkbox-custom checkbox-default">
								<input type="checkbox" id="blocks">
								<label for="checkboxExample1">Stop Blocks</label>
							</div>
						</div>
					</div>
				</div>
				<footer class="card-footer text-end">
					<button class="btn btn-primary">Create Job Card </button>
					<button type="reset" class="btn btn-default">Reset</button>
				</footer>
			</section>
		</form>
	</div>
</div>