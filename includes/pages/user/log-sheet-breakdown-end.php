<?php
unset($_SESSION['upload_images']);
$operator_ = dbf(dbq("select * from users_tbl where user_id={$plant_['operator_id']}"));




if (folders_('operator_log', $plant_['plant_id'])) {
	if ($log_ = get_operator_log($plant_['plant_id'], $plant_['operator_id'])) {
?>
		<div class="row">
			<?= inp('plant_id', '', 'hidden', $plant_['plant_id']) ?>

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
			<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				&nbsp;
			</div>
			<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
				<label class="col-form-label" for="formGroupExampleInput">Breakdown Time To</label>
				<input type="datetime-local" name="totime" placeholder="" class="form-control" value="<?= date('Y-m-d\TH:i') ?>">
			</div>
			<div class=" col-sm-12 col-md-12">
				<label class="col-form-label" for="formGroupExampleInput">Comments</label>
				<textarea class="form-control" rows="3" id="Comment"></textarea>
				<br>
			</div>
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
