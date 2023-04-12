<div class="row">
	<div class="col-lg-12 mb-12">
		<form method="post">
			<section class="card">
				<header class="card-header">
					<h2 class="card-title">Add New Defect Report</h2>
					<p class="card-subtitle">Add new defect report.</p>
				</header>
				<div class="card-body">
					<div class="row">
						<div id="plant_details" class="row">
							<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
								<label class="col-form-label" for="formGroupExampleInput">Date</label>
								<input type="date" name="date" placeholder="" class="form-control" value="<?= (isset($_POST['date']) ? $_POST['date'] : date('Y-m-d'))  ?>">
							</div>
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
											let plant_id = $(this).val();
											$('#driver_select').html(`<small><b>Loading...</b></small>`);
											$.ajax({
												method:'post',
												url:'includes/ajax.php',
												data: {
													cmd:'get_plant_details',
													plant_id: plant_id
												},
												success: function (result) {
													let data = JSON.parse(result);
													if (data.status == 'ok') {
														get_drivers(plant_id);
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
								$jscript_function .= "
													function get_drivers (plant_id) {
														$.ajax({									
															url: 'includes/ajax.php',
															data: {
																cmd: 'get_drivers',
																plant_id: plant_id
															},
															success: function (result) {
																$('#driver_select').html(result);
															}
														});
													}
													";

								?>
							</div>
							<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
								<div class="hide" id="driver_select">

								</div>
							</div>
							<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
								<label class="col-form-label" for="formGroupExampleInput">Reading <span id="reading_lbl"></span></label>
								<?= inp('reading_type', '', 'hidden') ?>
								<input id="reading" type="text" name="reading" placeholder="Reading" class="form-control">
							</div>
							<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
								<label class="col-form-label" for="formGroupExampleInput">Site</label>
								<input type="text" name="site" placeholder="site" class="form-control" value="<?= $_POST['site'] ?>" />
							</div>
							<hr>
							<div id="extras_details">
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

						</div>
						<div class="row">
							<table class="table table-responsive-md table-bordered mb-0 dark">
								<tr>
									<td>
										Engine fault?
									</td>
									<td>
										<div class="button r mt-1" id="button-1">
											<input name="engine_fault" type="checkbox" class="checkbox" value="Yes" />
											<div class="knobs"></div>
											<div class="layer"></div>
										</div>
									</td>
									<td>
										<?= inp('engine_comment', 'Comment', 'textarea') ?>
									</td>
								</tr>
								<tr>
									<td>
										Cooling system fault?
									</td>
									<td>
										<div class="button r mt-1" id="button-1">
											<input name="cooling_system_fault" type="checkbox" class="checkbox" value="Yes" />
											<div class="knobs"></div>
											<div class="layer"></div>
										</div>
									</td>
									<td>
										<?= inp('cooling_system_comment', 'Comment', 'textarea') ?>
									</td>
								</tr>
								<tr>
									<td>
										Gearbox, Gear selection / Clutch fault?
									</td>
									<td>
										<div class="button r mt-1" id="button-1">
											<input name="gear_clutch_fault" type="checkbox" class="checkbox" value="Yes" />
											<div class="knobs"></div>
											<div class="layer"></div>
										</div>
									</td>
									<td>
										<?= inp('gear_clutch_comment', 'Comment', 'textarea') ?>
									</td>
								</tr>
								<tr>
									<td>
										Electrical or batteries fault?
									</td>
									<td>
										<div class="button r mt-1" id="button-1">
											<input name="electrical_batteries_fault" type="checkbox" class="checkbox" value="Yes" />
											<div class="knobs"></div>
											<div class="layer"></div>
										</div>
									</td>
									<td>
										<?= inp('electrical_batteries_comment', 'Comment', 'textarea') ?>
									</td>
								</tr>
								<tr>
									<td>
										Hydraulics fault?
									</td>
									<td>
										<div class="button r mt-1" id="button-1">
											<input name="hydraulics_fault" type="checkbox" class="checkbox" value="Yes" />
											<div class="knobs"></div>
											<div class="layer"></div>
										</div>
									</td>
									<td>
										<?= inp('hydraulics_comment', 'Comment', 'textarea') ?>
									</td>
								</tr>
								<tr>
									<td>
										Instruments fault?
									</td>
									<td>
										<div class="button r mt-1" id="button-1">
											<input name="instruments_fault" type="checkbox" class="checkbox" value="Yes" />
											<div class="knobs"></div>
											<div class="layer"></div>
										</div>
									</td>
									<td>
										<?= inp('instruments_comment', 'Comment', 'textarea') ?>
									</td>
								</tr>
								<tr>
									<td>
										Brakes fault?
									</td>
									<td>
										<div class="button r mt-1" id="button-1">
											<input name="brakes_fault" type="checkbox" class="checkbox" value="Yes" />
											<div class="knobs"></div>
											<div class="layer"></div>
										</div>
									</td>
									<td>
										<?= inp('brakes_comment', 'Comment', 'textarea') ?>
									</td>
								</tr>
								<tr>
									<td>
										Body work fault?
									</td>
									<td>
										<div class="button r mt-1" id="button-1">
											<input name="body_work_fault" type="checkbox" class="checkbox" value="Yes" />
											<div class="knobs"></div>
											<div class="layer"></div>
										</div>
									</td>
									<td>
										<?= inp('body_work_comment', 'Comment', 'textarea') ?>
									</td>
								</tr>
								<tr>
									<td>
										Steering fault?
									</td>
									<td>
										<div class="button r mt-1" id="button-1">
											<input name="steering_fault" type="checkbox" class="checkbox" value="Yes" />
											<div class="knobs"></div>
											<div class="layer"></div>
										</div>
									</td>
									<td>
										<?= inp('steering_comment', 'Comment', 'textarea') ?>
									</td>
								</tr>
								<tr>
									<td>
										Glass or Mirrors fault?
									</td>
									<td>
										<div class="button r mt-1" id="button-1">
											<input name="glass_mirrors_fault" type="checkbox" class="checkbox" value="Yes" />
											<div class="knobs"></div>
											<div class="layer"></div>
										</div>
									</td>
									<td>
										<?= inp('glass_mirrors_comment', 'Comment', 'textarea') ?>
									</td>
								</tr>
								<tr>
									<td>
										Tracks under Carriage Tyres fault?
									</td>
									<td>
										<div class="button r mt-1" id="button-1">
											<input name="tracks_carriage_tyres_fault" type="checkbox" class="checkbox" value="Yes" />
											<div class="knobs"></div>
											<div class="layer"></div>
										</div>
									</td>
									<td>
										<?= inp('tracks_carriage_tyres_comment', 'Comment', 'textarea') ?>
									</td>
								</tr>
							</table>


							<div class="col-sm-12 col-md-6 pb-sm-4 pb-md-0">

							</div>
						</div>
					</div>
				</div>
				<footer class="card-footer text-end">
					<button name="submit" class="btn btn-primary">Submit Defect Report </button>
					<button type="reset" class="btn btn-default">Reset</button>
				</footer>
			</section>
		</form>
	</div>
</div>