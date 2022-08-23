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
				<h2 class="card-title">Add New Job Card</h2>
				<p class="card-subtitle">Add new job card.</p>
			</header>
			<div class="card-body">
			<div class="row">
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Job Number</label>	
				<input type="text" name="jobnumber" placeholder="HG5452" class="form-control">
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Plant Number</label>	
				<input type="text" name="plantNumber" placeholder="HP5885" class="form-control">
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Date</label>	
				<input type="date" name="date" placeholder="" class="form-control">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">HR Reading</label>	
				<input type="text" name="hrreading" placeholder="HR Reading" class="form-control">
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">KM Reading</label>	
				<input type="text" name="kmreading" placeholder="KM Reading" class="form-control">
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Allocated Hours</label>	
				<input type="text" name="hours" placeholder="Allocated Hours" class="form-control">
				</div>
			</div>	
			<div class="row">
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Date Completed</label>	
				<input type="date" name="compDate" placeholder="Last Service Date" class="form-control">
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Vehicle Used to Site</label>	
				<input type="text" name="vehicleUsed" placeholder="Vehicle Used to Site" class="form-control">
				</div>	
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Open KM</label>	
				<input type="text" name="openKM" placeholder="Open KM" class="form-control">
				</div>
			</div>	
				<div class="row">
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Closing KM</label>	
				<input type="text" name="closingKM" placeholder="Closing KM" class="form-control">
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Total KM</label>	
				<input type="text" name="totalKM" placeholder="Total KM" class="form-control">
				</div>	
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Time Out</label>	
				<input type="text" name="timeOut" placeholder="Time Out" class="form-control">
				</div>
			</div>	
				<div class="row">
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Time In</label>	
				<input type="text" name="timeIn" placeholder="Time In" class="form-control">
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Travel Time</label>	
				<input type="text" name="travelTime" placeholder="Travel Time" class="form-control">
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
				<hr>
				<h2 class="card-title">Extras</h2><br>
				<div class="row">
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<div class="checkbox-custom checkbox-default">
					<input type="checkbox" id="sparewheele">
					<label for="checkboxExample1">Spare Wheele</label>
				</div>
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<div class="checkbox-custom checkbox-default">
					<input type="checkbox" id="wheelespanner">
					<label for="checkboxExample1">Wheele Spanner</label>
				</div>
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<div class="checkbox-custom checkbox-default">
					<input type="checkbox" id="jack">
					<label for="checkboxExample1">Jack</label>
				</div>
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<div class="checkbox-custom checkbox-default">
					<input type="checkbox" id="wheelespanner">
					<label for="checkboxExample1">Triangle</label>
				</div>
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<div class="checkbox-custom checkbox-default">
					<input type="checkbox" id="extinguisher">
					<label for="checkboxExample1">Fire Extinguisher</label>
				</div>
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<div class="checkbox-custom checkbox-default">
					<input type="checkbox" id="belt">
					<label for="checkboxExample1">Safety Belt</label>
				</div>
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<div class="checkbox-custom checkbox-default">
					<input type="checkbox" id="beacon">
					<label for="checkboxExample1">Rotating Beacon</label>
				</div>
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<div class="checkbox-custom checkbox-default">
					<input type="checkbox" id="blocks">
					<label for="checkboxExample1">Stop Blocks</label>
				</div>
				</div>
				</div>
				<hr>
				<h2 class="card-title">Events</h2><br>
				<div class="row">
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Date</label>	
				<input type="date" name="Date" placeholder="Date" class="form-control">
				</div>
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
					<label class="col-form-label" for="formGroupExampleInput">Select Event</label>
					<select class="form-control mb-3" id="roll">
					<option value="">Select a Event</option>
					<option value="Engine">Engine</option>
					<option value="Clutch">Clutch</option>
					<option value="Gearbox">Gearbox/Drive Train</option>
					<option value="Axlerear">Axel + Suspension Rear</option>
					<option value="Axlefront">Axel + Suspension Front</option>
					<option value="Brakes">Brakes</option>
					<option value="Cab">Cab + Accessories</option>
					<option value="Electrical">Electrical</option>
					<option value="Hydrolics">Hydrolics</option>	
					<option value="Structure">Structure</option>	
					</select>
				  </div>		
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Time Worked</label>	
				<input type="time" name="timeWorked" placeholder="Time Worked" class="form-control">
				</div>	
				<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Quality Check</label>	
				<input type="text" name="qualityCheck" placeholder="Quality Check" class="form-control">
				</div>
				<div class="col-sm-12 col-md-8 pb-sm-9 pb-md-0">	
				<label class="col-lg-3 control-label" for="Comment">Comment</label>
					<div class="col-lg-12">
					<textarea class="form-control" rows="3" id="Comment"></textarea>
					</div>	
				</div>
					<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
					 <button class="btn btn-primary">Add Event</button>
					</div>	
				</div>	
		  </div>
			<footer class="card-footer text-end">
				<button class="btn btn-primary">Create Job Card </button>
				<button type="reset" class="btn btn-default">Reset</button>
			</footer>			
		</section>
	</form>
