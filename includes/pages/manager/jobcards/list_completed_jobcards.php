<?php

$color = "success";

$logged_by = dbf(dbq("select concat(name,' ', last_name) as name from users_tbl where user_id={$row['logged_by']}"));
$mechanic_ = dbf(dbq("select concat(name,' ', last_name) as name from users_tbl where user_id={$row['mechanic_id']}"));
$plant_ = dbf(dbq("select * from plants_tbl where plant_id={$row['plant_id']}"));
switch ($plant_['reading_type']) {
    case "km":
        $reading = $row['km_reading'];
        break;

    case "hr":
        $reading = $row['hr_reading'];
        break;
}


$progress = 100;

?>
<!-- Job Card Good -->
<div class="col-md-12">

    <section class="card card-featured-left card-featured-<?= $color ?> mb-4">
        <a class="modal-sizes" href="#modalviewjob_<?= $row['job_id'] ?>">
            <div class="card-body">
                <div class="card-actions">
                    <!-- Job Card Good -->
                    <i class="fa-solid fa-eye"></i>
                    <!-- Modal view -->
                    <div id="modalviewjob_<?= $row['job_id'] ?>" class="modal-block modal-block-lg mfp-hide">
                        <section class="card">
                            <header class="card-header">
                                <h2 class="card-title">View Job Card</h2>
                            </header>
                            <div class="card-body">
                                <div class="modal-wrapper">
                                    <div class="modal-text">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <b>Job No.</b>&nbsp;<?= $row['jobcard_number'] ?><br>
                                                <b>Date logged.</b>&nbsp;<?= $row['job_date'] ?><br>
                                                <b>Plant No.</b>&nbsp;<?= $plant_['plant_number'] ?><br>
                                                <b>Type.</b>&nbsp;<?= $plant_['vehicle_type'] ?><br>
                                                <b>Model.</b>&nbsp;<?= $plant_['model'] ?><br>
                                                <b>Mechanic.</b>&nbsp;<?= $mechanic_['name'] ?><br>
                                                <b>Hour Spend.</b>&nbsp;<?= $worked['hours'] ?><br>
                                            </div>
                                            <div class="col-md-6">
                                                <b>Plant.</b>&nbsp;<?= $plant_['reg_number'] ?><br>
                                                <b>Logged by.</b>&nbsp;<?= $logged_by['name'] ?><br>
                                                <b>Make.</b>&nbsp;<?= $plant_['make'] ?><br>
                                                <b>Reading (<?= strtoupper($plant_['reading_type']) ?>).</b>&nbsp;<?= $reading ?><br>
                                                <b>Allocated Hrs.</b>&nbsp;<?= $row['allocated_hours'] ?><br>
                                                <b>Progress.</b>&nbsp;<?= $progress ?>%<br>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <table class="table table-responsive">
                                                <thead>
                                                    <tr>
                                                        <th width="100">Date</th>
                                                        <th width="100">Type</th>
                                                        <th width="120">Time Worked</th>
                                                        <th width="459">Comments</th>
                                                        <th width="120">Action</th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                $get_events = dbq("select * from jobcard_events where job_id={$row['job_id']}");
                                                if ($get_events) {
                                                    if (dbr($get_events) > 0) {
                                                        while ($event = dbf($get_events)) {
                                                ?><tr>
                                                                <td><?= $event['start_datetime'] ?></td>
                                                                <td><?= $event['event'] ?></td>
                                                                <td><?= $event['total_hours'] ?></td>
                                                                <td><?= $event['comment'] ?></td>
                                                                <td class="actions">
                                                                    <!--<a class="mb-1 mt-1 mr-1 modal-basic" href="#modalViewEvent_<?= $event['event_id'] ?>"><i class="fas fa-pencil-alt"></i></a>
                                                                    Modal Edit Event End -->
                                                                    <!-- Modal Delete 
                                                                    <a class="mb-1 mt-1 mr-1 modal-basic" href="#modalDeleteEvent_<?= $event['event_id'] ?>"><i class="far fa-trash-alt"></i></a>-->
                                                                    <!-- Modal Delete End -->
                                                                </td>
                                                            </tr>
                                                <?
                                                        }
                                                    } else {
                                                        echo "<tr><td colspan='4'>No events</td></tr>";
                                                    }
                                                }

                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <footer class="card-footer">
                                <div class="row">
                                    <form method="post">
                                        <div class="col-md-12 text-right">
                                            <?= inp('job_id', '', 'hidden', $row['job_id']) ?>
                                            <?= inp('close_jobcard', '', 'inline-submit', 'Close Job Card', 'btn-primary') ?>&nbsp;<button class="btn btn-default modal-dismiss">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </footer>
                        </section>
                    </div>
                    <!-- Modal view End -->
                    <!-- Job Card End -->
                </div>
                <h2 class="card-title">Job# <?= $row['jobcard_number'] ?>,&nbsp;Plant: <?= $plant_['plant_number'] ?></h2>
                <p class="card-subtitle">Opened by: <?= $logged_by['name'] ?></p>
                <div class="progress progress-xl progress-half-rounded m-2">
                    <div class="progress-bar progress-bar-<?= $color ?>" role="progressbar" aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $progress ?>%;"><?= $progress ?>%</div>
                </div>
            </div>
        </a>
    </section>
</div>
<!-- Job Card Good End -->

<?php

/* 


		<!-- Job Card Causion -->
		<div class="col-md-12">
			<section class="card card-featured-left card-featured-warning mb-4">
				<div class="card-body">
					<div class="card-actions">
						<!-- View Job Card -->
						<a class="mb-1 mt-1 mr-1 modal-sizes" href="#modalviewjob2"><i class="fa-solid fa-eye"></i></a>
						<!-- Modal View -->
						<div id="modalviewjob2" class="modal-block modal-block-lg mfp-hide">
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
						<!-- Modal View End -->
						<!-- View Job Card End -->
					</div>
					<h2 class="card-title">Plant: HP56521</h2>
					<p class="card-subtitle">Opend by: Name</p>
					<div class="progress progress-xl progress-half-rounded m-2">
						<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;">20%</div>
					</div>
				</div>
			</section>
		</div>
		<!-- Job Card causion -->
		<!-- Job Card Danger -->
		<div class="col-md-12">
			<section class="card card-featured-left card-featured-danger mb-4">
				<div class="card-body">
					<div class="card-actions">
						<!-- View Job Card -->
						<a class="mb-1 mt-1 mr-1 modal-sizes" href="#modalviewjob3"><i class="fa-solid fa-eye"></i></a>
						<!-- Modal View -->
						<div id="modalviewjob3" class="modal-block modal-block-lg mfp-hide">
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
						<!-- Modal View End -->
						<!-- View Job Card End -->
					</div>
					<h2 class="card-title">Plant: HP56521</h2>
					<p class="card-subtitle">Opend by: Name</p>
					<div class="progress progress-xl progress-half-rounded m-2">
						<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">80%</div>
					</div>
				</div>
			</section>
		</div>
		<!-- Job Card Danger -->
*/