<div class="row">
	<div class="col-xl-12">
		<form method="post">
			<section class="card">
				<header class="card-header">
					<h2 class="card-title">View Daily Pre-Task Mini Risk Assessment</h2>
					<div class="text-end">
						<a href="dashboard.php?page=job-card-view&id=<?= $_GET['jobid'] ?>" class="btn btn-primary">Back to Job Card</a>
					</div>
				</header>
				<div class="card-body">
					<!-- This section info pulls from Job Card -->
					<div class="row">
						<div class="col-sm-6 col-md-4 col-lg-4">
							<label class="col-form-label" for="formGroupExampleInput">Date</label>
							<input type="datetime-local" name="datetime" placeholder="" class="form-control" value="<?= $assessment_['date_time'] ?>">
						</div>
						<div class="col-sm-6 col-md-4 col-lg-4">
							<label class="col-form-label" for="formGroupExampleInput">Job No.</label>
							<input type="text" name="jobnumber" placeholder="Job No." class="form-control" value="<?= $jobcard_['jobcard_number'] ?>" disabled>
						</div>
						<div class="col-sm-6 col-md-4 col-lg-4">
							<label class="col-form-label" for="formGroupExampleInput">Plant No.</label>
							<input type="text" name="plantnumber" placeholder="Plant No." class="form-control" value="<?= $plant_['plant_number'] . ' ' . $plant_['reg_number'] . ' ' . $plant_['make'] . ' ' . $plant_['model'] ?>" disabled>
						</div>
						<div class="col-sm-6 col-md-4 col-lg-4">
							<label class="col-form-label" for="formGroupExampleInput">Notes - (Why this assessment?)</label>
							<textarea class="form-control" disabled><?= $assessment_['note'] ?></textarea>
						</div>
					</div>
					<hr>
					<!-- End Job Card info -->


					<div class="row">
						<table class="table table-responsive-md table-bordered mb-0 dark">
							<thead>
								<tr>
									<th width="10">#</th>
									<th width="480">Question</th>
									<th width="150">Answer</th>
									<th width="400">Comments</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$questions = base64_decode($assessment_['results']);
								$questions = json_decode($questions, true);
								error_log($assessment_['result']);
								if (is_array($questions) && count($questions) > 0) {
									$count = 1;
									foreach ($questions as $question) {
								?>
										<tr>
											<td><?= $count ?></td>
											<td><?= $question['question'] ?></td>
											<td>
												<div class="button r mt-1" id="button-1">
													<input type="checkbox" class="checkbox" value="Yes" <?= ($question['answer'] == 'Yes') ? "checked='checked'" : "" ?> disabled>
													<div class="knobs"></div>
													<div class="layer"></div>
												</div>
											</td>
											<td>
												<textarea class="form-control" rows="3" id="textareaDefault" disabled><?= $question['comment'] ?></textarea>
											</td>
										</tr>
								<?php
										$count++;
									}
								}

								?>
							</tbody>
						</table>
					</div>
					<br>
					<br>
					<div class="row">
						<p><strong>1 to 9 - if NO, Rectify.</strong><br>
							<strong>10 to 20 - if YES, mitigate by first using engineering methods before resorting to PPE</strong>
						</p>
					</div>
					<hr>
					<div class="row">
						<h3>Team members performing task</h3>
						<p>I, the undersigned, confirm and acknowledge that I have been involved with the HIRA and am aware of all hazards and risks associated with the task and undertake to follow the Safe Work Procedure, I aslo understand that my Safty is my own responsibility and that I must at all times report unsafe conditions.</p>
					</div>
					<div class="row">
						<div class="col-sm-5 col-md-5 col-lg-5">
							<label><input type="checkbox" name="agree_to_statements" id="checkboxExample4" value="agree" checked='checked' disabled> Confirm above stament.</label>
						</div>
					</div>
				</div>
				<br>
				<footer class="card-footer text-end">
					<a href="dashboard.php?page=job-card-view&id=<?= $_GET['jobid'] ?>" class="btn btn-primary">Back to Job Card</a>
				</footer>
			</section>
		</form>

	</div>
</div>