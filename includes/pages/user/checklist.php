<div class="row">
	<div class="col-sm-12 col-md-6">
		<section class="card">
			<header class="card-header">
				<h2 class="card-title">Checklist / Report</h2>
			</header>
			<div class="card-body">
				<!-- This section info pulls from Job Card -->
				<div class="row">
					<div class="col-sm-6 col-md-6 col-lg-6">
						<label class="col-form-label" for="formGroupExampleInput">Fleet No.</label>
						<input type="text" value="<?= $row['reg_number'] ?>" name="fleet" placeholder="Fleet No." class="form-control" disabled>
					</div>
					<div class="col-sm-6 col-md-6 col-lg-6">
						<label class="col-form-label" for="formGroupExampleInput">Date</label>
						<input type="date" value="<?= date('Y-m-d') ?>" name="date" placeholder="" class="form-control">
					</div>
					<div class="col-sm-6 col-md-6 col-lg-6">
						<label class="col-form-label" for="formGroupExampleInput">Driver</label>
						<input type="text" value="<?= $_SESSION['user']['name'] . ' ' . $_SESSION['user']['last_name'] ?>" name="driver" placeholder="Driver" class="form-control" disabled>
					</div>
					<div class="col-sm-6 col-md-6 col-lg-6">
						<label class="col-form-label" for="formGroupExampleInput"><?= strtoupper($row['reading_type']) ?></label>
						<input type="text" name="reading" placeholder="Reading" class="form-control" value="<?= $row[$row['reading_type'] . '_reading'] ?>" disabled>
					</div>
				</div>
				<hr>
				<!-- End Job Card info -->
				<div class="row">
					<table class="table table-responsive-md table-bordered mb-0 dark">
						<thead>
							<tr>
								<th width="600">Question</th>
								<th width="150">Answer</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$get_checklist = dbq("select * from plant_checklist order by item_order");
							if ($get_checklist) {
								if (dbr($get_checklist) > 1) {
									while ($checkitem = dbf($get_checklist)) {
										echo "
											<tr>
												<td>{$checkitem['check_item']}</td>
												<td>
													<div class='radio-custom radio-warning'>
														<input type='radio' name='{$checkitem['checklist_id']}' value='yes'><label>Yes</label>
													</div>
													<div class='radio-custom radio-warning'>
														<input type='radio' name='{$checkitem['checklist_id']}' value='no'><label>No</label>
													</div>
												</td>
											</tr>
											";
									}
								}
							}
							?>
						</tbody>
					</table>
				</div>
				<div class="row">
					<label class="col-form-label">Other Comments</label>
					<textarea name="comments" class="form-control" rows="3" id="textareaDefault"></textarea>
				</div>
			</div>
			<footer class="card-footer text-end">
				<button type="submit" name="submit_checklist" value="<?= $plant_id ?>" class="btn btn-primary">Submit Checklist</button>
				<button type="reset" class="btn btn-default">Reset</button>
			</footer>
		</section>

	</div>
</div>