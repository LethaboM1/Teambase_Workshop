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
                                <div class="col"></div>
                            </div>

                        </header>
                        <form method="post">
                            <div class="card-body">
                                <b>Reported by:</b>&nbsp;<?= $logged_by_['name'] ?><br>

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
                                                        <th>Photos</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $get_reports = dbq("select * from jobcard_reports where job_id={$jobcard['job_id']} and reviewed=0");
                                                    $allocated_hours = 0;
                                                    if ($get_reports) {
                                                        if (dbr($get_reports) > 0) {
                                                            while ($report = dbf($get_reports)) {
                                                    ?>
                                                                <tr>
                                                                    <td><?= $report['component'] ?></td>
                                                                    <td><?= $report['severity'] ?></td>
                                                                    <td><?= ((!$report['reviewed'] && $_SESSION['user']['role'] == 'mechanic') || $_SESSION['user']['role'] == 'manager' || $_SESSION['user']['role'] == 'system' ? inp('hours', '', 'number', $report['hours'], '', 0, '', "style='width:120px;' step='0.1' onchange='update_hours(`{$report['id']}`,$(this).val(),`{$report['job_id']}`)'") : $report['hours']) ?></td>
                                                                    <td><span id="<?= $report['id'] ?>_update"></span></td>
                                                                    <td><?= $report['comment'] ?></td>
                                                                    <td>
                                                                        <!-- <a class="btn btn-secondary ml-auto" target="_blank" href="print.php?type=additional-defect-report&id=<?= $report['id'] ?>"><i class="fa fa-print"></i></a> -->
                                                                    </td>
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
                                            <hr>
                                            <?php
                                            $photos = [];
                                            $photos_ = get_photos('defect-reports', $jobcard['job_id']);
                                            if (isset($photos_) && is_array($photos_) && count($photos_) > 0) $photos = array_merge($photos_, $photos);
                                            if (count($photos) > 0) {
                                            ?>
                                                <h4>Photos</h4>
                                                <div class="row">
                                                    <?php
                                                    foreach ($photos as $photo) {
                                                    ?>
                                                        <div class="col-md-4">
                                                            <img style="max-height:270px" src="./files/defect-reports/<?= $jobcard['job_id'] . '/' . $photo ?>" alt="" class="rounded img-fluid">
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                            <hr>
                                        </div>
                                    </div>

                                </div>
                                <footer class="card-footer">
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <?= inp('job_id', '', 'hidden', $jobcard['job_id']) ?>
                                            <button type="submit" name="reviewed" class="btn btn-primary">Reviewed</button>
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

                <h2 class="card-title">Job: <?= $jobcard['jobcard_number'] ?>, Plant: <?= $plant_['plant_number'] ?>, Defect-Report ,&nbsp;[<?= date('Y-m-d', strtotime($jobcard['job_date']))  ?>]</h2>

                <p class="card-subtitle"><b>Logged by:</b><?= $logged_by_['name'] ?><br><?= $jobcard['fault_description'] ?></p>
            </a>
        </div>
    </section>
</div>

<?php
