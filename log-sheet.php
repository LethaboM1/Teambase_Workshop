<!doctype html>
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
	<form action="" id="addplant">
		<section class="card">
			<header class="card-header">
				<h2 class="card-title">Driver / Operator Log Sheet</h2>
			</header>
			<div class="card-body">
			<div class="row">
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Drivers Name</label>	
				<input type="text" name="driversname" placeholder="Drivers Name" class="form-control">
				</div>	
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Company No.</label>	
				<input type="text" name="company" placeholder="Company #" class="form-control">
				</div>	
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Fleet No.</label>	
				<input type="text" name="fleet" placeholder="Fleet No." class="form-control">
				</div>	
			</div>	
			<hr>	
			<div class="row">
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Date</label>	
				<input type="date" name="date" placeholder="" class="form-control">
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Site Number</label>	
				<input type="text" name="sitenumber" placeholder="Site Number" class="form-control">
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Start Time</label>	
				<input type="time" name="starttime" placeholder="" class="form-control">
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">End Time</label>	
				<input type="time" name="endtime" placeholder="" class="form-control">
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Start KM/HR Reading</label>	
				<input type="text" name="starthr" placeholder="Start KM/HR Reading" class="form-control">
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Start KM/HR Photo</label>	
				<div class="col-lg-12">
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
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">End KM/HR Reading</label>	
				<input type="text" name="endhr" placeholder="End KM/HR Reading" class="form-control">
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">End KM/HR Photo</label>	
				<div class="col-lg-12">
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
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Fuel Liters Issued</label>	
				<input type="text" name="fuel" placeholder="Liters" class="form-control">
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Breakdown Time From</label>	
				<input type="time" name="fromtime" placeholder="" class="form-control">
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Breakdown Time To</label>	
				<input type="time" name="totime" placeholder="" class="form-control">
				</div>
				<div class="col-sm-12 col-md-12">
				<label class="col-form-label" for="formGroupExampleInput">Reason For Breakdown / Other Remarks</label>	
				<textarea class="form-control" rows="3" id="Comment"></textarea>
				<br>
				</div>
			</div>		
		  </div>
			<footer class="card-footer text-end">
				<button class="btn btn-primary">Add Log </button>
				<button type="reset" class="btn btn-default">Reset</button>
			</footer>			
		</section>
	</form>
</div>
<!-- Events -->	
</div>