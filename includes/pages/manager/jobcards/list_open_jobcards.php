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

$logged_by = dbf(dbq("select concat(name,' ', last_name) as name from users_tbl where user_id={$row['logged_by']}"));
$mechanic_ = dbf(dbq("select concat(name,' ', last_name) as name from users_tbl where user_id={$row['mechanic_id']}"));
$plant_ = dbf(dbq("select * from plants_tbl where plant_id={$row['plant_id']}"));
$site_ = get_site($row['site_id']);

switch ($plant_['reading_type']) {
    case "km":
        $reading = $row['km_reading'];
        break;

    case "hr":
        $reading = $row['hr_reading'];
        break;
}


$worked = dbf(dbq("select sum(total_hours) as hours from jobcard_events where job_id={$row['job_id']}"));

if ($worked['hours'] == null) {
    $worked['hours'] = 0;
}

if ($row['allocated_hours'] > 0) {
    $progress = $worked['hours'] / $row['allocated_hours'] * 100;
    $progress = round($progress, 2);
} else {
    $progress = 0;
}

?>
<!-- Job Card Good -->
<div class="col-md-12">

    <section class="card card-featured-left card-featured-<?= $color ?> mb-4">
        <a href="dashboard.php?page=job-card-view&id=<?= $row['job_id'] ?>">
            <div class="card-body">
                <div class="card-actions">
                    <!-- Job Card Good -->
                    <i class="fa-solid fa-eye"></i>

                    <!-- Modal view End -->
                    <!-- Job Card End -->
                </div>
                <?php
                if ($row['jobcard_type'] == 'contract') {
                ?>
                    <h2 class="card-title">Job# <?= $row['jobcard_number'] ?>,&nbsp;Site: <?= $site_['name'] ?>, <?= strtoupper($row['jobcard_type']) ?>,&nbsp;[<?= date('Y-m-d', strtotime($row['job_date']))  ?>]</h2>
                <?php
                } else {
                ?>
                    <h2 class="card-title">Job# <?= $row['jobcard_number'] ?>,&nbsp;Plant: <?= $plant_['plant_number'] ?>, <?= strtoupper($row['jobcard_type']) ?>,&nbsp;[<?= date('Y-m-d', strtotime($row['job_date']))  ?>]</h2>
                <?php
                }
                ?>

                <p class="card-subtitle">Opened by: <?= $logged_by['name'] ?>, Mechanic: <b><?= $mechanic_['name'] ?></b>, last event: <?= (strlen($row['last_evt_date']) ? $row['last_evt_date'] : "No event") ?></p>
                <?php if ($row['jobcard_type'] == 'breakdown' || $jobcard['jobcard_type'] == 'repair' || $jobcard['jobcard_type'] == 'overhead') { ?>
                    <div class="progress progress-xl progress-half-rounded m-2">
                        <div class="progress-bar progress-bar-<?= $color ?>" role="progressbar" aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $progress ?>%;"><?= $progress ?>%</div>
                    </div>
                <?php } else { ?>

                <?php } ?>
            </div>
        </a>
    </section>
</div>
<!-- Job Card Good End -->