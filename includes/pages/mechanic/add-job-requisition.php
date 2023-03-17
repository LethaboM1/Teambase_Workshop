<div class="row">
	<div class="col-lg-12 mb-12">
		<form method="post">
			<section class="card">
				<header class="card-header">
					<h2 class="card-title">Add Requisition</h2>
					<p class="card-subtitle">
						Jobcard #<?= $jobcard_['jobcard_number'] ?><br>
						Plant #<?= $plant_['plant_number'] ?>
						<label class="col-form-label">Date/Time</label>
						<?php
						$datetime = date("Y-m-d\TH:i:s");
						echo inp('request_date', '', 'hidden', $datetime)
						?>
						<input type="datetime-local" name="date" class="form-control" value="<?= $datetime ?>" disabled>
					</p>
				</header>
				<div class="card-body">
					<div class="row">
						<div class="col-md-2">
							<select class="form-control mb-3" id="component" name="component">
								<option value="">Select Component</option>
								<option value="Engine">Engine</option>
								<option value="Clutch">Clutch</option>
								<option value="Gearbox/Drive Train">Gearbox/Drive Train</option>
								<option value="Axel + Suspension Rear">Axel + Suspension Rear</option>
								<option value="Axel + Suspension Front">Axel + Suspension Front</option>
								<option value="Brakes">Brakes</option>
								<option value="Cab + Accessories">Cab + Accessories</option>
								<option value="Electrical">Electrical</option>
								<option value="Hydraulics ">Hydraulics </option>
								<option value="Structure">Structure</option>
								<option value="Other">Other / Comment</option>
							</select>
						</div>
						<div class="col-md-2"><?= inp('part_no', '', 'text', '', '', 0, '', "placeholder='Part No.'") ?></div>
						<div class="col-md-2"><?= inp('description', '', 'text', '', '', 0, '', "placeholder='Description'") ?></div>
						<div class="col-md-2"><?= inp('qty', '', 'number', '1', '', 0, '', " min=1 placeholder='Qty'") ?></div>
						<div class="col-md-2"><?= inp('comment', '', 'text', '', '', 0, '', "placeholder='Comment'") ?></div>
						<div class="col-md-2"><button id='add_part' type="button" class="btn btn-primary btn-sm">Add</button></div>
					</div>
					<?php
					$jscript .= "
									$('#add_part').click(function () {
										let component = $('#component').val();
										let part_no = $('#part_no').val();
										let description = $('#description').val();
										let qty = $('#qty').val();
										let comment = $('#comment').val();

										if (
											description.length ==0
										) {
											console.log(`No description.`);
										} else {										
											let part = [];
											part = {
												'part_no':part_no,
												'description':description,
												'qty':qty,
												'comment':comment,
												'component': component
											};

											$.ajax({
												method:'post',
												url:'includes/ajax.php',
												data: {
													cmd:'add_part',
													part: JSON.stringify(part)

												},
												success: function (result) {
													let data = JSON.parse(result);
													if (data.status=='ok') {
														$('#parts_list').html(data.parts);
														$('#component').val(``);
														$('#part_no').val(``);
														$('#description').val(``);
														$('#qty').val(`1`);
													}
												},
												error: function (error) {

												}
											});
										}


									});
									";
					?>
					<table class="table table-hover">
						<thead>
							<th>Part No</th>
							<th>Description</th>
							<th>Qty</th>
							<th>Comment</th>
							<th></th>
						</thead>
						<tbody id='parts_list'>
							<?php
							if (is_array($_SESSION['request_parts']) && count($_SESSION['request_parts']) > 0) {
								foreach ($_SESSION['request_parts'] as $part) {
							?>
									<tr>
										<th><?= $part['component'] ?></th>
										<td><?= $part['component'] ?></td>
										<td><?= $part['part_no'] ?></td>
										<td><?= $part['description'] ?></td>
										<td><?= $part['qty'] ?></td>
										<td><?= $part['comment'] ?></td>
										<td>
											<a class='pointer' onclick='remove_part(`<?= $part['description'] ?>`)'>
												<i class="fa fa-trash"></i>
											</a>
										</td>
									</tr>
								<?php
								}
							} else {
								?>
								<tr>
									<td colspan='5'>No parts</td>
								</tr>
							<?php
							}

							$jscript_function = "
													function remove_part (description) {
														$.ajax({
															method:'post',
															url:'includes/ajax.php',
															data: {
																cmd:'remove_part',
																description: description
															},
															success: function (result) {
																let data = JSON. parse(result);
																if (data.status=='ok') {
																	$('#parts_list').html(data.parts);
																}
															},
															error: function (error) {},
														});
													}
												";
							?>
						</tbody>
					</table>
					<div class="col-md-12">
						<?= inp('request_comment', 'Comments', 'textarea') ?>
					</div>
				</div>
				<footer class="card-footer text-end">
					<button name="request_parts" type="submit" class="btn btn-primary">Process Requisition </button>
					<button name="cancel" type="submit" class="btn btn-default">Cancel</button>
				</footer>
			</section>
		</form>
	</div>
</div>