<!doctype html>
<!-- Alerts -->
<!-- Possitive Alert User Added -->
<div class="alert alert-success alert-dismissible fade show" role="alert">
	<strong>Well done!</strong> New user added successfully!
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close"></button>
</div>
<!-- Possitive Alert User Added -->
<div class="alert alert-success alert-dismissible fade show" role="alert">
	<strong>Well done!</strong> User edited successfully!
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close"></button>
</div>
<!-- Possitive Alert End -->
<!-- Negative Alert Delete User-->
<div class="alert alert-danger alert-dismissible fade show" role="alert">
	<strong>Oh snap!</strong> User deleted successfull!
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close"></button>
</div>
<!-- Negative Alert End -->
<div class="row">
	<div class="col-sm-12 col-md-12 pb-sm-12 pb-md-0">
		<button href="#modalAddUser" class="mb-1 mt-1 mr-1 modal-sizes btn btn-primary">Create User</button>
		<div class="header-right">
			<form action="#" class="search nav-form">
				<div class="input-group">
					<input type="text" class="form-control" name="q" id="q" placeholder="Search User...">
					<button class="btn btn-default" type="submit"><i class="bx bx-search"></i></button>
				</div>
			</form>
		</div>	
	</div>
	<!-- Modal Create User -->
	<div id="modalAddUser" class="modal-block modal-block-lg mfp-hide">
	<form action="" id="adduser">
		<section class="card">
			<header class="card-header">
				<h2 class="card-title">Add New User</h2>
				<p class="card-subtitle">Add new users. Photo should be in .jpg or .png format and not larger than 2MB.</p>
			</header>
			<div class="card-body">
			<div class="row">
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">First Name</label>	
				<input type="text" name="firstName" placeholder="First Name" class="form-control">
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Last Name</label>	
				<input type="text" name="lastName" placeholder="Last Name" class="form-control">
				</div>	
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">ID Number</label>	
				<input id="fc_inputmask_1" data-plugin-masked-input data-input-mask="999999-9999-999" placeholder="______-____-___" class="form-control">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Contact Number</label>	
				<input id="fc_inputmask_2" data-plugin-masked-input data-input-mask="999-999-9999" placeholder="___-___-____" class="form-control">
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Employee Number</label>	
				<input type="text" name="employeeNumber" placeholder="Employee Number" class="form-control">
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Email Address</label>	
				<input type="email" name="email" placeholder="Email Address" class="form-control">
				</div>
			</div>	
			<div class="row">
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Password</label>	
				<input type="password" name="password" placeholder="Password" class="form-control">
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Confirm Password</label>	
				<input type="password" name="confirmpassword" placeholder="Confirm Password" class="form-control">
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">User Roll</label>
					<select class="form-control mb-3" id="roll">
					<option value="">Select a User Roll</option>
					<option value="manager">Manager</option>
					<option value="supervisor">Supervisor</option>
				    <option value="mechanic">Mechanic</option>
					<option value="user">Driver / Opperator</option>
					</select>
				</div>	
			</div>
			<div class="row">
				<div class="col-sm-12 col-md-12 pb-sm-12 pb-md-0">	
				<label class="col-form-label" for="formGroupExampleInput">Upload Photo</label>
				<div class="fileupload fileupload-new" data-provides="fileupload">
				<div class="input-append">
				<div class="uneditable-input">
				<i class="fas fa-file fileupload-exists"></i>
				<span class="fileupload-preview"></span>
				</div>
				<span class="btn btn-default btn-file">
				<span class="fileupload-exists">Change</span>
				<span class="fileupload-new">Select file</span>
				<input type="file" />
				</span>
				<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
				</div>
				</div>
				</div>	
			</div>				
			</div>
			<footer class="card-footer text-end">
				<button class="btn btn-primary">Add User</button>
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
				<tbody>
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
							<div id="modalEditUser" class="modal-block modal-block-lg mfp-hide">
								<section class="card">
								<header class="card-header">
								<h2 class="card-title">Edit User</h2>
								</header>
								<div class="card-body">
								<div class="modal-wrapper">
								<div class="modal-text">
								<form action="" id="edituser">
								<div class="row">
								<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
								<label class="col-form-label" for="formGroupExampleInput">First Name</label>	
								<input type="text" name="firstName" placeholder="First Name" class="form-control">
								</div>
								<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
								<label class="col-form-label" for="formGroupExampleInput">Last Name</label>	
								<input type="text" name="lastName" placeholder="Last Name" class="form-control">
								</div>	
								<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
								<label class="col-form-label" for="formGroupExampleInput">ID Number</label>	
								<input id="fc_inputmask_1" data-plugin-masked-input data-input-mask="999999-9999-999" placeholder="______-____-___" class="form-control">
								</div>
								</div>
								<div class="row">
								<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
								<label class="col-form-label" for="formGroupExampleInput">Contact Number</label>	
								<input id="fc_inputmask_2" data-plugin-masked-input data-input-mask="999-999-9999" placeholder="___-___-____" class="form-control">
								</div>
								<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
								<label class="col-form-label" for="formGroupExampleInput">Employee Number</label>	
								<input type="text" name="employeeNumber" placeholder="Employee Number" class="form-control">
								</div>
								<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
								<label class="col-form-label" for="formGroupExampleInput">Email Address</label>	
								<input type="email" name="email" placeholder="Email Address" class="form-control">
								</div>
								</div>	
								<div class="row">
								<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
								<label class="col-form-label" for="formGroupExampleInput">Password</label>	
								<input type="password" name="password" placeholder="Password" class="form-control">
								</div>
								<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
								<label class="col-form-label" for="formGroupExampleInput">Confirm Password</label>	
								<input type="password" name="confirmpassword" placeholder="Confirm Password" class="form-control">
								</div>
								<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
								<label class="col-form-label" for="formGroupExampleInput">User Roll</label>
								<select class="form-control mb-3" id="roll">
								<option value="">Select a User Roll</option>
								<option value="manager">Manager</option>
								<option value="supervisor">Supervisor</option>
								<option value="mechanic">Mechanic</option>
								<option value="user">Driver / Opperator</option>
								</select>
								</div>	
								</div>
								<div class="row">
								<div class="col-sm-12 col-md-12 pb-sm-3 pb-md-0">	
								<label class="col-form-label" for="formGroupExampleInput">Upload Photo</label>
								<div class="fileupload fileupload-new" data-provides="fileupload">
								<div class="input-append">
								<div class="uneditable-input">
								<i class="fas fa-file fileupload-exists"></i>
								<span class="fileupload-preview"></span>
								</div>
								<span class="btn btn-default btn-file">
								<span class="fileupload-exists">Change</span>
								<span class="fileupload-new">Select file</span>
								<input type="file" />
								</span>
								<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
								</div>
								</div>
								</div>	
								</div>					
							</form>											
								</div>
								</div>
								</div>
							<footer class="card-footer">
								<div class="row">
								<div class="col-md-12 text-right">
								<button class="btn btn-primary modal-confirm">Save</button>
								<button class="btn btn-default modal-dismiss">Cancel</button>
								</div>
								</div>
							</footer>
								</section>
								</div>
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
					</tr>
				</tbody>
			</table>
	  </div>
	</section>	
</div>
</div>