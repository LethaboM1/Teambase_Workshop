<section class="card">
	<header class="card-header">
		<h2 class="card-title">Spares Requisition BO</h2>
	</header>
	<div class="card-body">
		<div class="header-right">
			<a class="mb-1 mt-1 mr-1" href="dashboard.php?page=add-job-requisition&id=<?= $_GET['id'] ?>"><button class="btn btn-primary">Request Spares</button></a>
		</div>
		<table class="table table-hover table-responsive-md mb-0">
			<thead>
				<tr>
					<th>Date/Time</th>
					<th>Request ID.</th>
					<th>Status</th>
					<th>Status:Comment</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$get_jobcard_requesitions = dbq("select * from jobcard_requisitions where job_id={$_GET['id']}");
				if ($get_jobcard_requesitions) {
					if (dbr($get_jobcard_requesitions) > 0) {
						while ($row = dbf($get_jobcard_requesitions)) {
							if ($row['status'] != 'requested') {
								$comment_ = $row[$row['status'] . '_by_comment'];
							} else {
								$comment_ = '';
							}
							echo "<tr class='pointer'>
													<td class='mb-1 mt-1 mr-1 modal-basic' href='#modalViewRequest_" . $row['request_id'] . "'>{$row['datetime']}</td>
													<td class='mb-1 mt-1 mr-1 modal-basic' href='#modalViewRequest_" . $row['request_id'] . "'>{$row['request_id']}</td>
													<td class='mb-1 mt-1 mr-1 modal-basic' href='#modalViewRequest_" . $row['request_id'] . "'>{$row['comment']}</td>
													<td class='mb-1 mt-1 mr-1 modal-basic' href='#modalViewRequest_" . $row['request_id'] . "'>" . ucfirst($row['status']) . "</td>
													<td class='mb-1 mt-1 mr-1 modal-basic' href='#modalViewRequest_" . $row['request_id'] . "'>{$comment_}</td>
													<td class='actions' style='width:60px;'>
														<a class='mb-1 mt-1 mr-1 modal-basic' href='#modalViewRequest_" . $row['request_id'] . "'><i class='fa fa-eye'></i></a>
														<!-- Modal Edit Event End -->
														<!-- Modal Delete -->
														<a class='mb-1 mt-1 mr-1 modal-basic' href='#modalDeleteRequest_" .  $row['request_id'] . "'><i class='far fa-trash-alt'></i></a>
														<!-- Modal Delete End -->
													</td>
											</tr>";

							$modal .= '<div id="modalDeleteRequest_' . $row['request_id'] . '" class="modal-block modal-header-color modal-block-danger mfp-hide">
												<form method="post">
													<section class="card">
														<header class="card-header">
															<h2 class="card-title">Are you sure?</h2>
														</header>
														<div class="card-body">
															<div class="modal-wrapper">
																<div class="modal-icon">
																	<i class="fas fa-times-circle"></i>
																</div>
																<div class="modal-text">
																	<h4>Danger</h4>
																	' . inp('request_id', '', 'hidden', $row['request_id']) . '
																	<p>Are you sure that you want to delete this part request?</p>
																</div>
															</div>
														</div>
														<footer class="card-footer">
															<div class="row">
																<div class="col-md-12 text-right">
																	<button name="delete_request" type="submit" class="btn btn-danger">Confirm</button>
																	<button type="button" class="btn btn-danger modal-dismiss" data-bs-dismiss="modal">Cancel</button>
																</div>
															</div>
														</footer>
													</section>
												</form>
											</div>
											
											<div id="modalViewRequest_' . $row['request_id'] . '" class="modal-block modal-block-lg mfp-hide">
												<section class="card">
													<header class="card-header">
														<div class="row">
															<div class="col-md-6">
																<h2 class="card-title">View Requisition</h2>
															</div>
															<div class="col-md-6">
																<button class="btn btn-lg btn-secondary" onclick="print_request(`' . $row['request_id'] . '`)" type="button">Print</button><br>
															</div>
														</div>

													</header>
													<div class="card-body">
														<div class="modal-wrapper">
															<div class="modal-text">
																<b>Date/Time</b>&nbsp;' .  $row['datetime'] . '<br>		
																<b>Request ID</b>&nbsp;' . $row['request_id'] . '<br>
																<b>Status</b><br>' . $row['status'] . '<br>
																<b>Status:Comment</b><br>' . $comment_ . '<br>
																<table class="table table-hover">
																	<thead>
																		<th>Part No</th>
																		<th>Description</th>
																		<th>Qty</th>
																		<th>Comment</th>
																		<th></th>
																	</thead>
																	<tbody>';
							$get_parts = dbq("select * from jobcard_requisition_parts where request_id={$row['request_id']}");
							if ($get_parts) {
								if (dbr($get_parts) > 0) {
									while ($part = dbf($get_parts)) {
										$modal .= "<tr>
																<td>{$part['part_number']}</td>
																<td>{$part['part_description']}</td>
																<td>{$part['qty']}</td>
																<td>{$part['comment']}</td>
																<td>
																	
																</td>
															</tr>";
									}
								}
							}

							$modal .= '						</tbody>
																</table>
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
											';
						}
					} else {
						echo "<tr><td colspan='7'>Nothing to list...</td></tr>";
					}
				} else {
					echo "<tr><td colspan='7'>Error: " . dbe() . "</td></tr>";
				}

				?> </tbody>
		</table>
		<hr>
	</div>
</section>