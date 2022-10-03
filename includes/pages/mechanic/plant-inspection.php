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
	<div class="col-lg-12 mb-3">
		<form action="" id="inspection">
			<section class="card">
				<header class="card-header">
					<h2 class="card-title">Plant Inspection / Job Instruction Report</h2>
				</header>
				<div class="card-body">
					<div class="row">
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label">Client / Site</label>
							<input type="text" name="client" placeholder="Client / Site" class="form-control">
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label">Plant Number</label>
							<input type="text" name="plant" placeholder="Plant Number" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label">H.M.R</label>
							<input type="text" name="hmr" placeholder="H.M.R" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label">Component</label>
							<input type="text" name="component" placeholder="Component" class="form-control">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label">Severity</label>
							<select class="form-control mb-3" id="roll">
								<option value="">Select Severity</option>
								<option value="low">Low</option>
								<option value="Medium">Medium</option>
								<option value="High">High</option>
							</select>
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label">REQ HRS</label>
							<input type="text" name="component" placeholder="Component" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label">ALLOC HRS</label>
							<input type="text" name="component" placeholder="Component" class="form-control">
						</div>
					</div>
				</div>
				<footer class="card-footer text-end">
					<button class="btn btn-primary">Add Inspection / Report</button>
					<button type="reset" class="btn btn-default">Reset</button>
				</footer>
			</section>
		</form>
	</div>

	<div class="col-lg-12 mb-3">
		<form action="" id="inspection">
			<section class="card">
				<header class="card-header">
					<h2 class="card-title">Tyre Action Report</h2>
				</header>
				<div class="card-body">
					<div class="row">
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label">Position</label>
							<input type="text" name="position" placeholder="Position" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label">Tread (mm)</label>
							<input type="text" name="tread" placeholder="Tread (mm)" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label">Size</label>
							<input type="text" name="size" placeholder="Size" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label">Make</label>
							<input type="text" name="make" placeholder="Make" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label">Valve Cap</label>
							<input type="text" name="valve" placeholder="Valve Cap" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label">Valve Ext</label>
							<input type="text" name="valve2" placeholder="Valve Ext" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label">Virgin</label>
							<input type="text" name="virgin" placeholder="Virgin" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label">Retread</label>
							<input type="text" name="retread" placeholder="Retread" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label">Pressure</label>
							<input type="text" name="pressure" placeholder="Pressure" class="form-control">
						</div>
						<div class="col-sm-12 col-md-12">
							<label class="col-form-label">Notes</label>
							<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
							<br><br>
						</div>
						<div class="popup-gallery row">
							<div class="img-fluid col-lg-3 col-md-6 pb-sm-12">
								<img src="img/1.jpg" width="250" usemap="#Map">
								<map name="Map">
									<area shape="rect" coords="53,42,91,71" href="#">
									<area shape="rect" coords="163,40,201,72" href="#">
									<area shape="rect" coords="18,142,51,168" href="#">
									<area shape="rect" coords="55,143,89,168" href="#">
									<area shape="rect" coords="165,142,201,167" href="#">
									<area shape="rect" coords="206,144,240,167" href="#">
									<area shape="rect" coords="18,172,51,194" href="#">
									<area shape="rect" coords="57,172,89,195" href="#">
									<area shape="rect" coords="164,172,200,193" href="#">
									<area shape="rect" coords="204,173,238,194" href="#">
									<area shape="rect" coords="58,210,198,233" href="#">
								</map>
							</div>
							<div class="img-fluid col-lg-3 col-md-6 pb-sm-12">
								<img src="img/2.jpg" width="250" usemap="#Map2">
								<map name="Map2">
									<area shape="rect" coords="8,164,46,189" href="#">
									<area shape="rect" coords="52,166,87,188" href="#">
									<area shape="rect" coords="162,162,197,189" href="#">
									<area shape="rect" coords="206,164,239,190" href="#">
									<area shape="rect" coords="66,207,187,232" href="#">
								</map>
							</div>
							<div class="img-fluid col-lg-3 col-md-6 pb-sm-12">
								<img src="img/3.jpg" width="250" usemap="#Map3">
								<map name="Map3">
									<area shape="rect" coords="9,133,43,159" href="#">
									<area shape="rect" coords="55,133,80,160" href="#">
									<area shape="rect" coords="164,134,193,158" href="#">
									<area shape="rect" coords="210,135,238,162" href="#">
									<area shape="rect" coords="15,163,41,189" href="#">
									<area shape="rect" coords="55,166,87,187" href="#">
									<area shape="rect" coords="166,163,201,186" href="#">
									<area shape="rect" coords="211,166,239,186" href="#">
									<area shape="rect" coords="63,206,178,237" href="#">
								</map>
							</div>
							<div class="img-fluid col-lg-3 col-md-6 pb-sm-12">
								<img src="img/4.jpg" width="250" usemap="#Map4">
								<map name="Map4">
									<area shape="rect" coords="12,100,42,125" href="#">
									<area shape="rect" coords="61,100,79,126" href="#">
									<area shape="rect" coords="163,99,195,126" href="#">
									<area shape="rect" coords="206,101,243,123" href="#">
									<area shape="rect" coords="10,131,41,155" href="#">
									<area shape="rect" coords="57,131,84,153" href="#">
									<area shape="rect" coords="162,128,199,156" href="#">
									<area shape="rect" coords="207,129,241,152" href="#">
									<area shape="rect" coords="9,158,42,183" href="#">
									<area shape="rect" coords="52,160,87,184" href="#">
									<area shape="rect" coords="163,159,198,184" href="#">
									<area shape="rect" coords="208,161,240,185" href="#">
									<area shape="rect" coords="67,205,182,227" href="#">
								</map>
							</div>
							<div class="img-fluid col-lg-3 col-md-6 pb-sm-12">
								<img src="img/5.jpg" width="250" usemap="#Map5">
								<map name="Map5">
									<area shape="rect" coords="57,39,85,63" href="#">
									<area shape="rect" coords="160,39,198,67" href="#">
									<area shape="rect" coords="54,109,89,145" href="#">
									<area shape="rect" coords="157,111,193,143" href="#">
									<area shape="rect" coords="60,207,190,236" href="#">
								</map>
							</div>
						</div>
					</div>
				</div>
				<footer class="card-footer text-end">
					<button class="btn btn-primary">Add Tyre Action Report</button>
					<button type="reset" class="btn btn-default">Reset</button>
				</footer>
			</section>
		</form>
	</div>
</div>