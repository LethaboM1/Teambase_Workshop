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
				<form method="post">
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
										<?php
											break;

										case "B":
										?>
											<td><strong>30000</strong></td>
										<?php
											break;

										case "C":
										?>
											<td><strong>45000 / 60000</strong></td>
										<?php
											break;

										case "D":
										?>
											<td><strong>45000 / 60000</strong></td>
									<?php
											break;
									}
									?>
								</tr>
								<?php
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
														<td>0 <input type="checkbox" name="check_<?= $item['checklist_id'] ?>" value="Yes" id="checkboxExample4"></td>
													</tr>
												<?php
													break;

												case "C":
												?>
													<tr>
														<td><?= $item['question'] ?></td>
														<td>C <input type="checkbox" name="check_<?= $item['checklist_id'] ?>" value="Yes" id="checkboxExample4"></td>
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
				<br>
				<br>
				<div class="row">
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
						<form method="post">
							<section class="card">
								<header class="card-header">
									<h2 class="card-title">Spares Requisition BO</h2>
								</header>
								<div class="card-body">
									<div class="modal-wrapper">
										<div class="modal-text">
											<div class="row">
												<div class="col-sm-12 col-md-4">
													<label class="col-form-label">Date/Time</label>
													<?php
													$datetime = date("Y-m-d\TH:i:s");
													echo inp('request_date', '', 'hidden', $datetime)
													?>
													<input type="datetime-local" name="date" class="form-control" value="<?= $datetime ?>" disabled>
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-sm-3 col-md-3">
													<label class="col-form-label">Qty</label>
													<input type="number" name="qty" placeholder="qty" min='1' value="1" class="form-control">
												</div>
												<div class="col-sm-3 col-md-3">
													<label class="col-form-label">Part Number</label>
													<input type="text" name="part_number" placeholder="Part Number" class="form-control">
												</div>
												<div class="col-sm-6 col-md-6">
													<label class="col-form-label">Description</label>
													<input type="text" name="part_description" placeholder="Description" class="form-control">
												</div>
											</div>
											<div class="row">
												<div class="col-sm-12 col-md-12">
													<label class="col-form-label">Comment</label>
													<textarea name="comment" class="form-control" rows="3" id="textareaDefault"></textarea>
												</div>
											</div>
										</div>
									</div>
								</div>
								<footer class="card-footer">
									<div class="row">
										<div class="col-md-12 text-right">
											<button name='add_part' type="submit" class="btn btn-primary">Add Part</button>
											&nbsp;<button class="btn btn-default modal-dismiss">Cancel</button>
										</div>
									</div>
								</footer>
							</section>
						</form>
					</div>
					<!-- Modal view End -->
					<div class="">
						<section class="card">
							<header class="card-header">
								<h2 class="card-title">Spares Requisition BO</h2>
							</header>
							<div class="card-body">
								<div class="header-right">
									<a class="mb-1 mt-1 mr-1 modal-basic" href="#modalrequestspare"><button class="btn btn-primary">Request Spares</button></a>
								</div>
								<table class="table table-responsive-md mb-0">
									<thead>
										<tr>
											<th>Date/Time</th>
											<th>Part No.</th>
											<th>Description</th>
											<th>Qty</th>
											<th>Comment</th>
											<th>Status</th>
											<th>Status:Comment</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$get_jobcard_requesitions = dbq("select * from jobcard_requisitions where job_id={$_GET['id']}");
										if ($get_jobcard_requesitions) {
											if (dbr($get_jobcard_requesitions) > 0) {
												while ($row = dbf($get_jobcard_requesitions)) {
													echo "<tr>
													<td>{$row['datetime']}</td>
													<td>{$row['part_number']}</td>
													<td>{$row['part_description']}</td>
													<td>{$row['qty']}</td>
													<td>{$row['comment']}</td>
													<td>" . ucfirst($row['status']) . "</td>
													<td>{$row['status_comment']}</td>
											</tr>";
												}
											} else {
												echo "<tr><td colspan='7'>Nothing to list...</td></tr>";
											}
										} else {
											echo "<tr><td colspan='7'>Error: " . dbe() . "</td></tr>";
										}

										?>
									</tbody>
								</table>
								<hr>
							</div>
						</section>
					</div>
				</div>
				<hr>
				<div class="row">
					<label class="col-form-label">Comment</label>
					<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
				</div>
			</div>
			<footer class="card-footer text-end">
				<button class="btn btn-primary">Complete Service</button>
				<button type="reset" class="btn btn-default">Reset</button>
			</footer>
		</section>
	</div>
</div>