<div class="row">
	<div class="col-lg-12 mb-12">
		<form method='post' action="" id="addplant">
			<section class="card">
				<header class="card-header">
					<h2 class="card-title">Add New Job Card</h2>
					<p class="card-subtitle">Add new job card.</p>
				</header>
				<div class="card-body">
					<div class="row">
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Job Number</label>
							<input type="text" name="jobcard_number" placeholder="HG5452" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">

							<?php
							$get_plants = dbq("select concat(plant_number,' - ',vehicle_type,' ',make,' ',model) as name, plant_id as value from plants_tbl where active=1");
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
															$('#reading_inp').val(data.result.km_reading);
															$('#reading').val(data.result.km_reading);
															$('#reading_lbl').html('(KM)');
															$('#reading_type').val('km');
															break;

															case 'hr':
																$('#reading_inp').val(data.result.hr_reading);
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
						if ($_SESSION['user']['role'] == 'clerk') {
							echo inp('clerk_id', '', 'hidden', $_SESSION['user']['user_id']);
						} else {
							$get_clerks = dbq("select name, user_id as value from users_tbl where role='clerk'");
							if ($get_clerks) {
								$clerk_select_[] = ['name' => 'Select One', 'value' => 0];
								if (dbr($get_clerks)) {
									while ($clerk = dbf($get_clerks)) {
										$clerk_select_[] = $clerk;
									}
								}

								echo "<div class='col-sm-12 col-md-4 pb-sm-3 pb-md-0'>" . inp('clerk_id', 'Clerk', 'select', '', '', 0, $clerk_select_) . "</div>";
							}
						}
						?>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Reading <span id="reading_lbl"></span></label>
							<?= inp('reading_type', '', 'hidden') ?>
							<?= inp('reading', '', 'hidden') ?>
							<input id="reading_inp" type="text" name="reading" placeholder="Reading" class="form-control" disabled>
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Site</label>
							<input type="text" name="site" placeholder="Site" class="form-control" value="">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Date</label>
							<input type="datetime-local" name="job_date" placeholder="" class="form-control" value="<?= date('Y-m-d H:i') ?>">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Allocated Hours</label>
							<input type="number" name="allocated_hours" placeholder="Allocated Hours" class="form-control" value="1">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
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
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<?= inp('jobcard_type', 'Jobcard Type', 'select', '', '', 0, [['name' => 'Breakdown', 'value' => 'breakdown'], ['name' => 'Service', 'value' => 'service']]) ?>
							<?php
							$jscript .= "
										$('#jobcard_type').change(function () {
											if ($(this).val() == 'service') {
												$('#service_detail').show();
											} else {
												$('#service_detail').hide();
											}
										});
										";
							?>
						</div>
						<div id='service_detail' style="display:none;" class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<?= inp('service_type', 'Service Type', 'select', '', '', 0, [['name' => 'A', 'value' => 'A'], ['name' => 'B', 'value' => 'B'], ['name' => 'C', 'value' => 'C'], ['name' => 'D', 'value' => 'D']]) ?>
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<?= inp('priority', 'Priority', 'select', '', '', 0, [['name' => 'High', 'value' => 1], ['name' => 'Medium', 'value' => 2], ['name' => 'Low', 'value' => 3]]) ?>
						</div>
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