<?php

if (isset($_POST['del_plant'])) {
    if ($_POST['user_id'] > 0) {
        $update_user = dbq("update plants_tbl set active=0 where plant_id={$_POST['plant_id']}");
        if ($update_user) {
            msg("User has been removed!");
        } else {
            sqlError();
        }
    }
}

if (isset($_POST['save_plant'])) {
    if (
        strlen($_POST['vehicle_type']) > 0
        && strlen($_POST['make']) > 0
        && strlen($_POST['model']) > 0
        && strlen($_POST['reg_number']) > 0

    ) {
        $plant_ = dbf(dbq("select * from plants_tbl where plant_id='{$_POST['plant_id']}'"));
        $chk_duplicate_reg = dbq("select * from plants_tbl where reg_number='{$_POST['reg_number']}' and plant_id!='{$_POST['plant_id']}'");
        if (dbr($chk_duplicate_reg) == 0) {
            $chk_duplicate_reg = dbq("select * from plants_tbl where vin_number='{$_POST['vin_number']}' and plant_id!='{$_POST['plant_id']}'");
            if (dbr($chk_duplicate_reg) == 0) {
                switch ($_POST['reading_type']) {
                    case "km":
                        $query_reading = "
                                            km_reading={$_POST['reading']},
                                            hr_reading=0,
                                        ";
                        break;

                    case "hr":
                        $query_reading = "
                                            km_reading=0,
                                            hr_reading={$_POST['reading']},
                                        ";
                        break;
                }

                if (!is_numeric($_POST['next_service_reading'])) {
                    $_POST['next_service_reading'] = 0;
                }

                $update_plant = dbq("update plants_tbl set 
                                        plant_number='{$_POST['plant_number']}',   
                                        vehicle_type='{$_POST['vehicle_type']}',
                                        make='{$_POST['make']}',
                                        model='{$_POST['model']}',
                                        reg_number='{$_POST['reg_number']}',
                                        vin_number='{$_POST['vin_number']}',
                                        reading_type='{$_POST['reading_type']}',
                                        {$query_reading}
                                        next_service_reading='{$_POST['next_service_reading']}'
                                        where plant_id='{$_POST['plant_id']}'
                                        ");
                if ($update_plant) {
                    msg("plant saved {$_POST['firstName']}!");
                    go('dashboard.php?page=add-plant');
                } else {
                    sqlError();
                }
            } else {
                error("plant with vin number {$_POST['vin_number']} already exists.");
            }
        } else {
            error("plant with registration number {$_POST['reg_number']} already exists.");
        }
    } else {
        error("fill in name, email and passwords at least.");
    }
}

if (isset($_POST['add_plant'])) {
    if (
        strlen($_POST['vehicle_type']) > 0
        && strlen($_POST['make']) > 0
        && strlen($_POST['model']) > 0
        && strlen($_POST['plant_number']) > 0
        && $_POST['reading'] > 0

    ) {

        $chk_duplicate_reg = dbq("select * from plants_tbl where reg_number='{$_POST['reg_number']}' and reg_number!=''");
        if (dbr($chk_duplicate_reg) == 0) {
            $chk_duplicate_reg = dbq("select * from plants_tbl where vin_number='{$_POST['vin_number']}' and vin_number!=''");
            if (dbr($chk_duplicate_reg) == 0) {
                if (!is_numeric($_POST['next_service_reading'])) {
                    $_POST['next_service_reading'] = 0;
                }

                switch ($_POST['reading_type']) {
                    case "km":
                        $query_reading = "
                                            km_reading={$_POST['reading']},
                                            hr_reading=0,
                                        ";
                        break;

                    case "hr":
                        $query_reading = "
                                            km_reading=0,
                                            hr_reading={$_POST['reading']},
                                        ";
                        break;
                }
                $insert_plant = dbq("insert into plants_tbl set            
                                                plant_number='{$_POST['plant_number']}',                                
                                                vehicle_type='{$_POST['vehicle_type']}',
                                                make='{$_POST['make']}',
                                                model='{$_POST['model']}',
                                                reg_number='{$_POST['reg_number']}',
                                                vin_number='{$_POST['vin_number']}',
                                                reading_type='{$_POST['reading_type']}',
                                                {$query_reading}
                                                next_service_reading='{$_POST['next_service_reading']}',
                                                status='ready'
                                            ");
                if ($insert_plant) {
                    $plant_id = mysqli_insert_id($db);
                    msg("plant {$_POST['vehicle_type']} was added!");
                    go("dashboard.php?page=view-plant&id={$plant_id}");
                } else {
                    sqlError();
                }
            } else {
                error("plant with vin number {$_POST['vin_number']} already exists.");
            }
        } else {
            error("plant with registration number {$_POST['reg_number']} already exists.");
        }
    } else {
        error("Vehicle type, Make, Model, reading and plant number are required fields.");
    }
}
