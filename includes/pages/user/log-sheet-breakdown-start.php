<?php
unset($_SESSION['upload_images']);
$operator_ = dbf(dbq("select * from users_tbl where user_id={$plant_['operator_id']}"));




if (folders_('operator_log', $plant_['plant_id'])) {
	if ($log_ = get_operator_log($plant_['plant_id'], $plant_['operator_id'])) {
?>
		<div class="row">
			<?= inp('plant_id', '', 'hidden', $plant_['plant_id']) ?>
			<?= inp('log_id', '', 'hidden', $log_['log_id']) ?>
			<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Photos</label>
				<div class="col-sm-12 col-md-4 mt-2">
					<div class="input-group mb-3">
						<input id="file-bd" type="file" style="display:none">
						<input id="image-box-bd" type='text' class="form-control">
						<button id="image-btn-bd" type='button' class="input-group-text" id="basic-addon2"><i class="fa fa-image"></i></button>
					</div>
					<?php
					$jscript .= "
						$('#image-btn-bd').click(function (){ 
							$('#file-bd').click();

						});
						
						$('#image-box-bd').click(function (){ 
							$('#file-bd').click();

						});

						document.getElementById('file-bd').addEventListener('change', function () {
							var fileExtension = ['png', 'jpg','jpeg'];
							var extension = $('#file-bd').val().split('.').pop().toLowerCase();

							//console.log(`Extension :` + extension);

							if ($.inArray(extension, fileExtension) > -1) {
								ResizeImage(800,2048,2,'file-bd');
							}              
						});
						";
					?>
				</div>
			</div>

			<?php

			$get_clerks = dbq("select concat(name,' ',last_name) as name, user_id as value, out_of_office from users_tbl where role='clerk'");
			if ($get_clerks) {
				$clerk_select_[] = ['name' => 'Select One', 'value' => 0];
				if (dbr($get_clerks)) {
					while ($clerk = dbf($get_clerks)) {
						if ($clerk['out_of_office'] == 1) {
							$clerk_select_[] = ['name' => $clerk['name'] . " - Out of office", 'value' => $clerk['value']];
						} else {
							$clerk_select_[] = ['name' => $clerk['name'], 'value' => $clerk['value']];
						}
					}
				}

				echo "<div class='col-sm-12 col-md-4 pb-sm-3 pb-md-0'>" . inp('clerk_id', 'Clerk', 'select', '', '', 0, $clerk_select_) . "</div>";
			}
			?>
			<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Select Fault Area</label>
				<select class="form-control mb-3" id="fault_area" name="fault_area">
					<option value="">Select Fault Area</option>
					<option value="Engine">Engine</option>
					<option value="Clutch">Clutch</option>
					<option value="Gearbox/Drive Train">Gearbox/Drive Train</option>
					<option value="Axel + Suspension Rear">Axel + Suspension Rear</option>
					<option value="Axel + Suspension Front">Axel + Suspension Front</option>
					<option value="Brakes">Brakes</option>
					<option value="Cab + Accessories">Cab + Accessories</option>
					<option value="Electrical">Electrical</option>
					<option value="Hydrolics">Hydrolics</option>
					<option value="Structure">Structure</option>
					<option value="Other">Other / Comment</option>
				</select>
			</div>
			<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Breakdown Time From</label>
				<?= inp('start_datetime', '', 'hidden', date('Y-m-d H:i:s')) ?>
				<input type="datetime-local" name="fromtime" placeholder="" class="form-control" value="<?= date('Y-m-d\TH:i') ?>" disabled>
			</div>
			<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0 mb-2">
				<label class="col-form-label" for="formGroupExampleInput"><?= strtoupper($row['reading_type']) ?></label>
				<?= inp('reading_type', '', 'hidden', $row['reading_type']) ?>
				<input type="text" name="reading" placeholder="Reading" class="form-control">
			</div>
			<hr>
			<h2 class="card-title">Extras</h2><br>
			<div class="row">
				<?php
				$get_safety_equipment = dbq("select * from safety_equipment");
				if ($get_safety_equipment) {
					if (dbr($get_safety_equipment) > 0) {
						while ($equipment = dbf($get_safety_equipment)) {
				?>
							<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
								<div class="checkbox-custom checkbox-default">
									<input type="checkbox" id="<?= $equipment['code'] ?>" name="<?= $equipment['code'] ?>">
									<label for="<?= $equipment['code'] ?>"><?= $equipment['name'] ?></label>
								</div>
							</div>
				<?php
						}
					}
				}
				?>
			</div>
			<hr>
			<div class="col-sm-12 col-md-12">
				<label class="col-form-label" for="formGroupExampleInput">Comments</label>
				<textarea class="form-control" rows="3" id="comment" name="comment"></textarea>
				<br>
			</div>
			<footer class="text-end">
				<button name="start_breakdown" type="submit" class="btn btn-primary">Start Breakdown</button>
				<button type="reset" class="btn btn-default">Reset</button>
				<div id="image_list" class='mt-2 mb-2'></div>
			</footer>
		</div>
		<!--<div class="row">
	<div class="col-lg-6 mb-3">
		<form action="" id="addplant">
			<section class="card">
				<header class="card-header">
					<h2 class="card-title">Driver / Operator Log Sheet</h2>
				</header>
				<div class="card-body">
					
				</div>
				<footer class="card-footer text-end">
					<button class="btn btn-primary">Add Log </button>
					<button type="reset" class="btn btn-default">Reset</button>
				</footer>
			</section>
		</form>
	</div>
	 Events 
</div>-->
<?php
	}
}
