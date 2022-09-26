<div class="col-md-12">
    <section class="card card-featured-left card-featured-<?= $status_color ?> mb-4">
        <div class="card-body">
            <div class="card-actions">
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
                                    <b>Fault:</b><br><?= $logged_by_['fault_description'] ?><br>
                                    <b>Extras</b><br>
                                    <?php
                                    $items = json_decode($jobcard['safety_audit'], true);
                                    echo "<ul>";
                                    foreach ($items as $item) {
                                        echo "<li>{$item['name']} - [{$item['answer']}]</li>";
                                    }
                                    echo "</ul>";
                                    ?>
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
                                <div class="row">
                                    <div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
                                        <label class="col-form-label" for="formGroupExampleInput">Job Number</label>
                                        <input type="text" name="jobnumber" value="" placeholder="Job card Number" class="form-control">
                                    </div>
                                    <div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
                                        <label class="col-form-label" for="formGroupExampleInput">Allocated Hours</label>
                                        <input type="number" name="allocated_hours" class="form-control">
                                    </div>
                                    <?= inp('job_id', '', 'hidden', $jobcard['job_id']) ?>
                                    <?= inp('mechanic', 'Select Mechanic', 'select', '', '', 0, $mechanic_select_) ?>
                                </div>
                            </div>
                            <footer class="card-footer">
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button type="submit" name="allocate_mechanic" class="btn btn-primary">Allocate</button>
                                        <button class="btn btn-default modal-dismiss">Cancel</button>
                                    </div>
                                </div>
                            </footer>
                        </form>
                    </section>
                </div>
                <!-- Assign Job Card End -->
            </div>
            <h2 class="card-title">Plant: <?= $plant_['reg_number'] ?></h2>
            <p class="card-subtitle">Opened by: <?= $logged_by_['name'] ?></p>
        </div>
    </section>
</div>