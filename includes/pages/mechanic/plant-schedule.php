<!-- Possitive Alert User Added -->
<div class="alert alert-success alert-dismissible fade show" role="alert">
	<strong>Well done!</strong> Daily Pre-Task Completed!
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close"></button>
</div>
<!-- Negative Alert Delete User-->
<div class="alert alert-danger alert-dismissible fade show" role="alert">
	<strong>Oh snap!</strong> something went wrong!
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close"></button>
</div>
<!-- Negative Alert End -->
<div class="row">
	<div class="col-xl-12">
		<form action="" id="mini_risk">
			<section class="card">
				<header class="card-header">
					<h2 class="card-title">Plant Service Schedule</h2>
				</header>
				<div class="card-body">
					<div class="row">
						<div class="col-sm-6 col-md-6 col-lg-6">
							<label class="col-form-label" for="formGroupExampleInput">Plant No.</label>
							<input type="text" name="plantnumber" placeholder="Plant No." class="form-control">
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6">
							<label class="col-form-label" for="formGroupExampleInput">Date</label>
							<input type="date" name="date" placeholder="" class="form-control">
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6">
							<label class="col-form-label" for="formGroupExampleInput">HRS/KM</label>
							<input type="text" name="hrs" placeholder="HRS/KM" class="form-control">
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6">
							<label class="col-form-label" for="formGroupExampleInput">Mechanic</label>
							<input type="text" name="mechanic" placeholder="Mechanic" class="form-control">
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6">
							<label class="col-form-label" for="formGroupExampleInput">Job Number</label>
							<input type="text" name="jobnumber" placeholder="Job Number" class="form-control">
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-sm-3 col-md-3 col-lg-3">
							<h4><strong>A:</strong> (A) Routine Oil Change</h4>
						</div>
						<div class="col-sm-3 col-md-3 col-lg-3">
							<h4><strong>B:</strong> (A+B) Minor Service</h4>
						</div>
						<div class="col-sm-3 col-md-3 col-lg-3">
							<h4><strong>C:</strong> (A+B+C) Major Service</h4>
						</div>
						<div class="col-sm-3 col-md-3 col-lg-3">
							<h4><strong>D:</strong> (A+B+C+D) Extended Major Service</h4>
						</div>
						<div class="col-sm-12 col-md-12 col-lg-12">
							<h4>Carry out all items where applicable: 0 - Compulsory | C - Check</h4>
						</div>
					</div>
					<hr>
					<div class="row">
						<table class="table table-responsive-md table-bordered mb-0 dark">
							<thead>
								<tr>
									<th width="500">Task</th>
									<th width="150">A</th>
									<th width="150">B</th>
									<th width="150">C/D</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><strong>Hours</strong></td>
									<td><strong>300</strong></td>
									<td><strong>600</strong></td>
									<td><strong>1200 / 2400</strong></td>
								</tr>
								<tr>
									<td><strong>Kilometres</strong></td>
									<td><strong>5000</strong></td>
									<td><strong>10000</strong></td>
									<td><strong>20000 / 40000</strong></td>
								</tr>
								<tr>
									<td><strong>Kilometres</strong></td>
									<td><strong>10000</strong></td>
									<td><strong>20000</strong></td>
									<td><strong>40000 / 80000</strong></td>
								</tr>
								<tr>
									<td><strong>Kilometres</strong></td>
									<td><strong>15000</strong></td>
									<td><strong>30000</strong></td>
									<td><strong>45000 / 60000</strong></td>
								</tr>
								<tr>
									<td>Change Engine Oil</td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Change Engine Oil Filter (Cut old, Inspect)</td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Reset Tappet Clearance Every <strong>(D)</strong></td>
									<td></td>
									<td></td>
									<td>0 <strong>(D)</strong> <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check Turbo Impellers and Function</td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check For Excessive Smoke and Bypass</td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Change Fuel Filters</td>
									<td></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Change and Clean Water Element</td>
									<td></td>
									<td></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Clean Every Service / Change Breathers When Necessary</td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Clean / Drain Sediment Feul Tank</td>
									<td></td>
									<td></td>
									<td>0 <strong>(C/D)</strong> <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check / Replace Fan Belts When Necessary</td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <strong>(D)</strong> <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check / Replace Water Hoses When Necessary</td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check / Replace Fuel / Oil / Air Lines If Required</td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check Repair Parking Brake</td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check / Repair Road Brakes / Compressor</td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Inspect / Tighten All Hose Clamps, Air Intake</td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Change Air Element Outer / Severe More Often</td>
									<td></td>
									<td></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Change Inner Air Element, Every <strong>(D)</strong></td>
									<td></td>
									<td></td>
									<td>0 <strong>(D)</strong> <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check Condition of Policeman and Pipe</td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Inspect / Tighten All Hose Clamps, Air Intake</td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Clean Radiator Core / Check Radiator Cap</td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Inspect Radiator Hoses, Tighten Clamps</td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Clean Radiator Core / Check Radiator Cap</td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check Grease Nipples and Grease</td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check Steering System, Repair if Faulty</td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check and Adjust Steering Clutches Dozer <strong>(C)</strong></td>
									<td></td>
									<td></td>
									<td>0 <strong>(C)</strong> <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check Universal Joints</td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check / Drain Diff Oils</td>
									<td><strong>C</strong> <input type="checkbox" id="checkboxExample4"></td>
									<td><strong>C</strong> <input type="checkbox" id="checkboxExample4"></td>
									<td><strong>C</strong> <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check Drain Transmission Oil</td>
									<td><strong>C</strong> <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <strong>(B)</strong> <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <strong>(C/D)</strong> <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Change Transmission Filter Every 600 Hours Cut</td>
									<td></td>
									<td>0 <strong>(B)</strong> <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <strong>(C/D)</strong> <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Clean Transmission Screens Every 600 Hours</td>
									<td></td>
									<td>0 <strong>(B)</strong> <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <strong>(C/D)</strong> <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check, Replace Worn Ball Joints</td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check / Drain Hydraulic Tank Oil (every 600hr)</td>
									<td><strong>C</strong> <input type="checkbox" id="checkboxExample4"></td>
									<td><strong>C</strong> <input type="checkbox" id="checkboxExample4"></td>
									<td><strong>C</strong> <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Change Hydraulic Filters (Cut Old, Inspect)</td>
									<td></td>
									<td></td>
									<td>0 <strong>(C/D)</strong> <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check Hydraulic Cylinders / Oil Leaks, Marks</td>
									<td><strong>C</strong> <input type="checkbox" id="checkboxExample4"></td>
									<td><strong>C</strong> <input type="checkbox" id="checkboxExample4"></td>
									<td><strong>C</strong> <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Inspect Electrical System, Repair if Faulty</td>
									<td><strong>C</strong> <input type="checkbox" id="checkboxExample4"></td>
									<td><strong>C</strong> <input type="checkbox" id="checkboxExample4"></td>
									<td><strong>C</strong> <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check Operation, All Gauges</td>
									<td><strong>C</strong> <input type="checkbox" id="checkboxExample4"></td>
									<td><strong>C</strong> <input type="checkbox" id="checkboxExample4"></td>
									<td><strong>C</strong> <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Clean / Check Battery Water 300 Hours</td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check Number Plate, Licence, Operator Card C.O.F</td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check Greasing System</td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check and Adjust Grader Circle Every 300 Hr</td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check Tandem Oil Condition</td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check Tandem Chain Condition</td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check and Adjust Track Tension</td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check Track Idler Frame Wear and Report</td>
									<td><strong>C</strong> <input type="checkbox" id="checkboxExample4"></td>
									<td><strong>C</strong> <input type="checkbox" id="checkboxExample4"></td>
									<td><strong>C</strong> <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check Air Pressure</td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check Repair All Oil, Diesel, Water Leaks</td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check Machine for Loose Bolts, Nuts, Cracks</td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check and Operate Machine for Normal Operation</td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check and Record All Oil Pressure Every <strong>(D)</strong></td>
									<td></td>
									<td></td>
									<td>0 <strong>(D)</strong> <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Change Antifreeze</td>
									<td><strong>C</strong> <input type="checkbox" id="checkboxExample4"></td>
									<td><strong>C</strong> <input type="checkbox" id="checkboxExample4"></td>
									<td><strong>C</strong> <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check and Drain Swing Motor Oil <strong>(D)</strong></td>
									<td><strong>C</strong> <input type="checkbox" id="checkboxExample4"></td>
									<td><strong>C</strong> <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <strong>(D)</strong> <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check and Drain Damper Case Oil <strong>(D)</strong></td>
									<td><strong>C</strong> <input type="checkbox" id="checkboxExample4"></td>
									<td><strong>C</strong> <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <strong>(D)</strong> <input type="checkbox" id="checkboxExample4"></td>
								</tr>
								<tr>
									<td>Check Swing Pinion Grease <strong>(D)</strong></td>
									<td><strong>C</strong> <input type="checkbox" id="checkboxExample4"></td>
									<td><strong>C</strong> <input type="checkbox" id="checkboxExample4"></td>
									<td>0 <strong>(D)</strong> <input type="checkbox" id="checkboxExample4"></td>
								</tr>
							</tbody>
						</table>
					</div>
					<br>
					<br>
					<div class="row">
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
						<div class="">
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
					<hr>
					<div class="row">
						<label class="col-form-label">Chech and Comment</label>
						<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
					</div>
				</div>
				<footer class="card-footer text-end">
					<button class="btn btn-primary">Submit Plant Service Schedule</button>
					<button type="reset" class="btn btn-default">Reset</button>
				</footer>
			</section>
		</form>
	</div>
</div>