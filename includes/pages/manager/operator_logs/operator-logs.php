<div id="modalAddPlant" class="modal-block modal-block-lg mfp-hide">
    <!-- <form method="post" id="addplant">
        <section class="card">
            <header class="card-header">
                <h2 class="card-title">Add New Plant</h2>
                <p class="card-subtitle">Add new plant.</p>
            </header>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
                        <label class="col-form-label" for="formGroupExampleInput">Plant No.</label>
                        <input type="text" name="plant_number" class="form-control" value="<?= $_POST['plant_number'] ?>">
                    </div>
                    <div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
                        <label class="col-form-label" for="formGroupExampleInput">Vehicle Type</label>
                        <input type="text" name="vehicle_type" placeholder="Truck, TLB ..." class="form-control" value="<?= $_POST['vehicle_type'] ?>">
                    </div>
                    <div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
                        <label class="col-form-label" for="formGroupExampleInput">Make</label>
                        <input type="text" name="make" placeholder="Make" class="form-control" value="<?= $_POST['make'] ?>">
                    </div>
                    <div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
                        <label class="col-form-label" for="formGroupExampleInput">Model</label>
                        <input type="text" name="model" placeholder="Model" class="form-control" value="<?= $_POST['model'] ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
                        <label class="col-form-label" for="formGroupExampleInput">Registration Number</label>
                        <input type="text" name="reg_number" placeholder="AAA-456-L" class="form-control" value="<?= $_POST['reg_number'] ?>">
                    </div>
                    <div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
                        <label class="col-form-label" for="formGroupExampleInput">VIN Number</label>
                        <input type="text" name="vin_number" placeholder="VIN Number" class="form-control" value="<?= $_POST['vin_number'] ?>">
                    </div>
                    <?php
                    $reading_types_select_ = [
                        ['name' => 'KM - Kilometers', 'value' => 'km'],
                        ['name' => 'HR - Hours', 'value' => 'hr'],
                    ];
                    echo inp('reading_type', 'Type of reading', 'select', $_POST['reading_type'], '', 0, $reading_types_select_);
                    ?>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
                        <label class="col-form-label" for="formGroupExampleInput">Reading</label>
                        <input type="text" name="reading" placeholder="Reading" class="form-control" value="<?= $_POST['reading'] ?>">
                    </div>
                    <div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
                        <label class="col-form-label" for="formGroupExampleInput">Next Service Reading</label>
                        <input type="number" name="next_service_reading" placeholder="Next Service Reading" class="form-control" value="<?= $_POST['next_service_reading'] ?>">
                    </div>
                </div>
            </div>
            <footer class="card-footer text-end">
                <button name='add_plant' value='add_plant' class="btn btn-primary">Add Plant</button>
                <button class="btn btn-default modal-dismiss">Cancel</button>
            </footer>
        </section>
    </form> -->
</div>
<!-- Modal Add Plant End -->

<div class="col-lg-12 mb-12">
    <section class="card">
        <header class="card-header">
            <h2 class="card-title">Operator Logs</h2>
        </header>
        <div class="card-body">
            <table width="1047" class="table table-hover table-responsive-md mb-0">
                <thead>
                    <tr>
                        <th width="180">Date/Time</th>
                        <th>Plant No.</th>
                        <th width="200">Operator</th>
                        <th width="120">Reading</th>
                        <th width="25">Action</th>
                    </tr>
                </thead>
                <tbody id="plants_list">
                    <?php

                    //connectDb("{$_SESSION['account']['account_key']}_db");
                    $lines = 15;
                    $pagination_pages = 15;

                    if (!isset($_GET['pg']) || $_GET['pg'] < 1) {
                        $_GET['pg'] = 1;
                    }

                    $get_operator_logs = dbq("select * from operator_log order by start_datetime DESC");

                    $total_lines = dbr($get_operator_logs);

                    $pages = ceil($total_lines / $lines);

                    if ($_GET['pg'] > $pages) {
                        $_GET['pg'] = $pages;
                    }

                    $pagination = ceil($_GET['pg'] / $pagination_pages);

                    $start_page = $pagination * $pagination_pages - $pagination_pages + 1;

                    $end_page = $start_page + $pagination_pages;
                    if ($end_page > $pages) {
                        $end_page = $pages;
                    }



                    $start = ($_GET['pg'] * $lines) - $lines;


                    $get_operator = dbq("select * from operator_log order by start_datetime DESC limit {$start},{$lines}");

                    if ($get_operator) {
                        if (dbr($get_operator) > 0) {
                            //error_log(__DIR__);
                            while ($row = dbf($get_operator)) {
                                require "list_logs.php";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No logs</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Error reteiving operator logs: " . dbe() . "</td></tr>";
                    }



                    // $modal_form = "<div id='del_plant_modal'></div>";
                    // modal('modalDeletePlant', 'Delete Plant', $modal_form, 'Confirm', 'del_plant');

                    // $jscript_function .=    "
                    // 							function delete_plant(plant_id) {
                    // 								$.ajax({
                    // 									method:'post',
                    // 									url: 'includes/ajax.php',
                    // 									data: {
                    // 										cmd:'get_del_plant',
                    // 										plant_id: plant_id
                    // 									},
                    // 									success: function (result) {
                    // 										$('#del_plant_modal').html(result);
                    // 										$('#openModalDeletePlant').click();
                    // 									}
                    // 								});
                    // 							}
                    // 							";

                    ?>
                </tbody>
            </table>
            <nav aria-label="Page navigation example">
                <ul class="pagination" id="pageination">
                    <li class="page-item"><a class="page-link" href="dashboard.php?page=operator-logs&pg=1"><?= "<<" ?></a>
                    </li>
                    <li class="page-item"><a class="page-link" href="dashboard.php?page=operator-logs&pg=<?php echo $start_page - 1 ?>">Previous</a></li>
                    <?php

                    for ($a = $start_page; $a <= $end_page; $a++) {
                        echo "<li class='page-item'><a class='page-link' href='dashboard.php?page=operator-logs&pg={$a}'>";
                        if ($_GET['page'] == $a) {
                            echo "<b>{$a}</b>";
                        } else {
                            echo $a;
                        }
                        echo "</a></li>";
                    }
                    ?>
                    <li class="page-item"><a class="page-link" href="dashboard.php?page=operator-logs&pg=<?php echo $pagination * $pagination_pages + 1 ?>">Next</a></li>
                    <li class="page-item"><a class="page-link" href="dashboard.php?page=operator-logs&pg=<?php echo $pages ?>">>></a></li>
                </ul>
            </nav>
            <!-- <a id='openModalEditPlant' href='#modalEditPlant' class='mb-1 mt-1 mr-1 modal-sizes'></a> -->
            <!-- <a id="openModalDeletePlant" class="mb-1 mt-1 mr-1 modal-basic" href="#modalDeletePlant"></a> -->
            <!-- <a id="openModalViewPlant" class="mb-1 mt-1 mr-1 modal-basic" href="#modalViewPlant"></a> -->
        </div>
    </section>
</div>