<?php
unset($_SESSION['upload_images']);
$operator_ = dbf(dbq("select * from users_tbl where user_id={$plant_['operator_id']}"));




if (folders_('operator_log', $plant_['plant_id'])) {
	if ($log_ = get_operator_log($plant_['plant_id'], $plant_['operator_id'])) {
?>
		<div class="row">
			<?= inp('log_id', '', 'hidden', $log_['log_id']) ?>
			<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Drivers Name</label>
				<input type="text" value="<?= $operator_['name'] . ' ' . $operator_['last_name'] ?>" name="driversname" placeholder="Drivers Name" class="form-control" disabled>
			</div>
			<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Company No.</label>
				<input type="text" name="company" placeholder="Company #" class="form-control" value="<?= $operator_['company_number'] ?>" disabled>
			</div>
			<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Plant.</label>
				<input type="text" value="<?= $plant_['plant_number'] . (strlen($plant_['reg_number']) > 0 ? " - {$plant_['reg_number']}" : "") ?>" name="fleet" placeholder="Plant no." class="form-control" disabled>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Site</label>
				<input type="text" name="site" placeholder="Site" class="form-control" value="<?= $log_['site'] ?>" disabled>
			</div>
			<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">End Date</label>
				<input type="date" name="enddate" placeholder="" class="form-control" value="<?= date('Y-m-d') ?>" disabled>
			</div>
			<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">End Time</label>
				<?= inp('end_datetime', '', 'hidden', date('Y-m-d H:i:s')) ?>
				<input type="time" name="endtime" placeholder="" class="form-control" value="<?= date('H:i') ?>" disabled>
			</div>
			<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<?= inp('reading_type', '', 'hidden', $plant_['reading_type']) ?>
				<label class="col-form-label" for="formGroupExampleInput">(<?= strtoupper($plant_['reading_type']) ?>) Reading - Current (<?= $plant_[$plant_['reading_type'] . '_reading'] ?>)</label>
				<input type="text" name="reading" placeholder="Reading" class="form-control">
			</div>
			<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Photos</label>
				<div class="col-sm-12 col-md-4 mt-2">
					<div class="input-group mb-3">
						<input id="file" type="file" style="display:none">
						<input id="image-box" type='text' class="form-control">
						<button id="image-btn" type='button' class="input-group-text" id="basic-addon2"><i class="fa fa-image"></i></button>
					</div>
					<?php
					$jscript .= "
						$('#image-btn').click(function (){ 
							$('#file').click();

						});

						$('#image-box').click(function (){ 
							$('#file').click();

						});

						document.getElementById('file').addEventListener('change', function () {
							var fileExtension = ['png', 'jpg','jpeg'];
							var extension = $('#file').val().split('.').pop().toLowerCase();

							//console.log(`Extension :` + extension);

							if ($.inArray(extension, fileExtension) > -1) {
								ResizeImage(800,2048,2);
							}              
						});
						";
					?>
				</div>
			</div>
			<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				&nbsp;
			</div>
			<footer class="text-end">
				<button name="end_log" type="submit" class="btn btn-primary">End</button>
				<button type="reset" class="btn btn-default">Reset</button>
				<div id="image_list" class='mt-2 mb-2'><?php
														if (is_array($_SESSION['upload_images']) && count($_SESSION['upload_images']) > 0) {
															echo "<div class='row'>";
															foreach ($_SESSION['upload_images'] as $key => $image) {

																echo "<div class='col-md-3'>
									<i onclick='remImage(`{$key}`)' class='fa fa-times fa-2x removeX'></i>
									<img width='200px' src='{$image['image']}' /></div>";
															}
															echo    "</div>";
														}
														?></div>
			</footer>
		</div>
<?php
	}
}