</div>
<!-- Events -->
					<!-- Modal view -->
						<div id="modalviewevent" class="modal-block modal-block-lg mfp-hide">
								<section class="card">
								<header class="card-header">
								<h2 class="card-title">View Event</h2>
								</header>
								<div class="card-body">
								<div class="modal-wrapper">
								<div class="modal-text">
								<p>Event info here...</p>								
									
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
					<!-- Modal Delete -->
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
														<p>Are you sure that you want to delete this event?</p>
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
						<!-- Modal view -->
						<div id="modaleditspare" class="modal-block modal-block-lg mfp-hide">
								<section class="card">
								<header class="card-header">
								<h2 class="card-title">Edit Spares</h2>
								</header>
								<div class="card-body">
								<div class="modal-wrapper">
								<div class="modal-text">
								<p>Spare info here...</p>								
									
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
						<!-- Modal view -->
						<div id="modalviewspare" class="modal-block modal-block-lg mfp-hide">
								<section class="card">
								<header class="card-header">
								<h2 class="card-title">View Spares</h2>
								</header>
								<div class="card-body">
								<div class="modal-wrapper">
								<div class="modal-text">
								<p>spares info here...</p>								
									
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
						<!-- Modal view -->
						<div id="modalrequestspare" class="modal-block modal-block-lg mfp-hide">
								<section class="card">
								<header class="card-header">
								<h2 class="card-title">Spares Requisition BO</h2>
								</header>
								<div class="card-body">
								<div class="modal-wrapper">
								<div class="modal-text">
								<div class="row">
								<div class="col-sm-12 col-md-4">
									<label class="col-form-label">Plant #</label>	
									<input type="text" name="plantnumber" placeholder="plantnumber" class="form-control">
								</div>	
								<div class="col-sm-12 col-md-4">
									<label class="col-form-label">Date</label>	
									<input type="date" name="date" class="form-control">
								</div>
								<div class="col-sm-12 col-md-4">
									<label class="col-form-label">Site</label>	
									<input type="text" name="site" placeholder="site" class="form-control">
								</div>	
								<div class="col-sm-12 col-md-4">
									<label class="col-form-label">HRS</label>	
									<input type="text" name="HRS" placeholder="HRS" class="form-control">
								</div>	
								<div class="col-sm-12 col-md-4">
									<label class="col-form-label">KM</label>	
									<input type="text" name="KM" placeholder="KM" class="form-control">
								</div>
								<!-- Pull From Job Card -->	
								<div class="col-sm-12 col-md-4">
									<label class="col-form-label">Job Number</label>	
									<input type="text" name="jobnumber" placeholder="jobnumber" class="form-control">
								</div>		
								</div>
								<hr>	
								<div class="row">
								<div class="col-sm-3 col-md-3">
									<label class="col-form-label">QTY</label>	
									<input type="number" name="qty" placeholder="qty" class="form-control">
								</div>
								<div class="col-sm-3 col-md-3">
									<label class="col-form-label">Part Number</label>	
									<input type="text" name="partnumber" placeholder="Part Number" class="form-control">
								</div>	
								<div class="col-sm-6 col-md-6">
									<label class="col-form-label">Description</label>	
									<input type="text" name="description" placeholder="Description" class="form-control">
								</div>							
								</div>
								<div class="row">
								<div class="col-sm-12 col-md-12">
									<label class="col-form-label">Comment</label>	
									<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
								</div>
								<div class="col-sm-4 col-md-4"><br>
									<button type="button" class="btn btn-primary">Add Part</button>
								</div>
								</div>
								<hr>
								<div class="row">
									<p>Requested by: </p><br>
									<p>Approved by: </p><br>
									<p>BS REQ #: </p>
								</div>	
								</div>	
								</div>	
								</div>
								<footer class="card-footer">
								<div class="row">
								<div class="col-md-12 text-right">
								<button class="btn btn-default">Submit BO</button>	
								<button class="btn btn-default modal-dismiss">Cancel</button>
								</div>
								</div>
								</footer>	
								</section>
							</div>	
							<!-- Modal view End -->
	<div class="col-lg-6 mb-3">
	<section class="card">
		<header class="card-header">
			<h2 class="card-title">Events</h2>
		</header>
		<div class="card-body">
			<div class="header-right">
			<form action="#" class="search nav-form">
				<div class="input-group">
					<input type="text" class="form-control" name="q" id="q" placeholder="Search Event...">
					<button class="btn btn-default" type="submit"><i class="bx bx-search"></i></button>
				</div>
			</form>
			</div>	
			<table width="1047" class="table table-responsive-md mb-0">
				<thead>
					<tr>
						<th width="100">Date</th>
						<th width="100">Type</th>
						<th width="120">Time Worked</th>
						<th width="120">Quality Check</th>
						<th width="459">Comments</th>
						<th width="120">Action</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td class="actions">
							<!-- Modal Edit Event -->
							<a class="mb-1 mt-1 mr-1 modal-basic" href="#modalviewevent"><i class="fas fa-pencil-alt"></i></a>
							<!-- Modal Edit Event End -->
							<!-- Modal Delete -->
							<a class="mb-1 mt-1 mr-1 modal-basic" href="#modalHeaderColorDanger"><i class="far fa-trash-alt"></i></a>
							<!-- Modal Delete End -->
						</td>
					</tr>
				</tbody>
			</table>
	  </div>
	</section>

	<section class="card">
		<header class="card-header">
			<h2 class="card-title">Spares Requisition BO</h2>
		</header>
		<div class="card-body">
			<div class="header-right">
			<a class="mb-1 mt-1 mr-1 modal-basic" href="#modalrequestspare"><button class="btn btn-primary">Request Spares</button></a>
			</div>	
			<table width="1047" class="table table-responsive-md mb-0">
				<thead>
					<tr>
						<th width="100">Date</th>
						<th width="100">Type</th>
						<th width="120">Time Worked</th>
						<th width="120">Quality Check</th>
						<th width="459">Comments</th>
						<th width="120">Action</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td class="actions">
							<!-- Modal Edit Event -->
							<a class="mb-1 mt-1 mr-1 modal-basic" href="#modaleditspare"><i class="fas fa-pencil-alt"></i></a>
							<!-- Modal Edit Event End -->
							<!-- Modal Delete -->
							<a class="mb-1 mt-1 mr-1 modal-basic" href="#modalviewspare"><i class="fa-solid fa-eye"></i></a>
							<!-- Modal Delete End -->
						</td>
					</tr>
				</tbody>
			</table>
	  </div>
	</section>		
		
		
</div>	
</div>