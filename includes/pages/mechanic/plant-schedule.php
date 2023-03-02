<div class="row">
	<div class="col-xl-12">
		<section class="card">
			<header class="card-header">
				<h2 class="card-title">Plant Service Schedule</h2>
			</header>
			<div class="card-body">
				<div class="row">
					<div class="col-sm-6 col-md-6 col-lg-6">
						<label class="col-form-label" for="formGroupExampleInput">Job Number</label>
						<input type="text" name="jobnumber" placeholder="Job Number" class="form-control" value="<?= $jobcard_['jobcard_number'] ?>" disabled>
					</div>
					<div class="col-sm-6 col-md-6 col-lg-6">
						<label class="col-form-label" for="formGroupExampleInput">Plant No.</label>
						<input type="text" name="plantnumber" placeholder="Plant No." class="form-control" value="<?= $plant_['plant_number'] ?>" disabled>
					</div>
					<div class="col-sm-6 col-md-6 col-lg-6">
						<label class="col-form-label" for="formGroupExampleInput">Date Logged</label>
						<input type="datetime-local" name="date" placeholder="" class="form-control" value="<?= $jobcard_['job_date'] ?>" disabled>
					</div>
					<div class="col-sm-6 col-md-6 col-lg-6">
						<label class="col-form-label" for="formGroupExampleInput">(<?= strtoupper($plant_['reading_type']) ?>) Reading</label>
						<input type="text" name="hrs" placeholder="HRS/KM" class="form-control" value="<?= $plant_[$plant_['reading_type'] . '_reading'] ?>" disabled>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-sm-3 col-md-3 col-lg-3">
						<h4><strong>A:</strong> (A) Routine Oil Change</h4>
					</div>
					<div class="col-sm-3 col-md-3 col-lg-3">
						<h4><strong>B:</strong> (A+B) Minor Service</h4>
					</div>
					<div class="col-sm-3 col-md-3 col-lg-3">
						<h4><strong>C:</strong> (A+B+C) Major Service</h4>
					</div>
					<div class="col-sm-3 col-md-3 col-lg-3">
						<h4><strong>D:</strong> (A+B+C+D) Extended Major Service</h4>
					</div>
					<div class="col-sm-12 col-md-12 col-lg-12">
						<h4>Carry out all items where applicable: 0 - Compulsory | C - Check</h4>
					</div>
				</div>
				<hr>
				<form id="service_checklist_frm" method="post">
					<?= inp('cmd', '', 'hidden', 'save_service_checklist') ?>
					<?= inp('job_id', '', 'hidden', $_GET['id']) ?>
					<?= inp('service_type', '', 'hidden', $jobcard_['service_type']) ?>
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
															<?= inp("check_{$item['checklist_id']}", '', 'toggle-2', $save_checklist[$item['checklist_id']]['answer'], 'save', 0, $toggle_select) ?>

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
						<?= inp('save_progress', '', 'submit', 'Save', 'btn-primary') ?>
					</div>
				</form>
				<?php

				$jscript .= "
							$('.save').change(function () {
								save_progress();
							});
							";

				$jscript_function .= "
					function save_progress () {
						$.ajax({
							type: 'post',
							url: 'includes/ajax.php',
							data: $('#service_checklist_frm').serialize(),
							success: function (result) {
								console.log(result);
							}
						});

					}
								";
				?>
				<br>
				<br>
				<div class="row">
					<div id="modalCompleteService" class="modal-block modal-block-lg mfp-hide">
						<form method="post">
							<section class="card">
								<header class="card-header">
									<h2 class="card-title">Complete Service</h2>
								</header>
								<div class="card-body">
									<div class="modal-wrapper">
										<div class="modal-text">
											<div class="row">
												<?= inp('service_checklist', '', 'hidden', $jobcard_['service_checklist']) ?>
												<?= inp('service_type', '', 'hidden', $jobcard_['service_type']) ?>
												<?= inp('compdate', '', 'datetime', date("Y-m-d\TH:i")) ?>
												<?= inp('next_service_reading', 'Next Service Reading', 'number') ?>
												<label>Are you sure you want to complete / Close this service?</label>
											</div>
										</div>
									</div>
								</div>
								<footer class="card-footer">
									<div class="row">
										<div class="col-md-12 text-right">
											<button name='complete_service' type="submit" class="btn btn-primary">Complete Service</button>
											&nbsp;<button class="btn btn-default modal-dismiss">Cancel</button>
										</div>
									</div>
								</footer>
							</section>
						</form>
					</div>

					<div class="">
						<?php

						require_once "inc.evt.php";
						require_once "inc.sr.php";

						require_once "inc.ra.php";
						require_once "inc.tr.php";
						?>
					</div>
				</div>
				<hr>
				<div class="row">
					<label class="col-form-label">Comment</label>
					<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
				</div>
			</div>
			<footer class="card-footer text-end">
				<form method="post">
					<a class="mb-1 mt-1 mr-1 modal-basic" href="#modalCompleteService"><button class="btn btn-primary">Complete Service</button></a>
					<button type="reset" class="btn btn-default">Reset</button>
				</form>
			</footer>
		</section>
	</div>
</div>