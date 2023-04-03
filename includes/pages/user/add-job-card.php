<div class="row">
	<div class="col-lg-12 mb-12">
		<form method="post">
			<section class="card">
				<header class="card-header">
					<h2 class="card-title">Add New Job Card</h2>
					<p class="card-subtitle">Add new job card.</p>
				</header>
				<div class="card-body">
					<div class="row">
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<?php
							$get_plants = dbq("select concat(reg_number,' - ',vehicle_type,' ',make,' ',model) as name, plant_id as value from plants_tbl where active=1 and plant_id in (select plant_id from plant_user_tbl where user_id={$_SESSION['user']['user_id']})");
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
														switch (data.result.reading_type) {
															case 'km':
															$('#reading').val(data.result.km_reading);
															$('#reading_lbl').html('(KM)');
															$('#reading_type').val('km');
															break;

															case 'hr':
																$('#reading').val(data.result.hr_reading);
																$('#reading_lbl').html('(HR)');
																$('#reading_type').val('hr');
															break;
														}

													} else {
														console.log(data.message);
													}
												}
											});
										});
										";

							?>
						</div>
						<?php

						$get_clerks = dbq("select concat(name,' ',last_name) as name, user_id as value, out_of_office from users_tbl where role='clerk'");
						if ($get_clerks) {
							$clerk_select_[] = ['name' => 'Select One', 'value' => 0];
							if (dbr($get_clerks)) {
								while ($clerk = dbf($get_clerks)) {
									if ($clerk['out_of_office'] == 1) {
										$clerk_select_[] = ['name' => $clerk['name'] . " - Out of office", 'value' => $clerk['value']];
									} else {
										$clerk_select_[] = ['name' => $clerk['name'], 'value' => $clerk['value']];
									}
								}
							}

							echo "<div class='col-sm-12 col-md-4 pb-sm-3 pb-md-0'>" . inp('clerk_id', 'Clerk', 'select', '', '', 0, $clerk_select_) . "</div>";
						}
						?>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Date</label>
							<input type="date" name="date" placeholder="" class="form-control" value="<?= date('Y-m-d') ?>">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Reading <span id="reading_lbl"></span></label>
							<?= inp('reading_type', '', 'hidden') ?>
							<input id="reading" type="text" name="reading" placeholder="Reading" class="form-control" disabled>
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Site</label>
							<input type="text" name="Site" placeholder="Site" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Select Fault Area</label>
							<select class="form-control mb-3" id="fault_area" name="fault_area">
								<option value="">Select Component</option>
								<option value="Engine">Engine</option>
								<option value="Clutch">Clutch</option>
								<option value="Gearbox/Drive Train">Gearbox/Drive Train/Gear Selection</option>
								<option value="Axel + Suspension Rear">Axel + Suspension Rear</option>
								<option value="Axel + Suspension Front">Axel + Suspension Front</option>
								<option value="Brakes">Brakes</option>
								<option value="Cab + Accessories">Cab + Accessories</option>
								<option value="Electrical">Electrical / Batteries</option>
								<option value="Hydraulics ">Hydraulics </option>
								<option value="Structure">Structure</option>
								<option value="All Glass & Mirrors">All Glass & Mirrors</option>
								<option value="Tracks / Under Carriage / Tyres">Tracks / Under Carriage / Tyres</option>
								<option value="Steering">Steering</option>
								<option value="Cooling System">Cooling System</option>
								<option value="Instruments">Instruments</option>
								<option value="Other">Other / Comment</option>
							</select>
						</div>
						<div class="col-sm-12 col-md-12">
							<label class="col-form-label" for="formGroupExampleInput">Comments</label>
							<textarea class="form-control" rows="3" id="comment" name="comment"></textarea>
							<br>
						</div>
					</div>
					<hr>
					<h2 class="card-title">Extras</h2><br>
					<div class="row">
						<?php
						$get_safety_equipment = dbq("select * from safety_equipment");
						if ($get_safety_equipment) {
							if (dbr($get_safety_equipment) > 0) {
								while ($equipment = dbf($get_safety_equipment)) {
						?>
									<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
										<div class="checkbox-custom checkbox-default">
											<input type="checkbox" id="<?= $equipment['code'] ?>" name="<?= $equipment['code'] ?>">
											<label for="<?= $equipment['code'] ?>"><?= $equipment['name'] ?></label>
										</div>
									</div>
						<?php
								}
							}
						}
						?>
					</div>

				</div>
				<footer class="card-footer text-end">
					<button name="request_jobcard" class="btn btn-primary">Request Job Card </button>
					<button type="reset" class="btn btn-default">Reset</button>
				</footer>
			</section>
		</form>
	</div>
</div>