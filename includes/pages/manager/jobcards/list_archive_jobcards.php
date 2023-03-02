<?php

$color = "default";

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
/* 

<thead>
    <tr>
        <th>Date</th>
        <th>Job No.</th>
        <th>Mechanic</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
</thead>

*/
$date = date_create($row['job_date']);
$date = date_format($date, 'Y-m-d');

?>
<tr class="pointer" onclick="$('#link_<?= $row['job_id'] ?>').click();">
    <td><?= $row['job_date'] ?></td>
    <td><?= $row['jobcard_number'] ?></td>
    <td><?= $plant_['plant_number'] ?></td>
    <td><?= $plant_['fleet_number'] ?></td>
    <td><?= $mechanic_['name'] ?></td>
    <td><?= $row['allocated_hours'] ?></td>
    <td><?= $worked['hours'] ?></td>
    <td><?= ucfirst($row['jobcard_type']) ?></td>
    <td>
        <a id="link_<?= $row['job_id'] ?>" class="mb-1 mt-1 mr-1 modal-sizes" href="#modalviewjob_<?= $row['job_id'] ?>"><i class="fa fa-folder-open"></i></a>
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
                                <div class="col-md-12">
                                    <b>Fault Description</b><br>
                                    <p>
                                        <?= $row['fault_description'] ?>
                                    </p>
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
                            <div class="row">

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
    </td>
</tr>
<?php
