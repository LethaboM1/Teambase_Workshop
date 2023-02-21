<?php
$tyre_report = dbf(dbq("select * from jobcard_tyre_reports where id={$row['id']}"));
$jobcard_ = dbf(dbq("select * from jobcards where job_id={$tyre_report['job_id']}"));
$plant_ = dbf(dbq("select * from plants_tbl where plant_id={$jobcard_['plant_id']}"));
$mechanic_ = dbf(dbq("select * from users_tbl where user_id={$jobcard_['mechanic_id']}"));

?>
<div class="col-md-12">
	<section class="card card-featured-left card-featured-info mb-4">
		<div class="card-body">
			<div class="card-actions">
				<!-- Job Card Good -->
				<a class="mb-1 mt-1 mr-1 modal-sizes" href="#modalviewrequisition_<?= $row['id'] ?>"><i class="fa-solid fa-eye"></i></a>
				<!-- Modal view -->
				<div id="modalviewrequisition_<?= $row['id'] ?>" class="modal-block modal-block-lg mfp-hide">
					<form method="post">
						<section class="card">
							<header class="card-header">
								<h2 class="card-title">View Tyre Report</h2>
							</header>
							<div class="card-body">
								<div class="modal-wrapper">
									<div class="modal-text">
										<div class="row">
											<div class="col-md-6">
												<h3><b>Tyre Report #</b>&nbsp;<?= $tyre_report['id'] ?></h3>
												<b>Job card no.</b>&nbsp;<?= $jobcard_['jobcard_number'] ?><br>
												<b>Date.</b>&nbsp;<?= $tyre_report['datetime'] ?><br>
												<b>Mechanic.</b>&nbsp;<?= $mechanic_['name'] . ' ' . $mechanic_['last_name'] ?><br>
											</div>
											<div class="col-md-6">
												<button class="btn btn-lg btn-secondary" onclick="window.open(`print.php?type=tyre-report&id=<?= $row['id'] ?>`,`_blank`)" type="button">Print</button><br>

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
													<th>Pos.</th>
													<th>Make</th>
													<th>Size</th>
													<th>Type</th>
													<th>Tread</th>
													<th>Pressure</th>
													<th>V.Cap</th>
													<th>V.Ext</th>
												</thead>
												<tbody>
													<?php
													$get_lines = dbq("select * from jobcard_tyre_report_lines where tyre_rep_id={$row['id']}");

													if ($get_lines) {
														if (dbr($get_lines) > 0) {
															while ($tyre = dbf($get_lines)) {
													?>
																<tr>
																	<td><?= $tyre['position'] ?></td>
																	<td><?= $tyre['make'] ?></td>
																	<td><?= $tyre['size'] ?></td>
																	<td><?= $tyre['tyre_type'] ?></td>
																	<td><?= $tyre['tread'] ?></td>
																	<td><?= $tyre['pressure'] ?></td>
																	<td><?= ($tyre['valve_cap'] ? "Yes" : "No") ?></td>
																	<td><?= ($tyre['valve_ext'] ? "Yes" : "No") ?></td>
																</tr>
													<?php
															}
														} else {
															echo "<tr><td colspan='8'>Nothing</td></tr>";
														}
													} else {
														echo "<tr><td colspan='8'>" . dbe() . "</td></tr>";
													}
													?>
												</tbody>
											</table>
											<div class="col-md-12">
												<?php
												if ($row['checked_by'] == 0) {

													echo inp('id', '', 'hidden', $row['id'])
														. inp('note', 'Comment', 'textarea')
														. inp('confirm', '', 'inline-submit', 'Save', 'btn btn-primary');
												}
												?>
												<button class="btn btn-default modal-dismiss">Cancel</button>
											</div>
										</div>

									</div>
								</div>
							</div>
						</section>
					</form>
				</div>
				<!-- Modal view End -->
				<!-- Job Card End -->
			</div>
			<h4 class="text-info"><?= $jobcard_['jobcard_number'] ?>, Tyre Report #<?= $row['id'] ?> Mechanic: <?= $mechanic_['name'] . ' ' . $mechanic_['last_name'] ?><br></h4>
			<p class="card-subtitle">

				Plant: <?= $plant_['plant_number'] ?> <?= ', ' . $plant_['vehicle_type'] ?> <?= ', ' . $plant_['make'] ?> <?= ', ' . $plant_['model'] ?>
				Part: <?= $job_request['part_number'] ?>&nbsp;-&nbsp;<?= $job_request['part_description'] ?><br>

			</p>

		</div>
	</section>
</div>
<!-- Job Card Good End -->

<?php

/* 


		<!-- Job Card Causion -->
		<div class="col-md-12">
			<section class="card card-featured-left card-featured-warning mb-4">
				<div class="card-body">
					<div class="card-actions">
						<!-- View Job Card -->
						<a class="mb-1 mt-1 mr-1 modal-sizes" href="#modalviewjob2"><i class="fa-solid fa-eye"></i></a>
						<!-- Modal View -->
						<div id="modalviewjob2" class="modal-block modal-block-lg mfp-hide">
							<section class="card">
								<header class="card-header">
									<h2 class="card-title">View Job Card</h2>
								</header>
								<div class="card-body">
									<div class="modal-wrapper">
										<div class="modal-text">
											<p>Job Card info here...</p>

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
						<!-- Modal View End -->
						<!-- View Job Card End -->
					</div>
					<h2 class="card-title">Plant: HP56521</h2>
					<p class="card-subtitle">Opend by: Name</p>
					<div class="progress progress-xl progress-half-rounded m-2">
						<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;">20%</div>
					</div>
				</div>
			</section>
		</div>
		<!-- Job Card causion -->
		<!-- Job Card Danger -->
		<div class="col-md-12">
			<section class="card card-featured-left card-featured-danger mb-4">
				<div class="card-body">
					<div class="card-actions">
						<!-- View Job Card -->
						<a class="mb-1 mt-1 mr-1 modal-sizes" href="#modalviewjob3"><i class="fa-solid fa-eye"></i></a>
						<!-- Modal View -->
						<div id="modalviewjob3" class="modal-block modal-block-lg mfp-hide">
							<section class="card">
								<header class="card-header">
									<h2 class="card-title">View Job Card</h2>
								</header>
								<div class="card-body">
									<div class="modal-wrapper">
										<div class="modal-text">
											<p>Job Card info here...</p>

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
						<!-- Modal View End -->
						<!-- View Job Card End -->
					</div>
					<h2 class="card-title">Plant: HP56521</h2>
					<p class="card-subtitle">Opend by: Name</p>
					<div class="progress progress-xl progress-half-rounded m-2">
						<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">80%</div>
					</div>
				</div>
			</section>
		</div>
		<!-- Job Card Danger -->
*/