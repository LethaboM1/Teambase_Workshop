<!doctype html>
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
				<h2 class="card-title">Daily Pre-Task Mini Risk Assessment</h2>
				</header>
				<div class="card-body">
					<!-- This section info pulls from Job Card -->
					<div class="row">
						<div class="col-sm-6 col-md-6 col-lg-6">
							<label class="col-form-label" for="formGroupExampleInput">Date</label>	
							<input type="date" name="date" placeholder="" class="form-control">
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6">
							<label class="col-form-label" for="formGroupExampleInput">Project Name & No.</label>	
							<input type="text" name="projectname" placeholder="Project Name & No." class="form-control">
						</div>
					</div>	
					<div class="row">
						<div class="col-sm-6 col-md-6 col-lg-6">
							<label class="col-form-label" for="formGroupExampleInput">Supervisor</label>	
							<input type="text" name="supervisor" placeholder="Supervisor" class="form-control">
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6">
							<label class="col-form-label" for="formGroupExampleInput">Task/Job No.</label>	
							<input type="text" name="jobnumber" placeholder="Task/Job No." class="form-control">
						</div>
					</div>	
					<div class="row">
						<div class="col-sm-6 col-md-6 col-lg-6">
							<label class="col-form-label" for="formGroupExampleInput">Plant No.</label>	
							<input type="text" name="plantnumber" placeholder="Plant No." class="form-control">
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6">
							<label class="col-form-label" for="formGroupExampleInput">Last time task was performed</label>	
							<input type="date" name="taskdate" placeholder="Last time task was performed" class="form-control">
						</div>
					</div>	
					<hr>
						<!-- End Job Card info -->
					
					
					<div class="row">
					<table class="table table-responsive-md table-bordered mb-0 dark">
						<thead>
							<tr>
								<th width="10">#</th>
								<th width="480">Question</th>
								<th width="150">Answer</th>
								<th width="400">Comments</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>Has the full HIRA & SWP been conveyed to all workers performing the task?</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question1" id="optionsRadios1" value="yes" ><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question1" id="optionsRadios2" value="no" ><label>No</label>
									</div>
								</td>
								<td>
									<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
								</td>
							</tr>
							<tr>
								<td>2</td>
								<td>Have all the workers signed the attendance register for the above?</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question2" id="optionsRadios1" value="yes"><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question2" id="optionsRadios2" value="no"><label>No</label>
									</div>
								</td>
								<td>
									<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
								</td>
							</tr>
							<tr>
								<td>3</td>
								<td>Are all workers wearing and/or using the correct PPE required for the task?</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question3" id="optionsRadios1" value="yes"><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question3" id="optionsRadios2" value="no"><label>No</label>
									</div>
								</td>
								<td>
									<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
								</td>
							</tr>
							<tr>
								<td>4</td>
								<td>Is the PPE, as above, in good condition and being used correctly?</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question4" id="optionsRadios1" value="yes"><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question4" id="optionsRadios2" value="no"><label>No</label>
									</div>
								</td>
								<td>
									<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
								</td>
							</tr>
							<tr>
								<td>5</td>
								<td>Are all the required tools and equipment for the task present?</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question5" id="optionsRadios1" value="yes"><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question5" id="optionsRadios2" value="no"><label>No</label>
									</div>
								</td>
								<td>
									<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
								</td>
							</tr>
							<tr>
								<td>6</td>
								<td>Are all the tools and equipment, as above, in good condition and inspected?</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question6" id="optionsRadios1" value="yes"><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question6" id="optionsRadios2" value="no"><label>No</label>
									</div>
								</td>
								<td>
									<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
								</td>
							</tr>
							<tr>
								<td>7</td>
								<td>Have climatic conditions (hot, cold, rain, lightning) been prepared for?</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question7" id="optionsRadios1" value="yes"><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question7" id="optionsRadios2" value="no"><label>No</label>
									</div>
								</td>
								<td>
									<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
								</td>
							</tr>
							<tr>
								<td>8</td>
								<td>Is the work place clear of any slip, trip and fall hazards?</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question8" id="optionsRadios1" value="yes"><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question8" id="optionsRadios2" value="no"><label>No</label>
									</div>
								</td>
								<td>
									<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
								</td>
							</tr>
							<tr>
								<td>9</td>
								<td>Are the workers physically and mentally fit to perform the task?</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question9" id="optionsRadios1" value="yes"><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question9" id="optionsRadios2" value="no"><label>No</label>
									</div>
								</td>
								<td>
									<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
								</td>
							</tr>
							<tr>
								<td>10</td>
								<td>Can the workers strain or overexert themselves?</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question10" id="optionsRadios1" value="yes"><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question10" id="optionsRadios2" value="no"><label>No</label>
									</div>
								</td>
								<td>
									<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
								</td>
							</tr>
							<tr>
								<td>11</td>
								<td>Can the workers, or ant part of the body, be caught in or between anything?</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question11" id="optionsRadios1" value="yes"><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question11" id="optionsRadios2" value="no"><label>No</label>
									</div>
								</td>
								<td>
									<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
								</td>
							</tr>
							<tr>
								<td>12</td>
								<td>Can the workers fall from a height of 2m or higher?</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question12" id="optionsRadios1" value="yes"><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question12" id="optionsRadios2" value="no"><label>No</label>
									</div>
								</td>
								<td>
									<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
								</td>
							</tr>
							<tr>
								<td>13</td>
								<td>Can the workers be engulfed in an excavation of 1m or deeper?</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question13" id="optionsRadios1" value="yes"><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question13" id="optionsRadios2" value="no"><label>No</label>
									</div>
								</td>
								<td>
									<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
								</td>
							</tr>
							<tr>
								<td>14</td>
								<td>Can the workers hurt other workers whilst performing the task?</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question14" id="optionsRadios1" value="yes"><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question14" id="optionsRadios2" value="no"><label>No</label>
									</div>
								</td>
								<td>
									<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
								</td>
							</tr>
							<tr>
								<td>15</td>
								<td>Can the workers be burnt?</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question15" id="optionsRadios1" value="yes"><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question15" id="optionsRadios2" value="no"><label>No</label>
									</div>
								</td>
								<td>
									<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
								</td>
							</tr>
							<tr>
								<td>16</td>
								<td>Is there any dust, fumes or gas present?</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question16" id="optionsRadios1" value="yes"><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question16" id="optionsRadios2" value="no"><label>No</label>
									</div>
								</td>
								<td>
									<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
								</td>
							</tr>
							<tr>
								<td>17</td>
								<td>Is there anything that can fall onto the workers?</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question17" id="optionsRadios1" value="yes"><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question17" id="optionsRadios2" value="no"><label>No</label>
									</div>
								</td>
								<td>
									<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
								</td>
							</tr>
							<tr>
								<td>18</td>
								<td>Is there a pressurised system that can hurt workers?</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question18" id="optionsRadios1" value="yes"><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question18" id="optionsRadios2" value="no"><label>No</label>
									</div>
								</td>
								<td>
									<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
								</td>
							</tr>
							<tr>
								<td>19</td>
								<td>Is there any risk of fire (any flammable substance) in the area?</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question19" id="optionsRadios1" value="yes"><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question19" id="optionsRadios2" value="no"><label>No</label>
									</div>
								</td>
								<td>
									<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
								</td>
							</tr>
							<tr>
								<td>20</td>
								<td>Is there any danger of electrocution?</td>
								<td>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question20" id="optionsRadios1" value="yes"><label>Yes</label>
									</div>
									<div class="radio-custom radio-warning">
										<input type="radio" name="question20" id="optionsRadios2" value="no"><label>No</label>
									</div>
								</td>
								<td>
									<textarea class="form-control" rows="3" id="textareaDefault"></textarea>
								</td>
							</tr>
						</tbody>
					</table>
					</div>
					<br>
					<br>
					<div class="row">
					<p><strong>1 to 9 - if NO, Rectify.</strong><br>
					<strong>10 to 20 - if YES, mitigate by first using engineering methods before resorting to PPE</strong></p>
					</div>
					<hr>
					<div class="row">
					<h3>Team members performing task</h3>
					<p>I, the undersigned, confirm and acknowledge that I haave been involved with the HIRA and am aware of all hazards and risks associated with the task and undertake to follow the Safe Work Procedure, I aslo understand that my Safty is my own responsibility and that I must at all times report unsafe conditions.</p>	
					</div>
					<div class="row">
						<div class="col-sm-3 col-md-3 col-lg-3">
							<label class="col-form-label" for="formGroupExampleInput">Name & Company Number</label>	
							<input type="text" name="projectname" placeholder="Name & Company Number" class="form-control">
						</div>
					</div>
					<br>
					<!-- Modal Add Team -->
					<div id="modalUserSign" class="modal-block modal-block-lg mfp-hide">
						<form action="" id="adduser">
							<section class="card">
								<header class="card-header">
									<h2 class="card-title">Add Member Signature</h2>
									<p class="card-subtitle">New member signs here</p>
								</header>
								<div class="card-body">
									<div class="row">
									<p>Sign here</p>
									</div>
								</div>
								<footer class="card-footer text-end">
									<button class="btn btn-primary">Submit</button>
									<button class="btn btn-default modal-dismiss">Cancel</button>
								</footer>			
							</section>
						</form>
					</div>
					<!-- Modal add team End -->	
					<div class="row">
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<button href="#modalUserSign" class="mb-1 mt-1 mr-1 modal-sizes btn btn-primary">Add Team Member</button>
						</div>
						<div class="col-sm-5 col-md-5 col-lg-5">
							<label><input type="checkbox" id="checkboxExample4"> Confirm above stament.</label>
						</div>	
					</div>		
					</div>
					<br>
				<footer class="card-footer text-end">
					<button class="btn btn-primary">Submit Mini Risk Assessment</button>
					<button type="reset" class="btn btn-default">Reset</button>
				</footer>
			</section>	
		</form>	
		
	</div>
</div>