<?php

if (isset($_POST['submit'])) {
    if (
        $_POST['plant_id'] > 0
        && is_numeric($_POST['reading'])
        && strlen($_POST['reading_type']) > 0
        && date_create($_POST['date'])
    ) {

        $get_safety_equipment = dbq("select * from safety_equipment");
        if ($get_safety_equipment) {
            if (dbr($get_safety_equipment) > 0) {
                while ($equipment = dbf($get_safety_equipment)) {
                    if ($_POST[$equipment['code']] == 'on') {
                        $answer = 'Yes';
                    } else {
                        $answer = 'No';
                    }

                    $safety_stuff[] = [
                        'name' => $equipment['name'],
                        'answer' => $answer
                    ];
                }
            }
        }

        if (isset($safety_stuff)) {
            $safety_stuff = base64_encode(json_encode($safety_stuff));
        } else {
            $safety_stuff = '';
        }

        $engine_fault = ($_POST['engine_fault'] == 'Yes' ? 1 : 0);
        $cooling_system_fault = ($_POST['cooling_system_fault'] == 'Yes' ? 1 : 0);
        $hydraulics_fault = ($_POST['hydraulics_fault'] == 'Yes' ? 1 : 0);
        $instruments_fault = ($_POST['instruments_fault'] == 'Yes' ? 1 : 0);
        $brakes_fault = ($_POST['brakes_fault'] == 'Yes' ? 1 : 0);
        $body_work_fault = ($_POST['body_work_fault'] == 'Yes' ? 1 : 0);
        $steering_fault = ($_POST['steering_fault'] == 'Yes' ? 1 : 0);
        $glass_mirrors_fault = ($_POST['glass_mirrors_fault'] == 'Yes' ? 1 : 0);
        $tracks_carriage_tyres_fault = ($_POST['tracks_carriage_tyres_fault'] == 'Yes' ? 1 : 0);
        $electrical_batteries_fault = ($_POST['electrical_batteries_fault'] == 'Yes' ? 1 : 0);
        $gear_clutch_fault = ($_POST['gear_clutch_fault'] == 'Yes' ? 1 : 0);

        if (
            $engine_fault
            || $cooling_system_fault
            || $hydraulics_fault
            || $instruments_fault
            || $brakes_fault
            || $body_work_fault
            || $glass_mirrors_fault
            || $tracks_carriage_fault
            || $electrical_batteries_fault
            || $gear_clutch_fault
        ) {
            $status = 'F';
        } else {
            $status = 'G';
        }

        $add_jobcard = dbq("insert into ws_defect_reports set
                                    date='{$_POST['date']}',
                                    inspector_id={$_SESSION['user']['user_id']},
                                    plant_id={$_POST['plant_id']},
                                    reading='{$_POST['reading']}',
                                    operator_id={$_POST['driver_id']},
                                    site='{$_POST['site']}',
                                    extras='{$safety_stuff}',
                                    engine_fault={$engine_fault},
                                    engine_comment='{$_POST['engine_comment']}',
                                    cooling_system_fault={$cooling_system_fault},
                                    cooling_system_comment='{$_POST['cooling_system_comment']}',
                                    gear_clutch_fault={$gear_clutch_fault},
                                    gear_clutch_comment='{$_POST['gear_clutch_comment']}',
                                    electrical_batteries_fault={$electrical_batteries_fault},
                                    electrical_batteries_comment='{$_POST['electrical_batteries_comment']}',
                                    hydraulics_fault={$hydraulics_fault},
                                    hydraulics_comment='{$_POST['hydraulics_comment']}',
                                    instruments_fault={$instruments_fault},
                                    instruments_comment='{$_POST['instruments_comment']}',
                                    brakes_fault={$brakes_fault},
                                    brakes_comment='{$_POST['brakes_comment']}',
                                    body_work_fault={$body_work_fault},
                                    body_work_comment='{$_POST['body_work_comment']}',
                                    steering_fault={$steering_fault},
                                    steering_comment='{$_POST['steering_comment']}',
                                    glass_mirrors_fault={$glass_mirrors_fault},
                                    glass_mirrors_comment='{$_POST['glass_mirrors_comment']}',
                                    tracks_carriage_tyres_fault={$tracks_carriage_tyres_fault},
                                    tracks_carriage_tyres_comment='{$_POST['tracks_carriage_tyres_comment']}',
                                    status='{$status}'
                                    ");
        if ($add_jobcard) {

            msg("Defect report added.");
            go('dashboard.php?page=');
        } else {
            sqlError('Adding job card', 'adding job card');
        }
    } else {
        error("Required filed missing: Plant, Site and clerk");
    }
}
