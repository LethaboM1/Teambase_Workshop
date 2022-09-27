<?php

if (isset($_POST['del_plant'])) {
    // Check data if none delete from table or Set as suspended

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
                $update_plant = dbq("update plants_tbl set 
                                        plant_number='{$_POST['plant_number']}',   
                                        vehicle_type='{$_POST['vehicle_type']}',
                                        make='{$_POST['make']}',
                                        model='{$_POST['model']}',
                                        reg_number='{$_POST['reg_number']}',
                                        vin_number='{$_POST['vin_number']}',
                                        reading_type='{$_POST['reading_type']}',
                                        {$query_reading}
                                        last_service='{$_POST['last_service']}',
                                        next_service='{$_POST['next_service']}'
                                        where plant_id='{$_POST['plant_id']}'
                                        ");
                if ($update_plant) {
                    msg("plant saved {$_POST['firstName']}!");
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
        && strlen($_POST['reg_number']) > 0
        && $_POST['reading'] > 0

    ) {

        $chk_duplicate_reg = dbq("select * from plants_tbl where reg_number='{$_POST['reg_number']}'");
        if (dbr($chk_duplicate_reg) == 0) {
            $chk_duplicate_reg = dbq("select * from plants_tbl where vin_number='{$_POST['vin_number']}'");
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
                $insert_plant = dbq("insert into plants_tbl set            
                                                plant_number='{$_POST['plant_number']}',                                
                                                vehicle_type='{$_POST['vehicle_type']}',
                                                make='{$_POST['make']}',
                                                model='{$_POST['model']}',
                                                reg_number='{$_POST['reg_number']}',
                                                vin_number='{$_POST['vin_number']}',
                                                reading_type='{$_POST['reading_type']}',
                                                {$query_reading}
                                                last_service='{$_POST['last_service']}',
                                                next_service='{$_POST['next_service']}',
                                                status='ready'
                                            ");
                if ($insert_plant) {
                    msg("plant {$_POST['vehicle_type']} was added!");
                    go("dashboard.php?page=open-plant");
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
