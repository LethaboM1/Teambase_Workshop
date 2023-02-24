<?php
$job_request = $row;
$jobcard_ = dbf(dbq("select * from jobcards where job_id={$job_request['job_id']}"));
$plant_ = dbf(dbq("select * from plants_tbl where plant_id={$job_request['plant_id']}"));
$mechanic_ = dbf(dbq("select * from users_tbl where user_id={$jobcard_['mechanic_id']}"));
if ($job_request['buyer_id'] > 0) {
	$buyer_ = dbf(dbq("select * from users_tbl where user_id={$job_request['buyer_id']}"));
}

switch ($row['status']) {
	case "requested":
		$progress = 0;
		$color = 'danger';
		break;

	case "approved":
		$progress = 25;
		$color = 'warning';
		break;

	case "ordered":
		$progress = 50;
		$color = 'warning';
		break;

	case "received":
		$progress = 75;
		$color = 'info';
		break;

	case "completed":
		$progress = 100;
		$color = 'success';
		break;
}

$request_status_select = [
	['name' => 'Requested', 'value' => 'requested'],
	['name' => 'Approved', 'value' => 'approved'],
	['name' => 'Ordered', 'value' => 'ordered'],
	['name' => 'Received', 'value' => 'received'],
	['name' => 'Completed', 'value' => 'completed'],
	['name' => 'Canceled', 'value' => 'canceled'],
	['name' => 'Rejected', 'value' => 'rejected'],
];

