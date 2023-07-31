<?php

$logged_by = ($row['logged_by'] > 0) ? dbf(dbq("select concat(name,' ', last_name) as name from users_tbl where user_id={$row['logged_by']}")) : ['name' => 'None'];
$mechanic_ = ($row['mechanic_id'] > 0) ? dbf(dbq("select concat(name,' ', last_name) as name from users_tbl where user_id={$row['mechanic_id']}")) : ['name' => 'None'];
$plant_ = ($row['mechanic_id'] > 0) ? dbf(dbq("select * from plants_tbl where plant_id={$row['plant_id']}")) : ['name' => 'None'];
$site_ = ($row['site_id'] > 0) ? dbf(dbq("select * from sites_tbl where id={$row['site_id']}")) : ['name' => 'None'];

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

?>
<!-- Job Card Good -->
<div class="col-md-12">
    <section class="card card-featured-left card-featured-warning mb-4">
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
                                            <b>Job No.</b>&nbsp;None<br>
                                            <b>Date logged.</b>&nbsp;<?= $row['job_date'] ?><br>
                                            <b>Type.</b>&nbsp;<?= $plant_['vehicle_type'] ?><br>
                                            <b>Model.</b>&nbsp;<?= $plant_['model'] ?><br>
                                            <b>Mechanic.</b>&nbsp;<?= $mechanic_['name'] ?><br>
                                        </div>
                                        <div class="col-md-6">
                                            <b>Plant.</b>&nbsp;<?= $plant_['reg_number'] ?><br>
                                            <b>Logged by.</b>&nbsp;<?= $logged_by['name'] ?><br>
                                            <b>Make.</b>&nbsp;<?= $plant_['make'] ?><br>
                                            <b>Reading (<?= strtoupper($plant_['reading_type']) ?>).</b>&nbsp;<?= $reading ?><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <b>Fault:</b><br><?= $row['fault_description'] ?><br>
                            <?php if ($row['jobcard_type'] == 'breakdown' || $row['jobcard_type'] == 'overhead' || $row['jobcard_type'] == 'repair') { ?>
                                <b>Extras</b><br>
                                <div class="row">
                                    <?php
                                    if (strlen($row['safety_audit']) > 0) {
                                        $safety_audit = json_decode(base64_decode($row['safety_audit']), true);
                                    } else {
                                        $safety_audit = [];
                                    }

                                    if (is_array($safety_audit)) {

                                        if (count($safety_audit) > 0) {
                                            foreach ($safety_audit as $line) {
                                    ?>
                                                <div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
                                                    <div class="checkbox-custom checkbox-default">
                                                        <input type="checkbox" <?php if ($line['answer'] == 'Yes') {
                                                                                    echo "checked='checked'";
                                                                                } ?> disabled>
                                                        <label for="checkboxExample1"><?= $line['name'] ?></label>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
                                                Nothing to list
                                            </div>
                                <?php
                                        }
                                    }
                                }
                                ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Component</th>
                                                    <th>severity</th>
                                                    <th style='width:85px;'>Hours</th>
                                                    <th style='width:25px;'></th>
                                                    <th>Comment</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $get_reports = dbq("select * from jobcard_reports where job_id={$row['job_id']}");
                                                $allocated_hours = 0;
                                                if ($get_reports) {
                                                    if (dbr($get_reports) > 0) {
                                                        while ($report = dbf($get_reports)) {
                                                ?>
                                                            <tr>
                                                                <td><?= $report['component'] ?></td>
                                                                <td><?= $report['severity'] ?></td>
                                                                <td><?= inp("{$report['id']}_report_hours", '', 'number', $report['hours'], '', 0, '', " style='width:80px;'  step='0.5'") ?></td>
                                                                <td><span id="<?= $report['id'] ?>_div"></span></td>
                                                                <td><?= $report['comment'] ?></td>
                                                            </tr>
                                                        <?php
                                                            $allocated_hours += $report['hours'];
                                                            $jscript .= "
                                                            $('#{$report['id']}_report_hours').change(function () {
                                                                $.ajax({
                                                                    method:'post',
                                                                    url:'includes/ajax.php',
                                                                    data: {
                                                                        cmd:'report_hours_ajust',
                                                                        id: '{$report['id']}',
                                                                        job_id: '{$row['job_id']}',
                                                                        hours: $(this).val()
                                                                    },
                                                                    success: function (result) {
                                                                        let data = JSON.parse(result);

                                                                        if (data.status=='ok') {																						
                                                                            $('#{$report['id']}_div').html(`<i class='fa fa-check text-success'></i>`);
                                                                            $('#{$row['id']}_allocated_hours').val(data.hours);
                                                                        } else {																						
                                                                            $('#{$report['id']}_div').html(`<i class='fa fa-times text-danger'></i>`);
                                                                        }
                                                                    },
                                                                    error: function () {}
                                                                });
                                                            });
                                                            ";
                                                        }
                                                    } else {
                                                        ?>

                                                        <tr>
                                                            <td colspan="5">No fault / inspections reports</td>
                                                        </tr>
                                                <?php

                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
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
            <h2 class="card-title"><?= ($row['jobcard_type'] == 'contract' ?  "Site: {$site_['name']}" : "Plant: {$plant_['plant_number']}") ?>,&nbsp;Logged: <?= $logged_date ?> Job# <?= $row['jobcard_number'] ?>,&nbsp;Type: <?= ucfirst($row['jobcard_type']) ?>, Status: <?= ucfirst($row['status']) ?></h2>
            </a>
            <p class="card-subtitle">Opened by: <?= $logged_by['name'] . ' ' . $logged_by['last_name'] ?></p>
        </div>
    </section>
</div>
<!-- Job Card Good End -->
<?php
