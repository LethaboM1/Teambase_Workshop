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
							<?= inp('jobcard_type', 'Jobcard Type', 'select', $_POST['jobcard_type'], '', 0, [['name' => 'Sundry', 'value' => 'sundry'], ['name' => 'Breakdown', 'value' => 'breakdown'], ['name' => 'Service', 'value' => 'service']]) ?>
							<?php
							$jscript .= "
										$('#jobcard_type').change(function () {
											if ($(this).val() == 'service') {
												$('#service_detail').show();
												$('#plant_details').show();
												$('#priority_detail').hide();
												$('#extras_details').show();
											} else if ($(this).val() == 'sundry') {
												$('#service_detail').hide();
												$('#plant_details').hide();
												$('#priority_detail').hide();
												$('#extras_details').hide();
											} else {
												$('#service_detail').hide();
												$('#plant_details').show();
												$('#priority_detail').show();
												$('#extras_details').show();
											}
										});"
								. (isset($_POST['jobcard_type']) ? "$('#jobcard_type').trigger('change')" : "");
							?>
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Date</label>
							<input type="date" name="date" placeholder="" class="form-control" value="<?= (isset($_POST['date']) ? $_POST['date'] : date('Y-m-d'))  ?>">
						</div>
						<?php

						$get_clerks = dbq("select concat(name,' ',last_name) as name, user_id as value, out_of_office from users_tbl where role='clerk' order by name");
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

							echo "<div class='col-sm-12 col-md-4 pb-sm-3 pb-md-0'>" . inp('clerk_id', 'Clerk', 'select', $_POST['clerk_id'], '', 0, $clerk_select_) . "</div>";
						}
						?>
						<div id="plant_details" style="display:none" class="row">
							<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
								<?php
								$get_plants = dbq("select concat(plant_number,' - ',vehicle_type,' ',make,' ',model) as name, plant_id as value from plants_tbl where active=1 order by plant_number");
								if ($get_plants) {
									if (dbr($get_plants) > 0) {
										while ($plant = dbf($get_plants)) {
											$plant_select_[] = $plant;
										}
									}
								}
								echo inp('plant_id', 'Plant Number', 'datalist', $_POST['plant_id'], '', 0, $plant_select_);
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
														$('#datalist_plant_id_input').val(data . result . plant_number+` - ` + data.result.vehicle_type + ` ` +  data.result.make + ` ` + data.result.model);

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
								<label class="col-form-label" for="formGroupExampleInput">Reading <span id="reading_lbl"></span></label>
								<?= inp('reading_type', '', 'hidden') ?>
								<input id="reading" type="text" name="reading" placeholder="Reading" class="form-control">
							</div>
							<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
								<label class="col-form-label" for="formGroupExampleInput">Site</label>
								<input type="text" name="site" placeholder="site" class="form-control" value="<?= $_POST['site'] ?>" </div>


							</div>


							<div id='priority_detail' style="display:none;" class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
								<?= inp('priority', 'Priority', 'select', $_POST['priority'], '', 0, [['name' => 'High', 'value' => 1], ['name' => 'Medium', 'value' => 2], ['name' => 'Low', 'value' => 3]]) ?>
							</div>
							<div id='service_detail' style="display:none;" class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
								<?= inp('service_type', 'Service Type', 'select', $_POST['service_type'], '', 0, [['name' => 'A', 'value' => 'A'], ['name' => 'B', 'value' => 'B'], ['name' => 'C', 'value' => 'C'], ['name' => 'D', 'value' => 'D']]) ?>
							</div>
							<div class="col-sm-12 col-md-12">
								<label class="col-form-label" for="formGroupExampleInput">Comments</label>
								<textarea class="form-control" rows="3" id="comment" name="comment"><?= $_POST['comment'] ?></textarea>
								<br>
							</div>
							<hr>
							<div id="extras_details" style="display:none">
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
								<hr>
							</div>
							<div class="col-sm-12 col-md-12">
								<?php

								$jscript .= "
										$('#add_insp').click(function () {
											let component = $('#component').val();
											let severity = $('#severity').val();
											let hours = $('#hours').val();
											let report_comment= $('#report_comment').val();
									
												report = {
													'component':component,
													'severity':severity,
													'hours':hours,
													'comment':report_comment,

												};

												$.ajax({
													method:'post',
													url:'includes/ajax.php',
													data: {
														cmd:'add_insp',
														insp: JSON.stringify(report)

													},
													success: function (result) {
														let data = JSON.parse(result);
														if (data.status=='ok') {
															$('#reports_list').html(data.reports);
															$('#component').val(``);
															$('#severity').val(``);
															$('#required_hrs').val(`1`);
															$('#report_comment').val(``);
															$('#alert_message').html(``);
														} else if (data.status=='error') {
															$('#alert_message').html(`<div class='alert alert-danger alert-dismissible fade show' role='alert'>
																						<strong>Success!</strong>&nbsp;` + data.message + `
																						<button type='button' class='btn-close' data-bs-dismiss='alert' aria-hidden='true' aria-label='Close'></button>
																					</div>`);
														}
													},
													error: function (error) {

													}
												});
										});
										";
								?>

								<h2 class="card-title">Plant Inspection / Job Instruction Report</h2>
								<div class="row mt-2">
									<div class="col-md-2"><select class="form-control mb-3" id="component" name="component">
											<option value="">Select Component</option>
											<option value="Engine">Engine</option>
											<option value="Clutch">Clutch</option>
											<option value="Gearbox/Drive Train">Gearbox/Drive Train</option>
											<option value="Axel + Suspension Rear">Axel + Suspension Rear</option>
											<option value="Axel + Suspension Front">Axel + Suspension Front</option>
											<option value="Brakes">Brakes</option>
											<option value="Cab + Accessories">Cab + Accessories</option>
											<option value="Electrical">Electrical</option>
											<option value="Hydraulics ">Hydraulics </option>
											<option value="Structure">Structure</option>
											<option value="Other">Other / Comment</option>
										</select></div>
									<div class="col-md-2"><select name="severity" class="form-control mb-3" id="severity">
											<option value="">Select Severity</option>
											<option value="low">Low</option>
											<option value="Medium">Medium</option>
											<option value="High">High</option>
										</select></div>
									<div class="col-md-2"><input type="number" name="hours" id="hours" value="1" placeholder="Required Hours" class="form-control"></div>
									<div class="col-md-4"><textarea class="form-control mt-2" name="report_comment" id="report_comment" placeholder="Details"></textarea></div>
									<div class="col-md-2"><button id='add_insp' type="button" class="btn btn-primary btn-sm">Add</button></div>
								</div>

								<div id="alert_message"></div>

								<table class="table table-hover">
									<thead>
										<tr>
											<th>Component</th>
											<th>Severity</th>
											<th>Required Hrs.</th>
											<th>Comment</th>
											<th></th>
										</tr>
									</thead>
									<tbody id="reports_list">
										<?php
										if (is_array($_SESSION['fault_reports']) && count($_SESSION['fault_reports']) > 0) {
											foreach ($_SESSION['fault_reports'] as $report) {
										?>
												<tr>
													<td><?= $report['component'] ?></td>
													<td><?= $report['severity'] ?></td>
													<td><?= $report['hours'] ?></td>
													<td><?= $report['comment'] ?></td>
													<td>
														<a onclick="remove_insp(`<?= $report['component'] ?>`)"><i class='fa fa-trash'></i></a>
													</td>
												</tr>
											<?php
											}
										} else {
											?>
											<tr>
												<td colspan="5">No fault / inspections reports</td>
											</tr>
										<?php
										}
										?>
									</tbody>
								</table>
								<?php

								$jscript_function = "
													function remove_insp (component) {
														$.ajax({
															method:'post',
															url:'includes/ajax.php',
															data: {
																cmd:'remove_insp',
																component: component
															},
															success: function (result) {
																let data = JSON. parse(result);
																if (data.status=='ok') {
																	$('#reports_list').html(data.reports);
																} else if (data.status=='error') {
																	$('#alert_message').html(`<div class='alert alert-danger alert-dismissible fade show' role='alert'>
																						<strong>Success!</strong>&nbsp;` + data.message + `
																						<button type='button' class='btn-close' data-bs-dismiss='alert' aria-hidden='true' aria-label='Close'></button>
																					</div>`);
																}
															},
															error: function (error) {},
														});
													}
												";
								?>
							</div>
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