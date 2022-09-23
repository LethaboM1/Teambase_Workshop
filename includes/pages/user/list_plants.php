<?php
$plant_ = dbf(dbq("select * from plants_tbl where plant_id={$row['plant_id']}"));

switch ($plant_['status']) {
	case "ready":
		$color = "success";
		break;

	case "check":
		$color = "warning
		";
		break;

	case "busy":
		$color = "info";
		break;

	default:
		$color = "danger";
}

switch ($plant_['reading_type']) {
	case "km":
		$reading = $row['km_reading'];
		break;

	case "hr":
		$reading = $row['hr_reading'];
		break;
}

?>
<!-- Plant Card Good -->
<div class="col-md-12">
	<section class="card card-featured-left card-featured-<?= $color ?> mb-4">
		<div class="card-body">
			<div class="card-actions">
				<?php
				if ($row['operator_id'] == $_SESSION['user']['user_id'] && ($row['status'] == 'busy'  || $row['status'] == 'breakdown')) {
				?>
					&nbsp;&nbsp;&nbsp;<a class="mb-1 mt-1 mr-1 modal-sizes" href="#modalBreakdownPlant"><i title="Breakdown" class="fa-solid fa-wrench fa-2x text-danger"></i></a>
					<div id="modalBreakdownPlant" class="modal-block modal-block-lg mfp-hide">
						<section class="card">
							<header class="card-header">
								<h2 class="card-title">Driver / Operator Log Sheet</h2>
							</header>
							<div class="card-body">
								<div class="modal-wrapper">
									<div class="modal-text">
										<div class="row">
											<form method="post">
												<?php
												switch ($row['status']) {
													case "breakdown":
														require "./includes/pages/user/log-sheet-breakdown-end.php";
														break;

													default:
														require "./includes/pages/user/log-sheet-breakdown-start.php";
														break;
												}
												?>
											</form>
										</div>
									</div>
								</div>
							</div>
							<footer class="card-footer">
								<div class="row">
									<div class="col-md-12 text-right">
										<form method="post">
											<button class="btn btn-default modal-dismiss">Cancel</button>
										</form>
									</div>
								</div>
							</footer>
						</section>
					</div>
				<?php
				}

				//if ($row['status'] != 'breakdown') {

				?>
				&nbsp;&nbsp;&nbsp;<a class="mb-1 mt-1 mr-1 modal-sizes" href="#modalviewPlant">
					<?php
					switch ($row['status']) {
						case "busy":
							echo '<i title="Stop work" class="fa-regular fa-hand fa-2x"></i>';
							break;

						case "breakdown":
							echo '<i title="Stop work" class="fa-regular fa-hand fa-2x"></i>';
							break;
						default:
							echo '<i title="Start work"class="fa-regular fa-thumbs-up fa-2x"></i>';
							break;
					}
					?>

					<div id="modalviewPlant" class="modal-block modal-block-lg mfp-hide">
						<section class="card">
							<?php
							if ($row['operator_id'] == $_SESSION['user']['user_id']) {
							?>
								<header class="card-header">
									<h2 class="card-title">Driver / Operator Log Sheet</h2>
								</header>
								<div class="card-body">
									<div class="modal-wrapper">
										<div class="modal-text">
											<div class="row">
												<form method="post">
													<?php
													switch ($plant_['status']) {
														case "check":
															require "./includes/pages/user/log-sheet-start.php";
															break;

														case "busy":
															require "./includes/pages/user/log-sheet-end.php";
															break;

														case "breakdown":
															require "./includes/pages/user/log-sheet-end.php";
															break;
													}
													?>

												</form>
											</div>
										</div>
									</div>
								</div>
								<?php
							} else {
								if ($plant_['status'] == 'ready') {
								?>

									<header class="card-header">
										<h2 class="card-title">Allocate Plant</h2>
									</header>
									<div class="card-body">
										<div class="modal-wrapper">
											<div class="modal-text">
												<div class="row">
													<form method="post">
														<?php
														$plant_id = $row['plant_id'];
														require "./includes/pages/user/checklist.php";
														?>
													</form>
												</div>
											</div>
										</div>
									</div>
							<?php
								}
							}
							?>
							<footer class="card-footer">
								<div class="row">
									<div class="col-md-12 text-right">
										<form method="post">
											<button class="btn btn-default modal-dismiss">Cancel</button>
										</form>
									</div>
								</div>
							</footer>
						</section>
					</div>
					<?php
					//}
					?>
					<!-- Modal view End -->
					<!-- Plant Card End -->
			</div>
			<h2 class="card-title">Plant# <?= $row['reg_number'] ?></h2>
			<p class="card-subtitle">Status: <?= ucfirst($row['status']) ?></p>

		</div>
	</section>
</div>
<!-- Plant Card Good End -->

<?php

/* 


		<!-- Plant Card Causion -->
		<div class="col-md-12">
			<section class="card card-featured-left card-featured-warning mb-4">
				<div class="card-body">
					<div class="card-actions">
						<!-- View Plant Card -->
						<a class="mb-1 mt-1 mr-1 modal-sizes" href="#modalviewPlant2"><i class="fa-solid fa-eye"></i></a>
						<!-- Modal View -->
						<div id="modalviewPlant2" class="modal-block modal-block-lg mfp-hide">
							<section class="card">
								<header class="card-header">
									<h2 class="card-title">View Plant Card</h2>
								</header>
								<div class="card-body">
									<div class="modal-wrapper">
										<div class="modal-text">
											<p>Plant Card info here...</p>

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
						<!-- Modal View End -->
						<!-- View Plant Card End -->
					</div>
					<h2 class="card-title">Plant: HP56521</h2>
					<p class="card-subtitle">Opend by: Name</p>
					<div class="progress progress-xl progress-half-rounded m-2">
						<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;">20%</div>
					</div>
				</div>
			</section>
		</div>
		<!-- Plant Card causion -->
		<!-- Plant Card Danger -->
		<div class="col-md-12">
			<section class="card card-featured-left card-featured-danger mb-4">
				<div class="card-body">
					<div class="card-actions">
						<!-- View Plant Card -->
						<a class="mb-1 mt-1 mr-1 modal-sizes" href="#modalviewPlant3"><i class="fa-solid fa-eye"></i></a>
						<!-- Modal View -->
						<div id="modalviewPlant3" class="modal-block modal-block-lg mfp-hide">
							<section class="card">
								<header class="card-header">
									<h2 class="card-title">View Plant Card</h2>
								</header>
								<div class="card-body">
									<div class="modal-wrapper">
										<div class="modal-text">
											<p>Plant Card info here...</p>

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
						<!-- Modal View End -->
						<!-- View Plant Card End -->
					</div>
					<h2 class="card-title">Plant: HP56521</h2>
					<p class="card-subtitle">Opend by: Name</p>
					<div class="progress progress-xl progress-half-rounded m-2">
						<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">80%</div>
					</div>
				</div>
			</section>
		</div>
		<!-- Plant Card Danger -->
*/