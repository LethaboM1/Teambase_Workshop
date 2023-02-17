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
                                <div class="row">
                                    <div class="col-md-6">
                                        <h2 class="card-title">View Job Card</h2>
                                    </div>
                                    <div class="col-md-6">
                                        <button onclick="window.open(`print.php?type=job-card&id=<?= $row['job_id'] ?>`,`_blank`);" class="btn btn-warning float-right">Print</button>
                                    </div>
                                </div>
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
                                        <?php
                                        require "inc.evts.php";
                                        if ($row['jobcard_type'] != 'sundry') {
                                            require "inc.req.php";
                                        }
                                        require "inc.ra.php";
                                        require "inc.tr.php";
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <footer class="card-footer">
                                <div class="row">
                                    <form method="post">
                                        <div class="col-md-12 text-right">
                                            <?= inp('job_id', '', 'hidden', $row['job_id']) ?>
                                            <?= inp('comment', 'Comment', 'textarea') ?>
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
                <?php
                if ($row['jobcard_type'] == 'sundry') {
                ?>
                    <h2 class="card-title">Job# <?= $row['jobcard_number'] ?>,&nbsp;Sundry,&nbsp;<?= $mechanic_['name'] ?>,&nbsp;[<?= $row['complete_datetime'] ?>]</h2>
                <?php
                } else {
                ?>

                    <h2 class="card-title">Job# <?= $row['jobcard_number'] ?>,&nbsp;<?= ucfirst($row['jobcard_type']) ?>,&nbsp;Plant: <?= $plant_['plant_number'] ?></h2>
                <?php
                }
                ?>
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
