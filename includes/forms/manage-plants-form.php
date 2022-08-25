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
        $chk_duplicate_reg = dbq("select * from plants_tbl where reg_number='{$_POST['reg_number']}' and reg_number!='{$plant_['reg_number']}'");
        if (dbr($chk_duplicate_reg) == 0) {
            $chk_duplicate_reg = dbq("select * from plants_tbl where vin_number='{$_POST['vin_number']}' and vin_number!='{$plant_['vin_number']}'");
            if (dbr($chk_duplicate_reg) == 0) {
                $update_plant = dbq("update plants_tbl set 
                                        vehicle_type='{$_POST['vehicle_type']}',
                                        make='{$_POST['make']}',
                                        model='{$_POST['model']}',
                                        reg_number='{$_POST['reg_number']}',
                                        vin_number='{$_POST['vin_number']}',
                                        km_reading='{$_POST['km_reading']}',
                                        last_service='{$_POST['last_service']}',
                                        next_service='{$_POST['next_service']}',
                                        status='{$_POST['status']}'
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

    ) {

        $chk_duplicate_reg = dbq("select * from plants_tbl where reg_number='{$_POST['reg_number']}'");
        if (dbr($chk_duplicate_reg) == 0) {
            $chk_duplicate_reg = dbq("select * from plants_tbl where vin_number='{$_POST['vin_number']}'");
            if (dbr($chk_duplicate_reg) == 0) {
                $insert_plant = dbq("insert into plants_tbl set                                            
                                                vehicle_type='{$_POST['vehicle_type']}',
                                                make='{$_POST['make']}',
                                                model='{$_POST['model']}',
                                                reg_number='{$_POST['reg_number']}',
                                                vin_number='{$_POST['vin_number']}',
                                                km_reading='{$_POST['km_reading']}',
                                                last_service='{$_POST['last_service']}',
                                                next_service='{$_POST['next_service']}',
                                                status='Ready'
                                            ");
                if ($insert_plant) {
                    msg("plant {$_POST['vehicle_type']} was added!");
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
