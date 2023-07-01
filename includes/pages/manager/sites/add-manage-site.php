<div class="row">
	<div class="col-sm-12 col-md-12 pb-sm-12 pb-md-0">
		<button href="#modalAddSite" class="mb-1 mt-1 mr-1 modal-sizes btn btn-primary">Create New Site</button>
		<div class="header-right">

			<div class="input-group">
				<input type="text" class="form-control" name="search" id="search" placeholder="Search Site...">
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
												type: 'sites',
												search: $('#search').val()
											},
											success:function (result) {
												$('#sites_list').html(result);
											},
											error: function (err) {}
										});
									});

									";
				?>

			</div>
		</div>
	</div>
	<!-- Modal Add Site -->
	<div id="modalAddSite" class="modal-block modal-block-lg mfp-hide">
		<form method="post" id="addsite">
			<section class="card">
				<header class="card-header">
					<h2 class="card-title">Add New Site</h2>
					<p class="card-subtitle">Add new site.</p>
				</header>
				<div class="card-body">
					<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
						<label class="col-form-label" for="formGroupExampleInput">Site No.</label>
						<input type="text" name="name" class="form-control" value="<?= $_POST['name'] ?>">
					</div>
				</div>
				<footer class="card-footer text-end">
					<button name='add_site' value='add_site' class="btn btn-primary">Add Site</button>
					<button class="btn btn-default modal-dismiss">Cancel</button>
				</footer>
			</section>
		</form>
	</div>
	<!-- Modal Add Site End -->

	<div class="col-lg-12 mb-12">
		<section class="card">
			<header class="card-header">
				<h2 class="card-title">Manage Site</h2>
			</header>
			<div class="card-body">
				<table width="1047" class="table table-responsive-md mb-0">
					<thead>
						<tr>
							<th width="200">Name.</th>
							<th width="25">Action</th>
						</tr>
					</thead>
					<tbody id="sites_list">
						<?php
						if ($_SESSION['user']['role'] == 'system') {
							$get_sites = dbq("select * from sites_tbl order by name");
						} else {
							$get_sites = dbq("select * from sites_tbl where active=1 order by name");
						}

						if ($get_sites) {
							if (dbr($get_sites) > 0) {
								while ($row = dbf($get_sites)) {
									include "includes/pages/manager/sites/list_sites.php";
								}
							} else {
								echo "<tr><td colspan='2'>No Sites</td></tr>";
							}
						} else {
							echo "<tr><td colspan='2'>Error reteiving sites</td></tr>";
						}

						$modal_form = "<div id='edit_site_modal'></div>";
						modal('modalEditSite', 'Edit Site', $modal_form, 'Save', 'save_site');

						$jscript_function .=	"
									function edit_site(id) {
										$.ajax({
											method:'post',
											url: 'includes/ajax.php',
											data: {
												cmd:'get_edit_site',
												id: id
											},
											success: function (result) {
												$('#edit_site_modal').html(result);
												$('#openModalEditSite').click();
											}
										});
									}
									";

						$modal_form = "<div id='del_site_modal'></div>";
						modal('modalDeleteSite', 'Delete Site', $modal_form, 'Confirm', 'del_site');

						$jscript_function .=	"
												function delete_site(id) {
													$.ajax({
														method:'post',
														url: 'includes/ajax.php',
														data: {
															cmd:'get_del_site',
															id: id
														},
														success: function (result) {
															$('#del_site_modal').html(result);
															$('#openModalDeleteSite').click();
														}
													});
												}
												";

						?>
					</tbody>
				</table>
				<a id='openModalEditSite' href='#modalEditSite' class='mb-1 mt-1 mr-1 modal-sizes'></a>
				<a id="openModalDeleteSite" class="mb-1 mt-1 mr-1 modal-basic" href="#modalDeleteSite"></a>
				<a id="openModalViewSite" class="mb-1 mt-1 mr-1 modal-basic" href="#modalViewSite"></a>
			</div>
		</section>
	</div>
</div>