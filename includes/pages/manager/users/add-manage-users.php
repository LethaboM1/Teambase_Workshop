<div class="row">
	<div class="col-sm-12 col-md-12 pb-sm-12 pb-md-0">
		<button href="#modalAddUser" class="mb-1 mt-1 mr-1 modal-sizes btn btn-primary">Create User</button>
		<div class="header-right">
			<div class="input-group">
				<input type="text" class="form-control" name="search" id="search" placeholder="Search User...">
				<button class="btn btn-default" id='searchBtn' type="button"><i class="bx bx-search"></i></button>
				<?php
				$jscript .= "
									
									$('#search').keyup(function (e) {
										if (e.key=='Enter') {
											$('#searchBtn').click();
										}
						
						
										if (e.key=='Backspace') {
											if ($('#search').val().length==0) {
												$('#resetOpenBtn').click();
											}
										}
									});
						
									$('#searchBtn').click(function () {
										$.ajax({
											method:'post',
											url:'includes/ajax.php',
											data: {
												cmd:'search',
												type: 'users',
												search: $('#search').val()
											},
											success:function (result) {
												$('#users_list').html(result);
											},
											error: function (err) {}
										});
									});

									";
				?>
			</div>
		</div>
	</div>
	<!-- Modal Create User -->
	<div id="modalAddUser" class="modal-block modal-block-lg mfp-hide">
		<form method="post" id="adduser" enctype="multipart/form-data">
			<section class="card">
				<header class="card-header">
					<h2 class="card-title">Add New User</h2>
					<p class="card-subtitle">Add new users. Photo should be in .jpg or .png format and not larger than 2MB.</p>
				</header>
				<div class="card-body">
					<div class="row">
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">First Name</label>
							<input type="text" name="name" placeholder="First Name" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Last Name</label>
							<input type="text" name="last_name" placeholder="Last Name" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">ID Number</label>
							<input name="id_number" id="fc_inputmask_1" data-plugin-masked-input data-input-mask="999999-9999-999" placeholder="______-____-___" class="form-control">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Company Number</label>
							<input name="company_number" id="company_number" class="form-control" placeholder="Company number">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Contact Number</label>
							<input name="contact_number" id="fc_inputmask_2" data-plugin-masked-input data-input-mask="999-999-9999" placeholder="___-___-____" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Employee Number</label>
							<input type="text" name="emplyee_number" placeholder="Employee Number" class="form-control">
						</div>
					</div>
					<?= inp('fake-creds', '', 'fake-creds') ?>
					<div class="row">
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Email Address</label>
							<input type="email" name="email" placeholder="Email Address" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Password</label>
							<input type="password" name="password" placeholder="Password" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Confirm Password</label>
							<input type="password" name="confirmpassword" placeholder="Confirm Password" class="form-control">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">User Roll</label>
							<select name="role" class="form-control mb-3" id="roll">
								<option value="">Select a User Roll</option>
								<option value="manager">Manager</option>
								<option value="clerk">Clerk</option>
								<option value="supervisor">Supervisor</option>
								<option value="mechanic">Mechanic</option>
								<option value="user">Driver / Opperator</option>
							</select>
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-12 pb-md-0">
							<label class="col-form-label" for="photo">Photo</label>
							<div class="input-group mb-3">
								<input name="photo" id="photo" type="file" style="display:none">
								<input id="photo-box" type='text' class="form-control">
								<button id="photo-btn" type='button' class="input-group-text" id="basic-addon2"><i class="fa fa-image"></i></button>
							</div>
							<?php
							$jscript .= "
								$('#photo-btn').click(function (){ 
									$('#photo').click();

								});
								
								$('#photo-box').click(function (){ 
									$('#photo').click();

								});
								
								"

							?>
						</div>
					</div>
				</div>
				<footer class="card-footer text-end">
					<button type="submit" name="add_user" class="btn btn-primary">Add User</button>
					<button class="btn btn-default modal-dismiss">Cancel</button>
				</footer>
			</section>
		</form>
	</div>
	<!-- Modal Create User End -->
	<br>
	<br>
	<div class="col-lg-12 mb-12">
		<section class="card">
			<header class="card-header">
				<h2 class="card-title">Manage Users</h2>
			</header>
			<div class="card-body">
				<table width="1047" class="table table-responsive-md mb-0">
					<thead>
						<tr>
							<th width="200">First Name</th>
							<th width="200">Last Name</th>
							<th width="110">Email</th>
							<th width="110">Contact Number</th>
							<th width="150">ID Number</th>
							<th width="150">Employee Number</th>
							<th width="100">Roll</th>
							<th width="25">Actions</th>
						</tr>
					</thead>
					<tbody id="users_list">
						<?php

						$get_users = dbq("select * from users_tbl where role!='system' order by name");

						if ($get_users) {
							if (dbr($get_users) > 0) {
								while ($row = dbf($get_users)) {
									include "includes/pages/manager/users/list_users.php";
								}
							} else {
								echo "<tr><td colspan='8'>No Users</td></tr>";
							}
						} else {
							echo "<tr><td colspan='8'>Error reteiving users</td></tr>";
						}

						$modal_form = "<div id='edit_user_modal'></div>";
						modal('modalEditUser', 'Edit User', $modal_form, 'Save', 'save_user');

						$jscript_function .=	"
									function edit_user(user_id) {
										$.ajax({
											method:'post',
											url: 'includes/ajax.php',
											data: {
												cmd:'get_edit_user',
												user_id: user_id
											},
											success: function (result) {
												$('#edit_user_modal').html(result);
												$('#openModalEditUser').click();
											}
										});
									}
									";

						$modal_form = "<div id='del_user_modal'></div>";
						modal('modalDeleteUser', 'Delete User', $modal_form, 'Confirm', 'del_user');

						$jscript_function .=	"
												function delete_user(user_id) {
													$.ajax({
														method:'post',
														url: 'includes/ajax.php',
														data: {
															cmd:'get_del_user',
															user_id: user_id
														},
														success: function (result) {
															$('#del_user_modal').html(result);
															$('#openModalDeleteUser').click();
														}
													});
												}
												";
						$modal_form = "<div id='view_user_modal'></div>";
						modal('modalViewUser', 'View User Profile', $modal_form);

						$jscript_function .=	"
												function view_user(user_id) {
													$.ajax({
														method:'post',
														url: 'includes/ajax.php',
														data: {
															cmd:'get_view_user',
															user_id: user_id
														},
														success: function (result) {
															$('#view_user_modal').html(result);
															$('#openModalViewUser').click();
														}
													});
												}
												";
						?>
					</tbody>
				</table>
				<a id='openModalEditUser' href='#modalEditUser' class='mb-1 mt-1 mr-1 modal-sizes'></a>
				<a id="openModalDeleteUser" class="mb-1 mt-1 mr-1 modal-basic" href="#modalDeleteUser"></a>
				<a id="openModalViewUser" class="mb-1 mt-1 mr-1 modal-basic" href="#modalViewUser"></a>
			</div>
		</section>
	</div>
</div>
<?php
/*
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td class="actions">
								<!-- Modal Edit User -->
								<a class="mb-1 mt-1 mr-1 modal-sizes" href="#modalEditUser"><i class="fas fa-pencil-alt"></i></a>
								
								<!-- Modal Edit Usser End -->
								<!-- Modal Delete -->
								<a class="mb-1 mt-1 mr-1 modal-basic" href="#modalHeaderColorDanger"><i class="far fa-trash-alt"></i></a>

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
													<p>Are you sure that you want to delete this user?</p>
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
								<!-- View Profile -->
								<a class="mb-1 mt-1 mr-1 modal-basic" href="#modalview"><i class="fa-solid fa-magnifying-glass"></i></a>

								<div id="modalview" class="modal-block modal-block-lg mfp-hide">
									<section class="card">
										<header class="card-header">
											<h2 class="card-title">View User</h2>
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
								<!-- View Profile End-->
							</td>
						</tr>*/
