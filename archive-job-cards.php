<!doctype html>
<!-- Possitive Alert User Added -->
<div class="alert alert-success alert-dismissible fade show" role="alert">
	<strong>Well done!</strong> Report Printed!
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close"></button>
</div>
<!-- Negative Alert Delete User-->
<div class="alert alert-danger alert-dismissible fade show" role="alert">
	<strong>Oh snap!</strong> Printing Failed!
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close"></button>
</div>
<!-- Negative Alert End -->
<div class="row">
				<div class="col-sm-6 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">From</label>	
				<input type="date" name="fromdate" placeholder="" class="form-control">
				</div>
				<div class="col-sm-6 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">To</label>	
				<input type="date" name="todate" placeholder="" class="form-control">
				</div>
				<div class="col-sm-6 col-md-4 pb-sm-3 pb-md-0">	
				<button class="btn btn-primary">Print Report</button>
				</div>
			</div>

<div class="row">
	<div class="col-xl-12">
		<!-- Job Card Good -->
		<div class="col-md-12">
			<section class="card card-featured-left card-featured mb-4">
				<div class="card-body">
					<div class="card-actions">
						<!-- Job Card Good -->
						<a class="mb-1 mt-1 mr-1 modal-sizes" href="#modalviewjob"><i class="fa-solid fa-eye"></i></a>
						<!-- Modal view -->
						<div id="modalviewjob" class="modal-block modal-block-lg mfp-hide">
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
						<!-- Modal view End -->
						<!-- Job Card End -->
						<!-- Assign Job Card -->
						<!-- Modal Assign -->
						<a class="mb-1 mt-1 mr-1 modal-sizes" href="#modalassign"><i class="fa-solid fa-handshake-angle"></i></a>
						<div id="modalassign" class="modal-block modal-block-lg mfp-hide">
								<section class="card">
								<header class="card-header">
								<h2 class="card-title">Assign Job Card</h2>
								</header>
								<div class="card-body">
									<form action="" id="assign">
										<div class="row">
											<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
											<label class="col-form-label" for="formGroupExampleInput">Job Number</label>	
											<input type="text" name="jobnumber" placeholder="HG5452" class="form-control">
											</div>
											<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
											<label class="col-form-label" for="formGroupExampleInput">Select Mechanic</label>
											<select class="form-control mb-3" id="roll">
											<option value="">Select a Mechanic</option>
											<option value="Mechanic1">Mechanic1</option>
											<option value="Mechanic2">Mechanic2</option>
											<option value="Mechanic3">Mechanic3</option>
											<option value="Mechanic4">Mechanic4</option>
											</select>
											</div>
										</div>
									</form>
								</div>
								<footer class="card-footer">
								<div class="row">
								<div class="col-md-12 text-right">
								<button class="btn btn-primary">Submit</button>	
								<button class="btn btn-default modal-dismiss">Cancel</button>
								</div>
								</div>
								</footer>	
								</section>
							</div>	
						<!-- Assign Job Card End -->
					</div>
						<h2 class="card-title">Plant: HP56521</h2>
						<p class="card-subtitle">Opend by: Name</p>
				</div>
			</section>
		</div>
		<!-- Job Card Good End -->
	</div>
</div>