<?php
$job_request = $row;
$jobcard_ = dbf(dbq("select * from jobcards where job_id={$job_request['job_id']}"));
$plant_ = dbf(dbq("select * from plants_tbl where plant_id={$job_request['plant_id']}"));
if ($jobcard_['mechanic_id'] > 0) $mechanic_ = dbf(dbq("select * from users_tbl where user_id={$jobcard_['mechanic_id']}"));
if ($job_request['buyer_id'] > 0) $buyer_ = dbf(dbq("select * from users_tbl where user_id={$job_request['buyer_id']}"));


?>
<tr>
	<td><?= $job_request['request_id'] ?></td>
	<td><?= $plant_['plant_number'] ?> <?= ', ' . $plant_['vehicle_type'] ?> <?= ', ' . $plant_['make'] ?> <?= ', ' . $plant_['model'] ?></td>
	<td><?= $mechanic_['name'] . ' ' . $mechanic_['last_name'] ?></td>
	<td><?= ucfirst($job_request['status']) ?></td>
	<td>
		<a class="mb-1 mt-1 mr-1 modal-sizes" href="#modalviewrequisition_<?= $row['request_id'] ?>"><i class="fa-solid fa-eye"></i></a>

		<!-- Modal view -->
		<div id="modalviewrequisition_<?= $row['request_id'] ?>" class="modal-block modal-block-lg mfp-hide">
			<form method="post">
				<section class="card">
					<header class="card-header">
						<h2 class="card-title">View Job Requition</h2>
					</header>
					<div class="card-body">
						<div class="modal-wrapper">
							<div class="modal-text">
								<div class="row">
									<div class="col-md-6">
										<h3><b>Request ID</b>&nbsp;<?= $job_request['request_id'] ?></h3>
										<b>Job card no.</b>&nbsp;<?= $jobcard_['jobcard_number'] ?><br>
										<b>Request Date.</b>&nbsp;<?= $job_request['datetime'] ?><br>
										<b>Mechanic.</b>&nbsp;<?= $mechanic_['name'] ?><br>
										<?php
										if ($row['status'] != 'requested') {
										?>
											<b>Buyer</b>&nbsp;<?= $buyer_['name'] ?> <?= $buyer_['last_name'] ?><br>
										<?php
										}
										?>
									</div>
									<div class="col-md-6">
										<button class="btn btn-lg btn-secondary" onclick="print_request(`<?= $job_request['request_id'] ?>`)" type="button">Print</button><br>

										<b>Plant No.</b>&nbsp;<?= $plant_['plant_number'] ?><br>
										<b>Plant Type.</b>&nbsp;<?= $plant_['vehicle_type'] ?><br>
										<b>Plant Model.</b>&nbsp;<?= $plant_['model'] ?><br>
										<b>Job card status</b>&nbsp;<?= ucfirst($jobcard_['status']) ?><br>
										<b>Job card type</b>&nbsp;<?= ucfirst($jobcard_['jobcard_type']) ?><br>

										<br>
										<br>
									</div>
									<table class="table table-hover">
										<thead>
											<th>Component</th>
											<th>Part No.</th>
											<th>Description</th>
											<th style='width:85px;'>Qty</th>
											<th style='width:25px;'></th>
											<th>Comment</th>
											<th></th>
										</thead>
										<tbody>
											<?php
											$get_parts = dbq("select * from jobcard_requisition_parts where request_id={$job_request['request_id']}");

											if ($get_parts) {
												if (dbr($get_parts) > 0) {
													while ($part = dbf($get_parts)) {
											?>
														<tr>
															<td><?= $part['component'] ?></td>
															<td><?= $part['part_number'] ?></td>
															<td><?= $part['part_description'] ?></td>
															<td><?= $part['qty']; ?></td>
															<td><span id="<?= $part['id'] ?>_div"></span></td>
															<td><?= $part['comment'] ?></td>
															<td><?= $part['status']; ?></td>

														</tr>
											<?php
													}
												} else {
													echo "<tr><td colspan='5'>Nothing</td></tr>";
												}
											} else {
												echo "<tr><td colspan='5'>" . dbe() . "</td></tr>";
											}
											?>
										</tbody>
									</table>
									<div class="col-md-12">
										<?php
										switch ($job_request['status']) {
											case 'rejected':
												if ($job_request['rejected_by'] > 0) {
													$rejected_by = dbf(dbq("select name,last_name from users_tbl where user_id={$job_request['rejected_by']}"));
												} else {
													$rejected_by['name'] = 'None';
													$rejected_by['last_name'] = '';
												}
										?>
												<b>Rejected By</b>&nbsp;<?= $rejected_by['name'] ?> <?= $rejected_by['last_name'] ?><br>
												<b>Date time</b>&nbsp; <?= $job_request['rejected_by_time'] ?><br>
												<b>Comment</b>&nbsp; <?= (strlen($job_request['rejected_by_comment']) > 0 ? "{$job_request['rejected_by_comment']}" : "No comment.") ?><br>
											<?php
												break;

											case 'canceled':
											?>

											<?php
												break;

											case 'completed':
											?>

										<?php
												break;
										}
										?>
									</div>
								</div>

							</div>
						</div>
					</div>
					<footer class="card-footer">
						<div class="row">
							<div class="col-md-12 text-right">
								<?= inp('change_status', '', 'inline-submit', 'Set', 'btn-primary') ?><button class="btn btn-default modal-dismiss">Cancel</button>
							</div>
						</div>
					</footer>
				</section>
			</form>
		</div>
		</div>
		</div>

	</td>
</tr>


<?php
