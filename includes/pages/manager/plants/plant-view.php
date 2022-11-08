<?php
require "./includes/check.php";
if ($_SESSION['user']['role'] != 'manager' && $_SESSION['user']['role'] != 'system') {
	exit();
}
?>
<!-- Plant info -->
<div class="row">
	<div class="col-lg-6 col-md-6">
		<form action="" id="plantInfo">
			<section class="card">
				<header class="card-header">
					<h2 class="card-title">Plant Info</h2>
				</header>
				<div class="card-body">
					<div class="row">
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Plant No</label>
							<input type="text" name="plant_number" class="form-control" value="<?= $plant_['plant_number'] ?>" disabled>
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Vehicle Type</label>
							<input type="text" name="vehicletype" placeholder="Truck, TLB ..." class="form-control" value="<?= $plant_['vehicle_type'] ?>" disabled>
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Make</label>
							<input type="text" name="make" placeholder="Make" class="form-control" value="<?= $plant_['make'] ?>" disabled>
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Model</label>
							<input type="text" name="model" placeholder="Model" class="form-control" value="<?= $plant_['model'] ?>" disabled>
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Registration Number</label>
							<input type="text" name="reg_number" placeholder="AAA-456-L" class="form-control" value="<?= $plant_['reg_number'] ?>" disabled>
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">VIN Number</label>
							<input type="text" name="vin_number" placeholder="VIN Number" class="form-control" value="<?= $plant_['vin_number'] ?>" disabled>
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput"><?= strtoupper($row['reading_type']) ?> Reading</label>
							<input type="text" name="km_reading" placeholder="KM Reading" class="form-control" value="<?= $plant_[$row['reading_type'] . '_reading'] ?>" disabled>
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Next Service Reading</label>
							<input type="number" name="next_service_reading" placeholder="Next Service Reading" class="form-control" value="<?= $plant_['next_service_reading'] ?>" disabled>
						</div>
					</div>
				</div>
			</section>
		</form>
	</div>
	<!-- Plant info End -->
	<!-- Plant Users -->
	<div class="col-lg-6 col-md-6">
		<section class="card">
			<header class="card-header">
				<div class="row">
					<div class="col-md-8">
						<h2 class="card-title">Plant Users</h2>
					</div>
					<div class="col-md-4">
						<button onclick="addUsers()" type="button" id='add_users_btn' class="mb-1 mt-1 mr-1 btn btn-primary">Add User</button>
						<a class='modal-sizes' id='clickModalAddUsers' href='#modalAddUsers'></a>
						<?php
						$jscript_function .= "
											function addUsers () {
												$.ajax({
													method: 'post',
													url:'includes/ajax.php',
													data: {
														cmd: 'get_users_plant',
														plant_id: '{$_GET['id']}'
													},
													success: function (result) {
														$('#add_users_modal').html(result);
														$('#clickModalAddUsers').click();
													}
												});
											}
											";


						$modal_form = "<div id='add_users_modal'></div>";
						modal('modalAddUsers', 'Add Users to plant', $modal_form, 'Add Users', 'add_users');
						?>
					</div>
				</div>
			</header>
			<div class="card-body">
				<table width="1047" class="table table-responsive-md mb-0">
					<thead>
						<tr>
							<th width="200">Name</th>
							<th width="200">Surname</th>
							<th width="200">Email</th>
							<th width="200">Contact Number</th>
							<th width="47">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$get_users = dbq("select * from plant_user_tbl where plant_id='{$_GET['id']}'");
						if ($get_users) {
							if (dbr($get_users)) {
								while ($user = dbf($get_users)) {
									$user_ = dbf(dbq("select name, last_name, email, contact_number from users_tbl where user_id='{$user['user_id']}'"));
									echo "	<tr>
												<td>{$user_['name']}</td>
												<td>{$user_['last_name']}</td>
												<td>{$user_['email']}</td>
												<td>{$user_['contact_number']}</td>
												<td><i onclick='remove_user(`{$user['user_id']}`)' class='far fa-trash-alt pointer'></i></td>
											</tr>";
								}
							} else {
								echo "<tr><td colspan='6'>No Users added.</td></tr>";
							}

							$jscript_function .= "
												function remove_user (user_id) {
													$.ajax({
														method: 'post',
														url:'includes/ajax.php',
														data: {
															cmd: 'remove_user_plant',
															plant_id: '{$_GET['id']}',
															user_id: user_id
														},
														success: function (result) {
															$('#modal_remove_user').html(result);
															$('#remove_user_click').click();
														}
													});											
												}
												";

							$modal_form = "<div id='modal_remove_user'></div>";
							modal('modalRemoveUser', 'Remove User', $modal_form, 'Confirm', 'remove_user');
						}
						?>

					</tbody>
				</table>
				<a id="remove_user_click" class="mb-1 mt-1 mr-1 modal-basic" href="#modalRemoveUser"></a>
			</div>
		</section>
	</div>
	<!-- Plant Users End -->
</div>
<div class="row">
	<!-- Plant History -->
	<div class="col-lg-12 col-md-12">
		<section class="card">
			<header class="card-header">
				<h2 class="card-title">Plant History</h2>
			</header>
			<div class="card-body">
				<div class="header-right">
					<form action="#" class="search nav-form">
						<div class="input-group">
							<input type="text" class="form-control" name="q" id="q" placeholder="Search History...">
							<button class="btn btn-default" type="submit"><i class="bx bx-search"></i></button>
						</div>
					</form>
				</div>
				<table width="1047" class="table table-responsive-md mb-0">
					<thead>
						<tr>
							<th width="200">Event</th>
							<th width="200">Date</th>
							<th width="150">KM Reading</th>
							<th width="150">HR Reading</th>
							<th width="150">Down Time</th>
							<th width="150">Comment</th>
							<th width="47">Action</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td class="actions">
								<!-- View History -->
								<a class="mb-1 mt-1 mr-1 modal-sizes" href="#modalEditUser"><i class="fa-solid fa-magnifying-glass"></i></a>

								<div id="modalEditUser" class="modal-block modal-block-lg mfp-hide">
									<section class="card">
										<header class="card-header">
											<h2 class="card-title">Plant Event History</h2>
										</header>
										<div class="card-body">
											<div class="modal-wrapper">
												<div class="modal-text">

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
								<!-- View History End-->
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</section>
	</div>
	<!-- Plant Users End -->
</div>

<?php

/*
<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td class="actions">

								<div id="modalHeaderColorDanger" class="modal-block modal-header-color modal-block-danger mfp-hide">
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
													<p>Are you sure that you want to delete this User?</p>
												</div>
											</div>
										</div>
										<footer class="card-footer">
											<div class="row">
												<div class="col-md-12 text-right">
													<button type="button" class="btn btn-danger">Confirm</button>
													<button type="button" class="btn btn-danger modal-dismiss" data-bs-dismiss="modal">Cancel</button>
												</div>
											</div>
										</footer>
									</section>
								</div>
								<!-- Modal Delete End -->
							</td>
						</tr>
						*/