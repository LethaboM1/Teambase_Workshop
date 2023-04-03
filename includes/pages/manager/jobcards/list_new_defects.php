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
                            <div class="row">
                                <div class="col">
                                    <h2 class="card-title">Defect Report</h2>
                                </div>
                                <div class="col"><a class="btn btn-secondary ml-auto" target="_blank" href="print.php?type=defect-report&id=<?= $jobcard['job_id'] ?>">Print</a></div>
                            </div>

                        </header>
                        <form method="post">
                            <div class="card-body">
                                <b>Reported by:</b>&nbsp;<?= $logged_by_['name'] ?><br>
                                <?php
                                if ($jobcard['list_id'] > 0) {
                                ?>
                                    <a target="_blank" href="print.php?type=plant-checklist&id=<?= $jobcard['list_id'] ?>" class="btn btn-warning btn-sm">Print Sheet</a><br>
                                <?php
                                }
                                ?>
                                <b>Date Reported</b>&nbsp;<?= $jobcard['job_date'] ?><br>
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
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Component</th>
                                                        <th>severity</th>
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
                                                                    <td><span id="<?= $report['id'] ?>_div"></span></td>
                                                                    <td><?= $report['comment'] ?></td>
                                                                </tr>
                                                            <?php
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
                                        <?= inp('mechanic', 'Select Mechanic', 'select', $jobcard['mechanic_id'], '', 0, $mechanic_select_) ?>
                                        <?php
                                        if ($_SESSION['user']['role'] == 'manager' || $_SESSION['user']['role'] == 'system') {
                                            echo inp('clerk_id', 'Select Clerk', 'select', $jobcard['clerk_id'], '', 0, $clerk_select_);
                                        } else {
                                            echo inp('clerk_id', '', 'hidden', $jobcard['clerk_id']);
                                        }
                                        ?>
                                        <?= inp('job_id', '', 'hidden', $jobcard['job_id']) ?>
                                    </div>
                                </div>
                                <footer class="card-footer">
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <button type="submit" name="allocate_mechanic" class="btn btn-primary">Allocate</button>
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

                <h2 class="card-title">Plant: <?= $plant_['plant_number'] ?>, Defect-Report ,&nbsp;[<?= date('Y-m-d', strtotime($jobcard['job_date']))  ?>]</h2>

                <p class="card-subtitle"><b>Logged by:</b><?= $logged_by_['name'] ?><br><?= $jobcard['fault_description'] ?></p>
            </a>
        </div>
    </section>
</div>

<?php
