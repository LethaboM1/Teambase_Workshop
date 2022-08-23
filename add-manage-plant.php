<!doctype html>
<!-- Alerts -->
<!-- Possitive Alert User Added -->
<div class="alert alert-success alert-dismissible fade show" role="alert">
	<strong>Well done!</strong> New plant added successfully!
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close"></button>
</div>
<!-- Possitive Alert User Added -->
<div class="alert alert-success alert-dismissible fade show" role="alert">
	<strong>Well done!</strong> Plant edited successfully!
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close"></button>
</div>
<!-- Possitive Alert End -->
<!-- Negative Alert Delete User-->
<div class="alert alert-danger alert-dismissible fade show" role="alert">
	<strong>Oh snap!</strong> Plant deleted successfull!
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close"></button>
</div>
<!-- Negative Alert End -->

<div class="row">
<div class="col-sm-12 col-md-12 pb-sm-12 pb-md-0">
		<button href="#modalAddPlant" class="mb-1 mt-1 mr-1 modal-sizes btn btn-primary">Create New Plant</button>
		<div class="header-right">
			<form action="#" class="search nav-form">
				<div class="input-group">
					<input type="text" class="form-control" name="q" id="q" placeholder="Search Plant...">
					<button class="btn btn-default" type="submit"><i class="bx bx-search"></i></button>
				</div>
			</form>
		</div>	
	</div>	
<!-- Modal Add Plant -->
<div id="modalAddPlant" class="modal-block modal-block-lg mfp-hide">	
	<form action="" id="addplant">
		<section class="card">
			<header class="card-header">
				<h2 class="card-title">Add New Plant</h2>
				<p class="card-subtitle">Add new plant.</p>
			</header>
			<div class="card-body">
			<div class="row">
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Vehicle Type</label>	
				<input type="text" name="vehicletype" placeholder="Truck, TLB ..." class="form-control">
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Make</label>	
				<input type="text" name="make" placeholder="Make" class="form-control">
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Model</label>	
				<input type="text" name="model" placeholder="Model" class="form-control">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Registration Number</label>	
				<input type="text" name="regNumber" placeholder="AAA-456-L" class="form-control">
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">VIN Number</label>	
				<input type="text" name="vinNumber" placeholder="VIN Number" class="form-control">
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">KM Reading</label>	
				<input type="text" name="reading" placeholder="KM Reading" class="form-control">
				</div>
			</div>	
			<div class="row">
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Last Service Date</label>	
				<input type="date" name="lastService" placeholder="Last Service Date" class="form-control">
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Next Service Date</label>	
				<input type="date" name="nextService" placeholder="Next Service Date" class="form-control">
				</div>	
			</div>	
			</div>
			<footer class="card-footer text-end">
				<button class="btn btn-primary">Add Plant</button>
				<button class="btn btn-default modal-dismiss">Cancel</button>
			</footer>			
		</section>
	</form>
</div>	
<!-- Modal Add Plant End -->		
	
<div class="col-lg-12 mb-12">
	<section class="card">
		<header class="card-header">
			<h2 class="card-title">Manage Plant</h2>
		</header>
		<div class="card-body">
			<table width="1047" class="table table-responsive-md mb-0">
				<thead>
					<tr>
						<th width="200">Vehicle Type</th>
						<th width="200">Make</th>
						<th width="200">Registration Number</th>
						<th width="120">KM Reading</th>
						<th width="150">Last Service Date</th>
						<th width="150">Next Service Date</th>
						<th width="25">Action</th>
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
							<!-- Modal Edit Plant -->
							<a class="mb-1 mt-1 mr-1 modal-sizes" href="#modalEditUser"><i class="fas fa-pencil-alt"></i></a>
							<div id="modalEditUser" class="modal-block modal-block-lg mfp-hide">
								<section class="card">
								<header class="card-header">
								<h2 class="card-title">Edit Plant</h2>
								</header>
								<div class="card-body">
								<div class="modal-wrapper">
								<div class="modal-text">
							<form action="" id="editplant">
								<div class="row">
									<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
									<label class="col-form-label" for="formGroupExampleInput">Vehicle Type</label>	
									<input type="text" name="vehicletype" placeholder="Truck, TLB ..." class="form-control">
									</div>
									<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
									<label class="col-form-label" for="formGroupExampleInput">Make</label>	
									<input type="text" name="make" placeholder="Make" class="form-control">
									</div>
									<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
									<label class="col-form-label" for="formGroupExampleInput">Model</label>	
									<input type="text" name="model" placeholder="Model" class="form-control">
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
									<label class="col-form-label" for="formGroupExampleInput">Registration Number</label>	
									<input type="text" name="regNumber" placeholder="AAA-456-L" class="form-control">
									</div>
									<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
									<label class="col-form-label" for="formGroupExampleInput">VIN Number</label>	
									<input type="text" name="vinNumber" placeholder="VIN Number" class="form-control">
									</div>
									<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
									<label class="col-form-label" for="formGroupExampleInput">KM Reading</label>	
									<input type="text" name="reading" placeholder="KM Reading" class="form-control">
									</div>
								</div>	
								<div class="row">
									<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
									<label class="col-form-label" for="formGroupExampleInput">Last Service Date</label>	
									<input type="date" name="lastService" placeholder="Last Service Date" class="form-control">
									</div>
									<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
									<label class="col-form-label" for="formGroupExampleInput">Next Service Date</label>	
									<input type="date" name="nextService" placeholder="Next Service Date" class="form-control">
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
							<!-- Modal Edit Plant End -->
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
														<p>Are you sure that you want to delete this plant?</p>
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
							<a href="dashboard.php?page=view-plant"><i class="fa-solid fa-magnifying-glass"></i></a>
						<!-- View Profile End-->	
						</td>
					</tr>
				</tbody>
			</table>
	  </div>
	</section>	
</div>
</div>