?>
<div class="col-md-12">
	<section class="card card-featured-left card-featured-<?= $color ?> mb-4">
		<div class="card-body">
			<div class="card-actions">
				<!-- Job Card Good -->
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
												<?php
												$jscript_function = "
																		function print_request (request_id) {
																			$.ajax({
																				method:'get',
																				url:'includes/ajax.php',
																				data: {
																					cmd:'print_request',
																					id: request_id
																				},
																				success: function (result) {
																					let data = JSON.parse(result);
																					if (data.status=='ok') {
																						window.open(data.path,`_blank`);
																					} else if (data.status=='error') {
																						console.log(`Error: `. data.message);
																					} else {																						
																						console.log(`Error: API error`);
																					}
																				}	
																			});
																		}
																		";
												?>
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
													<th>Part No.</th>
													<th>Description</th>
													<th style='width:85px;'>Qty</th>
													<th style='width:25px;'></th>
													<th>Comment</th>
													<th></th>
													<th style="width:35px;"></th>
												</thead>
												<tbody>
													<?php
													$get_parts = dbq("select * from jobcard_requisition_parts where request_id={$job_request['request_id']}");

													if ($_SESSION['user']['role'] == 'buyer') {
														$jscript_function .= "
																	function change_part_status(id,status) {
																		$.ajax({
																			method:'post',
																			url:'includes/ajax.php',
																			data: {
																				'cmd':'set_part_status',
																				'id': id,
																				'status': status
																			},
																			success: function (result) {
																				let data = JSON.parse(result);
																				if (data.status=='ok') {
																					console.log('Ok');
																					$('#id_' + id).html(`<i class='fa fa-check text-success'></i>`);
																				} else if (data.status=='error') {
																					console.log('Error : ' + data.message);
																					$('#id_' + id).html(`<i class='fa fa-times text-danger'></i>`);
																				} else {
																					console.log('Error ajax');
																					$('#id_' + id).html(`<i class='fa fa-times text-danger'></i>`);
																				}
																			},
																			error: function () {}
																		});
																	}
																	";
														unset($part_status_);
														$part_status_ = [
															['name' => '---', 'value' => ''],
															['name' => 'Ordered', 'value' => 'ordered'],
															['name' => 'Received', 'value' => 'received'],
															['name' => 'Completed', 'value' => 'completed'],
															['name' => 'Canceled', 'value' => 'canceled'],
															['name' => 'Rejected', 'value' => 'rejected']
														];
													}

													if ($get_parts) {
														if (dbr($get_parts) > 0) {
															while ($part = dbf($get_parts)) {
													?>
																<tr>
																	<td><?= $part['part_number'] ?></td>
																	<td><?= $part['part_description'] ?></td>
																	<td>
																		<?php
																		if ($_SESSION['user']['role'] == 'manager') {
																			echo inp("{$part['id']}_part_qty", '', 'text', $part['qty'], '', 0, '', " style='width:80px;'");
																		} else {
																			echo $part['qty'];
																		}


																		?>
																	</td>
																	<td><span id="<?= $part['id'] ?>_div"></span></td>
																	<td><?= $part['comment'] ?></td>
																	<td><?php
																		if ($_SESSION['user']['role'] == 'buyer') {
																			echo inp('status', '', 'select', $part['status'], '', 0, $part_status_, "style='width:150px;' onchange='change_part_status(`{$part['id']}`,$(this).val());'");
																		} else {
																			echo $part['status'];
																		}
																		?></td>
																	<td><span id="id_<?= $part['id'] ?>"></span></td>
																</tr>
													<?php
																$jscript .= "
																		$('#{$part['id']}_part_qty').change(function () {
																			$.ajax({
																				method:'post',
																				url:'includes/ajax.php',
																				data: {
																					cmd:'qty_ajust',
																					id: '{$part['id']}',
																					request_id: '{$job_request['request_id']}',
																					qty: $(this).val()
																				},
																				success: function (result) {
																					let data = JSON.parse(result);
																						
																					if (data.status=='ok') {																						
																						$('#{$part['id']}_div').html(`<i class='fa fa-check text-success'></i>`);
																					} else {																						
																						$('#{$part['id']}_div').html(`<i class='fa fa-times text-danger'></i>`);
																					}
																				},
																				error: function () {}
																			});
																		});
																		";
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
												if ($row['status'] == 'requested') {
													$request_status_select = [
														['name' => 'Choose', 'value' => '0'],
														['name' => 'Approved', 'value' => 'approved'],
														['name' => 'Rejected', 'value' => 'rejected'],
													];

													$get_buyers = dbq("select concat(name,' ',last_name) as name, user_id as value from users_tbl where active=1 and role='buyer'");
													unset($buyer_select_);
													$buyer_select_[] = ['name' => 'Choose buyer', 'value' => 0];
													if ($get_buyers) {

														if (dbr($get_buyers)) {
															while ($buyer = dbf($get_buyers)) {
																$buyer_select_[] = $buyer;
															}
														}
													}

													echo inp('request_id', '', 'hidden', $job_request['request_id'])
														. inp('comments', 'Mechanic Comment', 'textarea', $job_request['comment'], '', 0, '', 'disabled')
														. inp('status', 'Status', 'select', '', '', 0, $request_status_select)
														. inp('buyer_id', 'Buyer', 'select', '', '', 0, $buyer_select_)
														. inp('status_comment', 'Comment', 'textarea');
												} else {
													if ($_SESSION['user']['role'] == 'manager' || $_SESSION['user']['role'] == 'system') {

														$get_buyers = dbq("select concat(name,' ',last_name) as name, user_id as value from users_tbl where active=1 and role='buyer'");
														unset($buyer_select_);
														$buyer_select_[] = ['name' => 'Choose buyer', 'value' => 0];
														if ($get_buyers) {

															if (dbr($get_buyers)) {
																while ($buyer = dbf($get_buyers)) {
																	$buyer_select_[] = $buyer;
																}
															}
														}
													}
													unset($request_status_select);
													$request_status_select = [
														['name' => 'Choose', 'value' => '0'],
														['name' => 'Ordered', 'value' => 'ordered'],
														['name' => 'Received', 'value' => 'received'],
														['name' => 'Completed', 'value' => 'completed'],
														['name' => 'Canceled', 'value' => 'canceled'],
														['name' => 'Rejected', 'value' => 'rejected'],
													];

													echo inp('request_id', '', 'hidden', $job_request['request_id'])
														. inp('comments', 'Mechanic Comment', 'textarea', $job_request['comment'], '', 0, '', 'disabled')
														. inp('status', 'Status', 'select', $job_request['status'], '', 0, $request_status_select);

													if ($_SESSION['user']['role'] == 'manager' || $_SESSION['user']['role'] == 'system') {
														echo inp('buyer_id', 'Buyer', 'select', $job_request['buyer_id'], '', 0, $buyer_select_);
													} else {
														echo inp('buyer_id', '', 'hidden', $job_request['buyer_id']);
													}

													echo inp('status_comment', 'Comment', 'textarea');
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
				<!-- Modal view End -->
				<!-- Job Card End -->
			</div>
			<?php

			?>
			<p class="card-subtitle">
				Mechanic: <?= $mechanic_['name'] ?><br>
				Plant: <?= $plant_['plant_number'] ?> <?= ', ' . $plant_['vehicle_type'] ?> <?= ', ' . $plant_['make'] ?> <?= ', ' . $plant_['model'] ?>

			</p>
			<div class="progress progress-xl progress-half-rounded m-2">
				<div class="progress-bar progress-bar-<?= $color ?>" role="progressbar" aria-valuenow="<?php if ($progress == 0) {
																											echo 5;
																										} else {
																											echo $progress;
																										} ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php if ($progress == 0) {
																																										echo 5;
																																									} else {
																																										echo $progress;
																																									} ?>%;"><?= $progress ?>%</div>
			</div>
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