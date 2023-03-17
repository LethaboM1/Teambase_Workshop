<!-- Modal add event -->
<div id="modalAddEvent" class="modal-block modal-block-lg mfp-hide">
    <form method="post">
        <section class="card">
            <header class="card-header">
                <h2 class="card-title">Add Fault Report</h2>
            </header>
            <div class="card-body">
                <h2 class="card-title">Fault Report</h2><br>
                <div class="row">
                    <div class="row mt-2">
                        <form method="post">
                            <div class="col-md-2"><select class="form-control mb-3" id="component" name="component">
                                    <option value="">Select Component</option>
                                    <option value="Engine">Engine</option>
                                    <option value="Clutch">Clutch</option>
                                    <option value="Gearbox/Drive Train">Gearbox/Drive Train</option>
                                    <option value="Axel + Suspension Rear">Axel + Suspension Rear</option>
                                    <option value="Axel + Suspension Front">Axel + Suspension Front</option>
                                    <option value="Brakes">Brakes</option>
                                    <option value="Cab + Accessories">Cab + Accessories</option>
                                    <option value="Electrical">Electrical</option>
                                    <option value="Hydraulics ">Hydraulics </option>
                                    <option value="Structure">Structure</option>
                                    <option value="Other">Other / Comment</option>
                                </select>
                            </div>
                            <div class="col-md-2"><select name="severity" class="form-control mb-3" id="severity">
                                    <option value="">Select Severity</option>
                                    <option value="low">Low</option>
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                </select>
                            </div>
                            <div class="col-md-2"><input type="number" name="hours" id="hours" value="1" placeholder="Required Hours" class="form-control"></div>
                            <div class="col-md-4"><textarea class="form-control mt-2" name="report_comment" id="report_comment" placeholder="Details"></textarea></div>
                            <div class="col-md-2"><button name='add_insp' type="submit" class="btn btn-primary btn-sm">Add</button></div>
                        </form>
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
    </form>
</div>
<!-- Modal view End -->

<section id="evt_section" class="card mt-3">
    <header class="card-header">
        <h2 class="card-title">Fault Reports</h2>
    </header>

    <div class="card-body">
        <div class="header-right">
            <a class="mb-1 mt-1 mr-1 modal-basic" href="#modalAddEvent"><button class="btn btn-primary">Add Report</button></a>
        </div>
        <table width="1047" class="table table-responsive-md mb-0">
            <thead>
                <tr>
                    <th width="200">Component</th>
                    <th width="110">Severity</th>
                    <th width="45">Hours</th>
                    <th width='38'></th>
                    <th width="400">Comment</th>
                    <th width="45">Reveiewed</th>
                    <th width="120"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $get_job_reports = dbq("select * from jobcard_reports where job_id={$_GET['id']}");
                if ($get_job_reports) {
                    if (dbr($get_job_reports) > 0) {
                        while ($job_report = dbf($get_job_reports)) {

                ?>
                            <tr>
                                <td><?= $job_report['component'] ?></td>
                                <td><?= ucfirst($job_report['severity']) ?></td>
                                <td><?= ((!$job_report['reviewed'] && $_SESSION['user']['role'] == 'mechanic') || $_SESSION['user']['role'] == 'manager' || $_SESSION['user']['role'] == 'system' ? inp('hours', '', 'number', $job_report['hours'], '', 0, '', "style='width:120px;' onchange='update_hours(`{$job_report['id']}`,$(this).val())'") : $job_report['hours']) ?></td>
                                <td><span id="<?= $job_report['id'] ?>_update"></span></td>
                                <td><?= $job_report['comment'] ?></td>
                                <td><?= ($job_report['reviewed'] ? "<i class='fa fa-check'></i>" : "<i class='fa fa-times'></i>") ?></td>
                                <td></td>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan='5'>Nothing to list</td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
        <?php if ($_SESSION['user']['role'] == 'manager' || $_SESSION['user']['role'] == 'system' || $_SESSION['user']['role'] == 'mechanic') { ?>
            <script>
                function update_hours($id, $value) {
                    $.ajax({
                        method: 'post',
                        url: 'includes/ajax.php',
                        data: {
                            cmd: 'report_hours_ajust',
                            id: $id,
                            hours: $value,
                            job_id: '<?= $_GET['id'] ?>'
                        },
                        success: function(result) {
                            let data = JSON.parse(result);
                            if (data.status == 'ok') {
                                $("#" + $id + "_update").html(`<i class="fa fa-check text-success"></i>`);
                                if (null !== data.hours) {
                                    $("#jobcard_allocated_hours").html(data.hours);
                                }
                            } else {
                                $("#" + $id + "_update").html(`<i class="fa fa-times text-danger"></i>`);
                            }
                        }
                    });
                }
            </script>
        <?php } ?>
    </div>
</section>