<div class="row">
	<div class="col-sm-12 col-md-12 pb-sm-12 pb-md-0">
		<button href="#modalAddPlant" class="mb-1 mt-1 mr-1 modal-sizes btn btn-primary">Create New Plant</button>
		<div class="header-right">

			<div class="input-group">
				<input type="text" class="form-control" name="search" id="search" placeholder="Search Plant...">
				<button class="btn btn-default" id='searchBtn' type="button"><i class="bx bx-search"></i></button>
				<?php
				$jscript .= "
									
									$('#search').keyup(function (e) {
										if (e.key=='Enter') {
											$('#searchBtn').click();
										}
						
						
										if (e.key=='Backspace') {
											if ($('#search').val().length==0) {
												$('#resetOpenBtn').click();
											}
										}
									});
						
									$('#searchBtn').click(function () {
										$.ajax({
											method:'post',
											url:'includes/ajax.php',
											data: {
												cmd:'search',
												type: 'plants',
												search: $('#search').val()
											},
											success:function (result) {
												$('#plants_list').html(result);
											},
											error: function (err) {}
										});
									});

									";
				?>

			</div>
		</div>
	</div>
	<!-- Modal Add Plant -->
	<div id="modalAddPlant" class="modal-block modal-block-lg mfp-hide">
		<form method="post" id="addplant">
			<section class="card">
				<header class="card-header">
					<h2 class="card-title">Add New Plant</h2>
					<p class="card-subtitle">Add new plant.</p>
				</header>
				<div class="card-body">
					<div class="row">
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Plant No.</label>
							<input type="text" name="plant_number" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Vehicle Type</label>
							<input type="text" name="vehicle_type" placeholder="Truck, TLB ..." class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Make</label>
							<input type="text" name="make" placeholder="Make" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Model</label>
							<input type="text" name="model" placeholder="Model" class="form-control">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Registration Number</label>
							<input type="text" name="reg_number" placeholder="AAA-456-L" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">VIN Number</label>
							<input type="text" name="vin_number" placeholder="VIN Number" class="form-control">
						</div>
						<?php
						$reading_types_select_ = [
							['name' => 'KM - Kilometers', 'value' => 'km'],
							['name' => 'HR - Hours', 'value' => 'hr'],
						];
						echo inp('reading_type', 'Type of reading', 'select', '', '', 0, $reading_types_select_);
						?>
					</div>
					<div class="row">
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Reading</label>
							<input type="text" name="reading" placeholder="Reading" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Last Service Date</label>
							<input type="date" name="last_service" placeholder="Last Service Date" class="form-control">
						</div>
						<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
							<label class="col-form-label" for="formGroupExampleInput">Next Service Date</label>
							<input type="date" name="next_service" placeholder="Next Service Date" class="form-control">
						</div>
					</div>
				</div>
				<footer class="card-footer text-end">
					<button name='add_plant' value='add_plant' class="btn btn-primary">Add Plant</button>
					<button class="btn btn-default modal-dismiss">Cancel</button>
				</footer>
			</section>
		</form>
	</div>
	<!-- Modal Add Plant End -->

	<div class="col-lg-12 mb-12">
		<section class="card">
			<header class="card-header">
				<h2 class="card-title">Manage Plant</h2>
			</header>
			<div class="card-body">
				<table width="1047" class="table table-responsive-md mb-0">
					<thead>
						<tr>
							<th width="200">Plant No.</th>
							<th width="200">Make</th>
							<th width="200">Registration Number</th>
							<th width="120">Reading</th>
							<th width="150">Last Service Date</th>
							<th width="150">Next Service Date</th>
							<th width="25">Action</th>
						</tr>
					</thead>
					<tbody id="plants_list">
						<?php

						$get_plants = dbq("select * from plants_tbl order by reg_number");

						if ($get_plants) {
							if (dbr($get_plants) > 0) {
								while ($row = dbf($get_plants)) {
									include "includes/pages/manager/plants/list_plants.php";
								}
							} else {
								echo "<tr><td colspan='8'>No Plants</td></tr>";
							}
						} else {
							echo "<tr><td colspan='8'>Error reteiving plants</td></tr>";
						}

						$modal_form = "<div id='edit_plant_modal'></div>";
						modal('modalEditPlant', 'Edit Plant', $modal_form, 'Save', 'save_plant');

						$jscript_function .=	"
									function edit_plant(plant_id) {
										$.ajax({
											method:'post',
											url: 'includes/ajax.php',
											data: {
												cmd:'get_edit_plant',
												plant_id: plant_id
											},
											success: function (result) {
												$('#edit_plant_modal').html(result);
												$('#openModalEditPlant').click();
											}
										});
									}
									";

						$modal_form = "<div id='del_plant_modal'></div>";
						modal('modalDeletePlant', 'Delete Plant', $modal_form, 'Confirm', 'del_plant');

						$jscript_function .=	"
												function delete_plant(plant_id) {
													$.ajax({
														method:'post',
														url: 'includes/ajax.php',
														data: {
															cmd:'get_del_plant',
															plant_id: plant_id
														},
														success: function (result) {
															$('#del_plant_modal').html(result);
															$('#openModalDeletePlant').click();
														}
													});
												}
												";

						?>
					</tbody>
				</table>
				<a id='openModalEditPlant' href='#modalEditPlant' class='mb-1 mt-1 mr-1 modal-sizes'></a>
				<a id="openModalDeletePlant" class="mb-1 mt-1 mr-1 modal-basic" href="#modalDeletePlant"></a>
				<a id="openModalViewPlant" class="mb-1 mt-1 mr-1 modal-basic" href="#modalViewPlant"></a>
			</div>
		</section>
	</div>
</div>