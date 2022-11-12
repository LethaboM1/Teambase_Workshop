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
                                <b>Date Logged</b>&nbsp;<?= $jobcard['job_date'] ?><br>
                                <b>Fault:</b><br><?= $jobcard['fault_description'] ?><br>
                                <?php if ($jobcard['jobcard_type'] == 'breakdown') { ?>
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
                                        <div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
                                            <label class="col-form-label" for="formGroupExampleInput">Job Number</label>
                                            <input type="text" name="jobnumber" value="" placeholder="Job card Number" class="form-control">
                                        </div>
                                        <?php
                                        if ($jobcard['jobcard_type'] != 'sundry') {
                                        ?>
                                            <div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
                                                <label class="col-form-label" for="formGroupExampleInput">Allocated Hours</label>
                                                <input type="number" name="allocated_hours" class="form-control">
                                            </div>
                                        <?php
                                        }

                                        if ($jobcard['clerk_id'] == null || $jobcard['clerk_id'] == 0) {
                                            echo inp('clerk_id', 'Select Clerk', 'select', $jobcard['clerk_id'], '', 0, $clerk_select_);
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
                } else {
                ?>
                    <h2 class="card-title">Plant: <?= $plant_['plant_number'] ?></h2>
                <?php
                }
                ?>
                <p class="card-subtitle"><b>Date</b>&nbsp;<?= date('Y-m-d', strtotime($jobcard['job_date'])) ?><br><b>Logged by:</b><?= $logged_by_['name'] ?><br><?= $jobcard['fault_description'] ?></p>
            </a>
        </div>
    </section>
</div>

<?php

/*
<!-- Job Card Good -->
                <a class="mb-1 mt-1 mr-1 modal-sizes" href="#modalviewjob_<?= $jobcard['job_id'] ?>"><i class="fa-solid fa-eye fa-2x"></i></a>
                <!-- Modal view -->
                <div id="modalviewjob_<?= $jobcard['job_id'] ?>" class="modal-block modal-block-lg mfp-hide">
                    <section class="card">
                        <header class="card-header">
                            <h2 class="card-title">View Job Card</h2>
                        </header>
                        <div class="card-body">
                            <div class="modal-wrapper">
                                <div class="modal-text">
                                    <b>Logged by:</b>&nbsp;<?= $logged_by_['name'] ?><br>
                                    <b>Fault:</b><br><?= $jobcard['fault_description'] ?><br>
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
*/