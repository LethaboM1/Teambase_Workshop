<!doctype html>
<!-- Possitive Alert User Added -->
<div class="alert alert-success alert-dismissible fade show" role="alert">
	<strong>Well done!</strong> Checklist Completed!
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close"></button>
</div>
<!-- Negative Alert Delete User-->
<div class="alert alert-danger alert-dismissible fade show" role="alert">
	<strong>Oh snap!</strong> something went wrong!
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close"></button>
</div>
<!-- Negative Alert End -->
<div class="row">
	<div class="col-sm-12 col-md-6">
		<form action="" id="mini_risk">
			<section class="card">
				<header class="card-header">
				<h2 class="card-title">Checklist / Report</h2>
				</header>
				<div class="card-body">
					<!-- This section info pulls from Job Card -->
					<div class="row">
						<div class="col-sm-6 col-md-6 col-lg-6">
							<label class="col-form-label" for="formGroupExampleInput">Fleet No.</label>	
							<input type="text" name="fleet" placeholder="Fleet No." class="form-control">
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
							<label class="col-form-label" for="formGroupExampleInput">Driver</label>	
							<input type="text" name="driver" placeholder="Driver" class="form-control">
						</div>
					</div>	
					<hr>
						<!-- End Job Card info -->
					<div class="row">
					<table class="table table-responsive-md table-bordered mb-0 dark">
						<thead>
							<tr>
								<th width="600">Question</th>
								<th width="150">Answer</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Headlights & Taillights</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question1" id="optionsRadios1" value="yes" ><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question1" id="optionsRadios2" value="no" ><label>No</label>
									</div>
								</td>
							</tr>
							<tr>
								<td>Spotlights & Indicators</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question2" id="optionsRadios1" value="yes" ><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question2" id="optionsRadios2" value="no" ><label>No</label>
									</div>
								</td>
							</tr>
							<tr>
								<td>Tyres & Spare Wheel</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question3" id="optionsRadios1" value="yes" ><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question3" id="optionsRadios2" value="no" ><label>No</label>
									</div>
								</td>
							</tr>
							<tr>
								<td>Oil Leak</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question4" id="optionsRadios1" value="yes" ><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question4" id="optionsRadios2" value="no" ><label>No</label>
									</div>
								</td>
							</tr>
							<tr>
								<td>Drain Water Air Tank</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question5" id="optionsRadios1" value="yes" ><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question5" id="optionsRadios2" value="no" ><label>No</label>
									</div>
								</td>
							</tr>
							<tr>
								<td>Wipers</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question6" id="optionsRadios1" value="yes" ><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question6" id="optionsRadios2" value="no" ><label>No</label>
									</div>
								</td>
							</tr>
							<tr>
								<td>Hooter</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question7" id="optionsRadios1" value="yes" ><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question7" id="optionsRadios2" value="no" ><label>No</label>
									</div>
								</td>
							</tr>
							<tr>
								<td>Clutch & Brakes</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question8" id="optionsRadios1" value="yes" ><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question8" id="optionsRadios2" value="no" ><label>No</label>
									</div>
								</td>
							</tr>
							<tr>
								<td>Diesel Leaks</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question9" id="optionsRadios1" value="yes" ><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question9" id="optionsRadios2" value="no" ><label>No</label>
									</div>
								</td>
							</tr>
							<tr>
								<td>Licence & Operators Card</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question10" id="optionsRadios1" value="yes" ><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question10" id="optionsRadios2" value="no" ><label>No</label>
									</div>
								</td>
							</tr>
							<tr>
								<td>Number Plates, Chevron</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question11" id="optionsRadios1" value="yes" ><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question11" id="optionsRadios2" value="no" ><label>No</label>
									</div>
								</td>
							</tr>
							<tr>
								<td>Steering</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question12" id="optionsRadios1" value="yes" ><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question12" id="optionsRadios2" value="no" ><label>No</label>
									</div>
								</td>
							</tr>
							<tr>
								<td>Body Work & Doors</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question13" id="optionsRadios1" value="yes" ><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question13" id="optionsRadios2" value="no" ><label>No</label>
									</div>
								</td>
							</tr>
							<tr>
								<td>Windscreen & Door Windows</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question14" id="optionsRadios1" value="yes" ><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question14" id="optionsRadios2" value="no" ><label>No</label>
									</div>
								</td>
							</tr>
							<tr>
								<td>Fire Extinguisher Condition</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question15" id="optionsRadios1" value="yes" ><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question15" id="optionsRadios2" value="no" ><label>No</label>
									</div>
								</td>
							</tr>
							<tr>
								<td>Fork/Hoist Condition</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question16" id="optionsRadios1" value="yes" ><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question16" id="optionsRadios2" value="no" ><label>No</label>
									</div>
								</td>
							</tr>
							<tr>
								<td>Permits</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question17" id="optionsRadios1" value="yes" ><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question17" id="optionsRadios2" value="no" ><label>No</label>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
					</div>
					<div class="row">
						<label class="col-form-label">Other Comments</label>	
						<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
					</div>
			</div>
				<footer class="card-footer text-end">
					<button class="btn btn-primary">Submit Checklist</button>
					<button type="reset" class="btn btn-default">Reset</button>
				</footer>
			</section>	
		</form>	
		
	</div>
</div>