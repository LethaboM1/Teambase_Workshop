<div class="col-md-12">
    <section class="card card-featured-left card-featured-<?= $status_color ?> mb-4">
        <div class="card-body">
            <div class="card-actions">
                <!-- Assign Job Card -->
                <!-- Modal Assign -->
                <a class="mb-1 mt-1 mr-1 modal-sizes" href="#modalassign_<?= $jobcard['job_id'] ?>"><i class="fa-solid fa-handshake-angle fa-2x"></i></a>
                <div id="modalassign_<?= $jobcard['job_id'] ?>" class="modal-block modal-block-lg mfp-hide">
                    <section class="card">
                        <header class="card-header">
                            <h2 class="card-title">Assign Job Card</h2>
                        </header>
                        <form method="post">
                            <div class="card-body">
                                <?= inp('jobcard_type', '', 'hidden', $jobcard['jobcard_type']) ?>
                                <b>Logged by:</b>&nbsp;<?= $logged_by_['name'] ?><br>
                                <?php
                                if ($jobcard['list_id'] > 0) {
                                ?>
                                    <a target="_blank" href="print.php?type=plant-checklist&id=<?= $jobcard['list_id'] ?>" class="btn btn-warning btn-sm">Print Sheet</a><br>
                                <?php
                                }
                                ?>
                                <b>Date Logged</b>&nbsp;<?= $jobcard['job_date'] ?><br>
                                <b>Fault:</b><br><?= $jobcard['fault_description'] ?><br>
                                <?php if ($jobcard['jobcard_type'] == 'breakdown' || $jobcard['jobcard_type'] == 'overhead' || $jobcard['jobcard_type'] == 'repair' ||  $jobcard['jobcard_type'] == 'contract') { ?>
                                    <b>Extras</b><br>
                                    <div class="row">
                                        <?php
                                        if (strlen($jobcard['safety_audit']) > 0) {
                                            $safety_audit = json_decode(base64_decode($jobcard['safety_audit']), true);
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
                                                    $get_reports = dbq("select * from jobcard_reports where job_id={$jobcard['job_id']}");
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
                                                                        job_id: '{$jobcard['job_id']}',
                                                                        hours: $(this).val()
                                                                    },
                                                                    success: function (result) {
                                                                        let data = JSON.parse(result);

                                                                        if (data.status=='ok') {																						
                                                                            $('#{$report['id']}_div').html(`<i class='fa fa-check text-success'></i>`);
                                                                            $('#{$jobcard['id']}_allocated_hours').val(data.hours);
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
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
                                            <label class="col-form-label" for="formGroupExampleInput">Job Number</label>
                                            <input type="text" name="jobnumber" value="" placeholder="Job card Number" class="form-control">
                                        </div>
                                        <?php
                                        if ($jobcard['jobcard_type'] != 'sundry') {
                                            if (dbr($get_reports) == 0) {
                                        ?>
                                                <div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
                                                    <label class="col-form-label" for="formGroupExampleInput">Allocated Hours</label>
                                                    <input type="number" name='allocated_hours' value="<?= round($allocated_hours, 2) ?>" step="0.5" class="form-control">
                                                </div>
                                            <?php

                                            } else {

                                            ?>
                                                <input type="hidden" id='<?= $jobcard['id'] ?>_allocated_hours' name='allocated_hours' value="<?= round($allocated_hours, 2) ?>">
                                        <?php

                                            }
                                        }

                                        if ($_SESSION['user']['role'] == 'manager' || $_SESSION['user']['role'] == 'system') {
                                            echo inp('clerk_id', 'Select Clerk', 'select', $jobcard['clerk_id'], '', 0, $clerk_select_);
                                        } else {
                                            echo inp('clerk_id', '', 'hidden', $jobcard['clerk_id']);
                                        }
                                        ?>
                                        <?= inp('job_id', '', 'hidden', $jobcard['job_id']) ?>
                                        <?= inp('mechanic', 'Select Mechanic', 'select', $jobcard['mechanic_id'], '', 0, $mechanic_select_) ?>
                                    </div>
                                    </div>
                                    <footer class="card-footer">
                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <button type="submit" name="allocate_mechanic" class="btn btn-primary">Allocate</button>
                                                <?php if (is_array($defect_report) > 0) { ?>
                                                    <a class="mb-1 mt-1 mr-1" target="_blank" href="print.php?type=defect-report&id=<?= $defect_report['id'] ?>"><button type="button" class='btn btn-info float-right'>Defect Report</button></a>
                                                <?php } ?>
                                                <button type="submit" name="delete_jobcard" class="btn btn-danger">Delete</button>
                                                <button class="btn btn-default modal-dismiss">Cancel</button>
                                            </div>
                                        </div>
                                    </footer>
                        </form>
                    </section>
                </div>
                <!-- Assign Job Card End -->
            </div>
            <a class="mb-1 mt-1 mr-1 modal-sizes" href="#modalassign_<?= $jobcard['job_id'] ?>">
                <?php
                if ($jobcard['jobcard_type'] == 'sundry') {
                ?>
                    <h2 class="card-title">Sundry Jobcard</h2>
                <?php
                } else if ($jobcard['jobcard_type'] == 'service') {
                ?>
                    <h2 class="card-title">Plant: <?= $plant_['plant_number'] ?>, <?= ucfirst($jobcard['jobcard_type']) ?>, Type: <?= $jobcard['service_type'] ?>,&nbsp;[<?= date('Y-m-d', strtotime($jobcard['job_date']))  ?>]</h2>
                <?php

                } else if ($jobcard['jobcard_type'] == 'contract') {
                ?>
                    <h2 class="card-title">Site <?= $site_['name'] ?>,Type: <?= ucfirst($jobcard['jobcard_type']) ?>,&nbsp;[<?= date('Y-m-d', strtotime($jobcard['job_date']))  ?>]</h2>
                <?php
                } else {
                ?>
                    <h2 class="card-title">Plant: <?= $plant_['plant_number'] ?>, <?= ucfirst($jobcard['jobcard_type']) ?>,&nbsp;[<?= date('Y-m-d', strtotime($jobcard['job_date']))  ?>]</h2>
                <?php
                }
                ?>
                <p class="card-subtitle"><b>Logged by:</b><?= $logged_by_['name'] ?><br><?= $jobcard['fault_description'] ?>, <b>Mechanic:</b><?= $$mechanic_['name'] ?> <?= $$mechanic_['last_name'] ?><br><?= $jobcard['fault_description'] ?></p>
            </a>
        </div>
    </section>
</div>

<?php
