<?php
switch ($row['priority']) {
    case 1:
        $color = "danger";
        break;

    case 2:
        $color = "warning";
        break;

    default:
        $color = "success";
        break;
}

$logged_by = ($row['logged_by'] > 0) ? dbf(dbq("select concat(name,' ', last_name) as name from users_tbl where user_id={$row['logged_by']}")) : ['name' => 'None'];
$mechanic_ = ($row['mechanic_id'] > 0) ? dbf(dbq("select concat(name,' ', last_name) as name from users_tbl where user_id={$row['mechanic_id']}")) : ['name' => 'None'];
$plant_ = ($row['mechanic_id'] > 0) ? dbf(dbq("select * from plants_tbl where plant_id={$row['plant_id']}")) : ['name' => 'None'];

switch ($plant_['reading_type']) {
    case "km":
        $reading = $row['km_reading'];
        break;

    case "hr":
        $reading = $row['hr_reading'];
        break;
}

$logged_date = date_create($row['job_date']);
$logged_date = date_format($logged_date, 'Y-m-d');

$worked = dbf(dbq("select sum(total_hours) as hours from jobcard_events where job_id={$row['job_id']}"));

if ($worked['hours'] == null) {
    $worked['hours'] = 0;
}

if ($row['allocated_hours'] > 0) {
    $progess = $worked['hours'] / $row['allocated_hours'] * 100;
    $progess = round($progess, 2);
} else {
    $progress = 0;
}

?>
<!-- Job Card Good -->
<div class="col-md-12">
    <section class="card card-featured-left card-featured-<?= $color ?> mb-4">
        <div class="card-body">
            <div class="card-actions">
                <!-- Job Card Good -->
                <a class="mb-1 mt-1 mr-1 modal-sizes" href="#modalviewjob_<?= $row['job_id'] ?>"><i class="fa-solid fa-eye"></i></a>
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
                                            <b>Progress.</b>&nbsp;<?= $progess ?>%<br>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <table class="table table-responsive">
                                            <thead>
                                                <tr>
                                                    <th>Start</th>
                                                    <th>End</th>
                                                    <th>Note</th>
                                                    <th>Hrs</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $get_events = dbq("select * from jobcard_events where job_id={$row['job_id']}");
                                            if ($get_events) {
                                                if (dbr($get_events) > 0) {
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
                                <div class="col-md-12 text-right">
                                    <button class="btn btn-default modal-dismiss">Cancel</button>
                                </div>
                            </div>
                        </footer>
                    </section>
                </div>
                <!-- Modal view End -->
                <!-- Job Card End -->
            </div>
            <?php
            switch ($row['status']) {
                case "open":
            ?>
                    <a href="dashboard.php?page=daily-pre-task-mini&id=<?= $row['job_id'] ?>">
                        <?php
                        break;

                    case "busy":
                        switch ($row['jobcard_type']) {
                            case 'sundry':
                        ?>
                                <a href="dashboard.php?page=job-card-view&id=<?= $row['job_id'] ?>">
                                <?php
                                break;

                            case 'overhead':
                            case 'repair':
                            case 'breakdown':
                                ?>
                                    <a href="dashboard.php?page=job-card-view&id=<?= $row['job_id'] ?>">
                                    <?php
                                    break;

                                case 'service':
                                    ?>
                                        <a href="dashboard.php?page=plant-schedule&id=<?= $row['job_id'] ?>">
                            <?php
                                    break;
                            }
                    }
                            ?>
                            <h2 class="card-title">Logged: <?= $logged_date ?> Job# <?= $row['jobcard_number'] ?>,&nbsp;Plant: <?= $plant_['plant_number'] ?>, Type: <?= ucfirst($row['jobcard_type']) ?>, Status: <?= ucfirst($row['status']) ?></h2>
                                        </a>
                                        <p class="card-subtitle">Opened by: <?= $logged_by['name'] . ' ' . $logged_by['last_name'] ?></p>
                                        <div class="progress progress-xl progress-half-rounded m-2">
                                            <div class="progress-bar progress-bar-<?= $color ?>" role="progressbar" aria-valuenow="<?= $progess ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $progess ?>%;"><?= $progess ?>%</div>
                                        </div>
        </div>
    </section>
</div>
<!-- Job Card Good End -->
<?php
