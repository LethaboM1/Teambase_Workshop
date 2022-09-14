<div class="row">
	<div class="col-xl-12">
		<?php
		$get_jobcards = dbq("select * from jobcards where status='logged'");

		if ($get_jobcards) {
			if (dbr($get_jobcards) > 0) {

				$mechanic_select_[] = ['name' => 'Choose Mechanic', 'value' => '0'];
				$get_mechanics = dbq("select concat(name,' ',last_name) as name, user_id as value from users_tbl where role='mechanic' and active=1");
				if ($get_mechanics) {
					if (dbr($get_mechanics) > 0) {
						while ($mechanic = dbf($get_mechanics)) {
							$mechanic_select_[] = $mechanic;
						}
					}
				}

				while ($jobcard = dbf($get_jobcards)) {
					/* Get Stuff */
					$plant_ = dbf(dbq("select * from plants_tbl where plant_id={$jobcard['plant_id']}"));
					$logged_by_ = dbf(dbq("select concat(name,' ',last_name) as name from users_tbl where user_id={$jobcard['logged_by']}"));

					switch ($jobcard['priority']) {
						case "1":
							$status_color = "danger";
							break;

						default:
							$status_color = "warning";
							break;
					}
		?>

					<div class="col-md-12">
						<section class="card card-featured-left card-featured-<?= $status_color ?> mb-4">
							<div class="card-body">
								<div class="card-actions">
									<!-- Job Card Good -->
									<a class="mb-1 mt-1 mr-1 modal-sizes" href="#modalviewjob"><i class="fa-solid fa-eye fa-2x"></i></a>
									<!-- Modal view -->
									<div id="modalviewjob" class="modal-block modal-block-lg mfp-hide">
										<section class="card">
											<header class="card-header">
												<h2 class="card-title">View Job Card</h2>
											</header>
											<div class="card-body">
												<div class="modal-wrapper">
													<div class="modal-text">
														<p>Job Card info here...</p>

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
									<!-- Job Card End -->
									<!-- Assign Job Card -->
									<!-- Modal Assign -->
									<a class="mb-1 mt-1 mr-1 modal-sizes" href="#modalassign"><i class="fa-solid fa-handshake-angle fa-2x"></i></a>
									<div id="modalassign" class="modal-block modal-block-lg mfp-hide">
										<section class="card">
											<header class="card-header">
												<h2 class="card-title">Assign Job Card</h2>
											</header>
											<form method="post">
												<div class="card-body">
													<div class="row">
														<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
															<label class="col-form-label" for="formGroupExampleInput">Job Number</label>
															<input type="text" name="jobnumber" value="<?= $jobcard['job_id'] ?>" class="form-control" disabled>
														</div>
														<?= inp('job_id', '', 'hidden', $jobcard['job_id']) ?>
														<?= inp('mechanic', 'Select Mechanic', 'select', '', '', 0, $mechanic_select_) ?>
													</div>
												</div>
												<footer class="card-footer">
													<div class="row">
														<div class="col-md-12 text-right">
															<button type="submit" name="allocate_mechanic" class="btn btn-primary">Allocate</button>
															<button class="btn btn-default modal-dismiss">Cancel</button>
														</div>
													</div>
												</footer>
											</form>
										</section>
									</div>
									<!-- Assign Job Card End -->
								</div>
								<h2 class="card-title">Plant: <?= $plant_['reg_number'] ?></h2>
								<p class="card-subtitle">Opend by: <?= $logged_by_['name'] ?></p>
							</div>
						</section>
					</div>
		<?php
				}
			}
		}
