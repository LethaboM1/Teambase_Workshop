<div class="row">
	<div class="col-lg-12 mb-12">
		<form method='post' action="" id="addplant">
			<section class="card">
				<header class="card-header">
					<h2 class="card-title">Add New Job Card</h2>
					<p class="card-subtitle">Add new job card.</p>
				</header>
				<div class="card-body">

					<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
						<label class="col-form-label" for="formGroupExampleInput">Job Number</label>
						<input type="text" name="job_number" placeholder="HG5452" class="form-control">
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
														
														if (data.result.reading_type == 'km') {
															console.log('Changed km!');
															$('#km_details').show();
															$('#hr_details').hide();

															if (data.result.km_reading == null) {
																data.result.km_reading = 0;
															}

															$('#lastkmreading').val(data.result.km_reading);
														} else {console.log('Changed hr!');
															$('#hr_details').show();
															$('#km_details').hide();

															if (data.result.hr_reading == null) {
																data.result.hr_reading = 0;
															}
															
															$('#lasthrreading').val(data.result.hr_reading);
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
					<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
						<label class="col-form-label" for="formGroupExampleInput">Site</label>
						<input type="datetime-local" name="site" placeholder="" class="form-control" value="">
					</div>
					<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
						<label class="col-form-label" for="formGroupExampleInput">Date</label>
						<input type="datetime-local" name="job_date" placeholder="" class="form-control" value="<?= date('Y-m-d H:i:s') ?>">
					</div>

					<div style='display:none;' id="hr_details">
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Last HR Reading</label>
							<input id="lasthrreading" type="text" name="lasthrreading" placeholder="Last HR Reading" class="form-control" disabled>
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">HR Reading</label>
							<input id="hr_reading" type="text" name="hr_reading" placeholder="HR Reading" class="form-control">
						</div>
					</div>
					<div style='display:none;' id="km_details">
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Last KM Reading</label>
							<input id="lastkmreading" type="text" name="lastkmreading" placeholder="Last KM Reading" class="form-control" disabled>
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">KM Reading</label>
							<input id="km_reading" type="text" name="km_reading" placeholder="KM Reading" class="form-control">
						</div>
					</div>
					<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
						<label class="col-form-label" for="formGroupExampleInput">Allocated Hours</label>
						<input type="text" name="hours" placeholder="Allocated Hours" class="form-control">
					</div>

					<?php

					$mechanic_select_list[] = ['name' => 'Select Mechanic', 'value' => '0'];
					$get_mechanics = dbq("select concat(name,' ',last_name) as name, user_id as value from users_tbl where role='mechanic' and active=1");
					if ($get_mechanics) {
						if (dbr($get_mechanics) > 0) {
							while ($mechanic = dbf($get_mechanics)) {
								$mechanic_select_list[] = $mechanic;
							}
						}
					}
					echo inp('mechanic_id', 'Select Mechanic', 'select', '', '', 0, $mechanic_select_list);
					?>
					<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
						<label class="col-form-label" for="formGroupExampleInput">Vehicle Used to Site</label>
						<input type="text" name="vehicleUsed" placeholder="Vehicle Used to Site" class="form-control">
					</div>
				</div>
				<footer class="card-footer text-end">
					<button type='submit' name='add_jobcard' class="btn btn-primary">Create Job Card </button>
					<button type="reset" class="btn btn-default">Reset</button>
				</footer>
			</section>
		</form>
	</div>
</div>