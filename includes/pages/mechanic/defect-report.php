<!-- Alerts -->
<!-- Possitive Alert User Added -->
<div class="alert alert-success alert-dismissible fade show" role="alert">
	<strong>Well done!</strong> New Job Card added successfully!
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close"></button>
</div>
<!-- Negative Alert Delete User-->
<div class="alert alert-danger alert-dismissible fade show" role="alert">
	<strong>Oh snap!</strong> Event deleted successfull!
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close"></button>
</div>
<!-- Negative Alert End -->

<div class="row">
	<div class="col-lg-6 mb-3">
		<form action="" id="inspection">
			<section class="card">
				<header class="card-header">
					<h2 class="card-title">Defect Report</h2>
				</header>
				<div class="card-body">
					<div class="row">
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label">Date</label>
							<input type="date" name="date" placeholder="Date" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label">Site</label>
							<input type="text" name="site" placeholder="Site" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label">Fleet No.</label>
							<input type="text" name="fleet" placeholder="Plant No." class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label">Registration No.</label>
							<input type="text" name="reg" placeholder="Registration No." class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label">KM / HM</label>
							<input type="text" name="km" placeholder="KM / HM" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label">Operator / Driver</label>
							<input type="text" name="driver" placeholder="Operator / Driver" class="form-control">
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-sm-12 col-md-6">
							<label class="col-form-label">Engine</label>
							<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
						</div>
						<div class="col-sm-12 col-md-6">
							<label class="col-form-label">Cooling System</label>
							<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
						</div>
						<div class="col-sm-12 col-md-6">
							<label class="col-form-label">Gear Box, Gear Selection / Church</label>
							<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
						</div>
						<div class="col-sm-12 col-md-6">
							<label class="col-form-label">Electrical & Batteries</label>
							<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
						</div>
						<div class="col-sm-12 col-md-6">
							<label class="col-form-label">Hydraulics</label>
							<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
						</div>
						<div class="col-sm-12 col-md-6">
							<label class="col-form-label">Instruments</label>
							<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
						</div>
						<div class="col-sm-12 col-md-6">
							<label class="col-form-label">Brakes</label>
							<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
						</div>
						<div class="col-sm-12 col-md-6">
							<label class="col-form-label">Body Work</label>
							<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
						</div>
						<div class="col-sm-12 col-md-6">
							<label class="col-form-label">Steering</label>
							<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
						</div>
						<div class="col-sm-12 col-md-6">
							<label class="col-form-label">All Glass & Mirrors</label>
							<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
						</div>
						<div class="col-sm-12 col-md-6">
							<label class="col-form-label">Tracks Under Carriage / Tyres</label>
							<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
						</div>
					</div>
					<hr>
					<div class="row">
						<h4>Do you have?</h4>
						<div class="col-sm-3 col-md-3">
							<label class="col-form-label">A fire extinguisher</label>
							<div class="radio-custom radio-warning">
								<input type="radio" name="question1" id="optionsRadios1" value="yes"><label>Yes</label>
							</div>
							<div class="radio-custom radio-warning">
								<input type="radio" name="question1" id="optionsRadios2" value="no"><label>No</label>
							</div>
						</div>
						<div class="col-sm-3 col-md-3">
							<label class="col-form-label">A Jack</label>
							<div class="radio-custom radio-warning">
								<input type="radio" name="question2" id="optionsRadios1" value="yes"><label>Yes</label>
							</div>
							<div class="radio-custom radio-warning">
								<input type="radio" name="question2" id="optionsRadios2" value="no"><label>No</label>
							</div>
						</div>
						<div class="col-sm-3 col-md-3">
							<label class="col-form-label">A Wheel Spanner</label>
							<div class="radio-custom radio-warning">
								<input type="radio" name="question3" id="optionsRadios1" value="yes"><label>Yes</label>
							</div>
							<div class="radio-custom radio-warning">
								<input type="radio" name="question3" id="optionsRadios2" value="no"><label>No</label>
							</div>
						</div>
						<div class="col-sm-3 col-md-3">
							<label class="col-form-label">A Sparewheel</label>
							<div class="radio-custom radio-warning">
								<input type="radio" name="question4" id="optionsRadios1" value="yes"><label>Yes</label>
							</div>
							<div class="radio-custom radio-warning">
								<input type="radio" name="question4" id="optionsRadios2" value="no"><label>No</label>
							</div>
						</div>
						<div class="col-sm-3 col-md-3">
							<label class="col-form-label">A Triangle - Number</label>
							<input type="number" name="reg" placeholder="Triangle qty" class="form-control">
							<div class="radio-custom radio-warning">
								<input type="radio" name="question5" id="optionsRadios1" value="yes"><label>Yes</label>
							</div>
							<div class="radio-custom radio-warning">
								<input type="radio" name="question5" id="optionsRadios2" value="no"><label>No</label>
							</div>
						</div>
					</div>
				</div>
				<footer class="card-footer text-end">
					<button class="btn btn-primary">Add Defect Report</button>
					<button type="reset" class="btn btn-default">Reset</button>
				</footer>
			</section>
		</form>
	</div>
</div>