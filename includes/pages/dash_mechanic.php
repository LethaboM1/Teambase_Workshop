<?php
if ($_SESSION['user']['role'] != 'mechanic') {
	exit();
}
?>
<div class="row">
	<div class="col-xl-6">
		<section class="card">
			<header class="card-header card-header-transparent">
				<h2 class="card-title">Job Requisitions</h2>
			</header>
			<div class="card-body">
				<table class="table table-responsive-md table-hover table-striped mb-0">
					<thead>
						<tr>
							<th>Job</th>
							<th>Plant</th>
							<th>Request ID</th>
							<th>Status</th>
							<th>Comment</th>
							<th>Progress</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$job_requests = dbq("select * from jobcard_requisitions where job_id in (select job_id from jobcards where status!='closed' and status!='completed' and mechanic_id={$_SESSION['user']['user_id']})");
						if ($job_requests) {
							if (dbr($job_requests) > 0) {
								while ($row = dbf($job_requests)) {
									$jobcard_ = dbf(dbq("select * from jobcards where job_id={$row['job_id']}"));
									$plant_ = dbf(dbq("select * from plants_tbl where plant_id={$row['plant_id']}"));
						?>
									<tr class="pointer" onclick="window.open(`dashboard.php?page=job-card-view&id=<?= $row['job_id'] ?>`,`_SELF`);">
										<td><?= $jobcard_['jobcard_number'] ?></td>
										<td><?= $plant_['plant_number'] ?></td>
										<td>#<?= $row['request_id'] ?></td>
										<td>
											<?php

											switch ($row['status']) {

												case "requested":
													echo "<span class='badge badge-danger'>" . ucfirst($row['status']) . "</span>";
													$percentage = 1;
													$color = 'danger';
													break;

												case "approved":
													echo "<span class='badge badge-warning'>" . ucfirst($row['status']) . "</span>";
													$percentage = 25;
													$color = 'warning';
													break;

												case "ordered":
													echo "<span class='badge badge-info'>" . ucfirst($row['status']) . "</span>";
													$percentage = 50;
													$color = 'info';
													break;

												case "received":
													echo "<span class='badge badge-success'>" . ucfirst($row['status']) . "</span>";
													$percentage = 75;
													$color = 'success';
													break;

												case "completed":
													echo "<span class='badge badge-success'>" . ucfirst($row['status']) . "</span>";
													$percentage = 100;
													$color = 'success';
													break;

												case "canceled":
													echo "<span class='badge badge-danger'>" . ucfirst($row['status']) . "</span>";
													$percentage = 100;
													$color = 'danger';
													break;

												case "rejected":
													echo "<span class='badge badge-danger'>" . ucfirst($row['status']) . "</span>";
													$percentage = 100;
													$color = 'danger';
													break;
											}

											?>
										</td>
										<td>
											<?= $row[$row['status'] . '_by_comment'] ?>
										</td>
										<td>
											<div class="progress progress-sm progress-half-rounded m-0 mt-1 light">
												<div class="progress-bar progress-bar-<?= $color ?>" role="progressbar" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="<?= $percentage ?>" style="width: <?= $percentage ?>%;">
													<?= $percentage ?>%
												</div>
											</div>
										</td>
										<td>
											<i class="fa fa-folder-open"></i>
										</td>
									</tr>
						<?php
								}
							}
						}
						?>


					</tbody>
				</table>
			</div>
		</section>
	</div>
</div>

<?php

/* 
<tr>
							<td>2</td>
							<td>HD 54654</td>
							<td><span class="badge badge-success">Success</span></td>
							<td>
								<div class="progress progress-sm progress-half-rounded m-0 mt-1 light">
									<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
										100%
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>3</td>
							<td>HD 54654</td>
							<td><span class="badge badge-warning">Warning</span></td>
							<td>
								<div class="progress progress-sm progress-half-rounded m-0 mt-1 light">
									<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
										60%
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>4</td>
							<td>HD 54654</td>
							<td><span class="badge badge-success">Success</span></td>
							<td>
								<div class="progress progress-sm progress-half-rounded m-0 mt-1 light">
									<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 90%;">
										90%
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>5</td>
							<td>HD 54654</td>
							<td><span class="badge badge-warning">Warning</span></td>
							<td>
								<div class="progress progress-sm progress-half-rounded m-0 mt-1 light">
									<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 45%;">
										45%
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>6</td>
							<td>HD 54654</td>
							<td><span class="badge badge-danger">Danger</span></td>
							<td>
								<div class="progress progress-sm progress-half-rounded m-0 mt-1 light">
									<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">
										40%
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>7</td>
							<td>HD 54654</td>
							<td><span class="badge badge-success">Success</span></td>
							<td>
								<div class="progress progress-sm progress-half-rounded mt-1 light">
									<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 95%;">
										95%
									</div>
								</div>
							</td>
						</tr>

*/