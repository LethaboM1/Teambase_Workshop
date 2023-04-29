<?php
require_once "./check.php";

switch ($_GET['cmd']) {
    case 'get_drivers':
        if (isset($_GET['plant_id'])) {
            $get_drivers = dbq("select concat(name,' ',last_name) as name, user_id as value from users_tbl where user_id in (select user_id from plant_user_tbl where plant_id={$_GET['plant_id']})");
            $select_[] = ['name' => 'None', 'value' => 0];

            if ($get_drivers) if (dbr($get_drivers)) while ($driver = dbf($get_drivers)) $select_[] = $driver;

            echo inp('driver_id', 'Driver/Operator', 'select', '', '', 0, $select_);
        }

        break;
    case "print_request":
        if (isset($_GET['id'])) {
            $request_file = 'files/requisitions/' . $_GET['id'] . '_request.pdf';
            saveRequisition($_GET['id']);
            if (file_exists('../' . $request_file)) {
                $json_['status'] = 'ok';
                $json_['path'] = $request_file;
            } else {
                $json_['status'] = 'error';
                $json_['message'] = 'Could not create / find file.' . __DIR__;
            }
        } else {
            $json_['status'] = 'error';
            $json_['message'] = '';
        }

        if (isset($json_)) {
            echo json_encode($json_);
        }
        break;
}

switch ($_POST['cmd']) {

    case 'set_part_number':
        if (isset($_POST['id']) && isset($_POST['value'])) {
            $update_ = dbq("update jobcard_requisition_parts set
                                    part_number='{$_POST['value']}'
                                    where id={$_POST['id']}");
            if ($update_) {
                $json_['status'] = 'ok';
            } else {
                $json_['status'] = 'error';
                $json_['message'] = 'SQl error: ' . dbe();
            }
        }

        echo json_encode($json_);

        break;

    case "set_part_supplier":
        if (isset($_POST['id'])) {
            $update_ = dbq("update jobcard_requisition_parts set
                                    supplier='{$_POST['value']}'
                                    where id={$_POST['id']}");
            if ($update_) {
                $json_['status'] = 'ok';
            } else {
                $json_['status'] = 'error';
                $json_['message'] = 'SQl error: ' . dbe();
            }
        }

        echo json_encode($json_);
        break;

    case "set_part_purchase_order":
        if (isset($_POST['id'])) {
            $update_ = dbq("update jobcard_requisition_parts set
                                    purchase_order='{$_POST['value']}'
                                    where id={$_POST['id']}");
            if ($update_) {
                $json_['status'] = 'ok';
            } else {
                $json_['status'] = 'error';
                $json_['message'] = 'SQl error: ' . dbe();
            }
        }

        echo json_encode($json_);
        break;

    case "set_part_date_eta":
        if (isset($_POST['id'])) {
            $update_ = dbq("update jobcard_requisition_parts set
                                    date_eta='{$_POST['value']}'
                                    where id={$_POST['id']}");
            if ($update_) {
                $json_['status'] = 'ok';
            } else {
                $json_['status'] = 'error';
                $json_['message'] = 'SQl error: ' . dbe();
            }
        }

        echo json_encode($json_);
        break;

    case 'set_part_status':
        if (isset($_POST['id'])) {
            $update_ = dbq("update jobcard_requisition_parts set
                                    status='{$_POST['value']}'
                                    where id={$_POST['id']}");
            if ($update_) {
                $json_['status'] = 'ok';
            } else {
                $json_['status'] = 'error';
                $json_['message'] = 'SQl error: ' . dbe();
            }
        }

        echo json_encode($json_);
        break;

    case 'delete_requisition_part':
        if ($_POST['id'] > 0 && is_numeric($_POST['id'])) {
            $json_['status'] = 'ok';
            $get_request_part = dbq("select * from jobcard_requisition_parts where id={$_POST['id']}");
            if ($get_request_part) {
                $request_part = dbf($get_request_part);

                $delete = dbq("delete from jobcard_requisition_parts where id={$_POST['id']}");
                $get_parts = dbq("select * from jobcard_requisition_parts where request_id={$request_part['request_id']}");
                unset($part_status_);
                $part_status_ = [
                    ['name' => '---', 'value' => ''],
                    ['name' => 'Ordered', 'value' => 'ordered'],
                    ['name' => 'Received', 'value' => 'received'],
                    ['name' => 'Completed', 'value' => 'completed'],
                    ['name' => 'Canceled', 'value' => 'canceled'],
                    ['name' => 'Rejected', 'value' => 'rejected']
                ];

                if ($get_parts) {
                    if (dbr($get_parts) > 0) {
                        $json_['html'] = '';
                        while ($part = dbf($get_parts)) {
                            $json_['html'] .= "<tr>
                                <td>{$part['component']}</td>
                                <td>{$part['part_number']}</td>
                                <td>{$part['part_description']}</td>
                                <td>";
                            if ($_SESSION['user']['role'] == 'manager' && $row['status'] == 'requested') {
                                $json_['html'] .= inp("{$part['id']}_part_qty", '', 'text', $part['qty'], '', 0, '', " style='width:80px;'");
                            } else {
                                $json_['html'] .= $part['qty'];
                            }


                            $json_['html'] .= " </td>
                                <td><span id='{$part['id']}_div'></span></td>
                                <td>{$part['comment']}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><span id='id_{$part['id']}'></span></td>
                                <td>
                                    <button type='button' onclick='del_req_part{`{$part['id']}`,`{$part['request_id']}`}' class='btn btn-xs btn-warning'><i class='fa fa-trash'></i></button>
                                    <script>
                                    $('#{$part['id']}_part_qty').change(function () {
                                        $.ajax({
                                            method:'post',
                                            url:'includes/ajax.php',
                                            data: {
                                                cmd:'qty_ajust',
                                                id: '{$part['id']}',
                                                request_id: '{$job_request['request_id']}',
                                                qty: $(this).val()
                                            },
                                            success: function (result) {
                                                let data = JSON.parse(result);
                                                    
                                                if (data.status=='ok') {																						
                                                    $('#{$part['id']}_div').html(`<i class='fa fa-check text-success'></i>`);
                                                } else {																						
                                                    $('#{$part['id']}_div').html(`<i class='fa fa-times text-danger'></i>`);
                                                }
                                            },
                                            error: function () {}
                                        });
                                    });
                                    </script>
                                </td>
                            </tr>";
                        }
                    } else {
                        $json_['html'] .= "<tr><td colspan='5'>Nothing</td></tr>";
                    }
                } else {
                    $json_['html'] .= "<tr><td colspan='5'>" . dbe() . "</td></tr>";
                }
            }
            echo json_encode($json_);
        }

        break;


    case "save_service_checklist":
        $get_service_checklist = dbq("select * from service_checklist");
        if ($get_service_checklist) {
            if (dbr($get_service_checklist) > 0) {
                $service_type = strtolower($_POST['service_type']) . '_service';
                while ($item = dbf($get_service_checklist)) {
                    if ($item[$service_type] == "0" || $item[$service_type] == "C") {

                        $answer = $_POST['check_' . $item['checklist_id']];

                        $service_checklist[$item['checklist_id']] = ['question' => $item['question'], 'answer' => $answer];
                    }
                }
            } else {
                error("There is no service check list.");
            }
        } else {
            sqlError();
        }

        if (isset($service_checklist)) {
            //error("<pre>" . print_r($service_checklist, true) . "</pre>");
            $service_checklist = base64_encode(json_encode($service_checklist));
            if ($_POST['job_id'] > 0) {
                $save_propgress = dbq("update jobcards set
                                        service_checklist='{$service_checklist}'
                                        where job_id={$_POST['job_id']}");
                if ($save_propgress) {
                    $jobcard_['service_checklist'] = $service_checklist;
                } else {
                    sqlError();
                }
            } else {
            }
        } else {
            error("There are no items in service checklist table.");
        }

        if (!isset($error)) {
            echo json_encode(['status', 'ok']);
        }
        break;

    case "remove_insp":
        if (isset($_POST['component'])) {

            $key = array_search($_POST['component'], array_column($_SESSION['fault_reports'], 'component'));
            //error_log("key = {$key}," . print_r($_SESSION['fault_reports'][$key], true));
            unset($_SESSION['fault_reports'][$key]);

            $html = '';
            foreach ($_SESSION['fault_reports'] as $report) {
                $html .= "<tr>
                            <td>{$report['component']}</td>
                            <td>{$report['severity']}</td>
                            <td>{$report['hours']}</td>
                            <td>{$report['comment']}</td>
                            <td>
                                <a onclick='remove_insp(`{$report['component']}`)'><i class='fa fa-trash'></i></a>                                                            
                            </td>
                        </tr>";
            }

            if (strlen($html) == 0) {
                $html .= "<tr>
                            <td colspan='5'>No fault / inspections reports</td>
                        </tr>";
            }

            $json_['reports'] = $html;
            $json_['status'] = 'ok';
            echo json_encode($json_);
        } else {
            $json_['status'] = 'ok';
            $json_['message'] = 'no part no';
            echo json_encode($json_);
        }
        break;

    case 'add_defect_insp':
    case "add_insp":

        $report = json_decode($_POST['insp'], true);

        if (!isset($report['hours']) && $_POST['cmd'] == 'add_insp') {
            $json_['status'] = 'error';
            $json_['message'] = 'No hours';
            echo json_encode($json_);
            return;
        }

        if (strlen($report['component']) == 0) {
            $json_['status'] = 'error';
            $json_['message'] = 'No component';
            echo json_encode($json_);
            return;
        }

        if (strlen($report['severity']) == 0) {
            $json_['status'] = 'error';
            $json_['message'] = 'No severity';
            echo json_encode($json_);
            return;
        }

        if (!is_numeric($report['hours']) && $_POST['cmd'] == 'add_insp') {
            $json_['status'] = 'error';
            $json_['message'] = 'invalid hours';
            echo json_encode($json_);
            return;
        }

        if (is_array($_SESSION['fault_reports'])) {
            if (in_array($report['component'], array_column($_SESSION['fault_reports'], 'component'))) {
                $key = array_search($report['component'], array_column($_SESSION['fault_reports'], 'component'));
                if ($_POST['cmd'] == 'add_insp') $_SESSION['fault_reports'][$key]['hours'] += $report['hours'];
                $_SESSION['fault_reports'][$key]['severity'] = $report['severity'];
                $_SESSION['fault_reports'][$key]['comment'] .= '. ' . $report['comment'];

                $html = '';
                foreach ($_SESSION['fault_reports'] as $report) {
                    $html .= "<tr>
                                <td>{$report['component']}</td>
                                <td>{$report['severity']}</td>"
                        . ($_POST['cmd'] == 'add_insp' ? "<td>{$report['hours']}</td>" : "")
                        . "<td>{$report['comment']}</td>
                                <td>
                                    <a onclick='remove_insp(`{$report['component']}`)'><i class='fa fa-trash'></i></a>                                                            
                                </td>
                            </tr>";
                }
                $json_['reports'] = $html;
                $json_['status'] = 'ok';
                echo json_encode($json_);
                return;
            }
        }

        $_SESSION['fault_reports'][] = $report;
        $json_['status'] = 'ok';
        $html = '';
        foreach ($_SESSION['fault_reports'] as $report) {
            $html .= "<tr>
                        <td>{$report['component']}</td>
                        <td>{$report['severity']}</td>
                        <td>{$report['hours']}</td>
                        <td>{$report['comment']}</td>
                        <td>
                            <a onclick='remove_insp(`{$report['component']}`)'><i class='fa fa-trash'></i></a>                                                            
                        </td>
                    </tr>";
        }
        $json_['reports'] = $html;
        echo json_encode($json_);
        return;
        break;

    case 'report_hours_ajust':
        if (is_numeric($_POST['hours'])) {
            if (
                isset($_POST['id']) > 0
                && isset($_POST['job_id']) > 0
            ) {
                $update = dbq("update jobcard_reports set
                                    hours={$_POST['hours']}"
                    . ($_SESSION['user']['role'] == 'manager' && $_SESSION['user']['role'] == 'system' ? ", reviewed=1" : "") . "
                                    where id={$_POST['id']} and job_id={$_POST['job_id']}");
                if ($update) {
                    $hours = dbf(dbq("select sum(hours) as hours from jobcard_reports where job_id={$_POST['job_id']} and reviewed=1"));
                    if (!is_numeric($hours['hours'])) {
                        $hours['hours'] = 0;
                    }

                    if ($_SESSION['user']['role'] == 'manager' || $_SESSION['user']['role'] == 'system') {
                        $update_ = dbq("update jobcards set allocated_hours={$hours['hours']} where job_id={$_POST['job_id']}");
                        if (!$update_) error_log("SQL Error: " . dbe());
                        $json_['hours'] = $hours['hours'];
                    }

                    $json_['status'] = 'ok';
                } else {
                    $json_['status'] = 'error';
                    $json_['message'] = 'invalid id, request id.';
                }
            } else {
                $json_['status'] = 'error';
                $json_['message'] = 'invalid id, request id.';
            }
        } else {
            $json_['status'] = 'error';
            $json_['message'] = 'invalid qty.';
        }

        if (isset($json_)) {
            echo json_encode($json_);
        }
        break;

    case "qty_ajust":
        if (is_numeric($_POST['qty'])) {
            if (
                isset($_POST['id']) > 0
                && isset($_POST['request_id']) > 0
            ) {
                $update = dbq("update jobcard_requisition_parts set
                                    qty={$_POST['qty']}
                                    where id={$_POST['id']} and request_id={$_POST['request_id']}");
                if ($update) {
                    $json_['status'] = 'ok';
                } else {
                    $json_['status'] = 'error';
                    $json_['message'] = 'invalid id, request id.';
                }
            } else {
                $json_['status'] = 'error';
                $json_['message'] = 'invalid id, request id.';
            }
        } else {
            $json_['status'] = 'error';
            $json_['message'] = 'invalid qty.';
        }

        if (isset($json_)) {
            echo json_encode($json_);
        }

        break;

    case "remove_part":
        if (isset($_POST['description'])) {
            $key = array_search($_POST['description'], array_column($_SESSION['request_parts'], 'description'));

            unset($_SESSION['request_parts'][$key]);
            sort($_SESSION['request_parts']);


            $html = '';
            foreach ($_SESSION['request_parts'] as $part) {
                $html .= "<tr>
                        <td>{$part['part_no']}</td>
                        <td>{$part['description']}</td>
                        <td>{$part['qty']}</td>
                        <td>{$part['comment']}</td>
                        <td>
                            <a class='pointer' onclick='remove_part(`{$part['description']}`);'>
                                <i class='fa fa-trash'></i>
                            </a>
                        </td>
                    </tr>";
            }

            $json_['parts'] = $html;
            $json_['status'] = 'ok';
            $json_['session_key'] = $key;
            echo json_encode($json_);
        } else {
            $json_['status'] = 'ok';
            $json_['message'] = 'no part no';
            echo json_encode($json_);
        }
        break;

    case "add_part":

        $part = json_decode($_POST['part'], true);

        if (!isset($part['component']) || strlen($part['component']) == 0) {
            $json_['status'] = 'error';
            $json_['message'] = 'No component';
            echo json_encode($json_);
            return;
        }

        if (!isset($part['description'])) {
            $json_['status'] = 'error';
            $json_['message'] = 'No description';
            echo json_encode($json_);
            return;
        }

        if (!is_numeric($part['qty'])) {
            $json_['status'] = 'error';
            $json_['message'] = 'invalid qty';
            echo json_encode($json_);
            return;
        }

        if (is_array($_SESSION['request_parts'])) {
            if (in_array($part['description'], array_column($_SESSION['request_parts'], 'description'))) {
                $key = array_search($part['description'], array_column($_SESSION['request_parts'], 'description'));
                $_SESSION['request_parts'][$key]['qty'] += $part['qty'];
                $html = '';
                foreach ($_SESSION['request_parts'] as $part) {
                    $html .= "<tr>
                                <td>{$part['component']}</td>
                                <td>{$part['part_no']}</td>
                                <td>{$part['description']}</td>
                                <td>{$part['qty']}</td>
                                <td>{$part['comment']}</td>
                                <td>
                                    <a class='pointer' onclick='remove_part(`{$part['description']}`)'>
                                        <i class='fa fa-trash'></i>
                                    </a>
                                </td>
                            </tr>";
                }
                $json_['parts'] = $html;
                $json_['status'] = 'ok';
                echo json_encode($json_);
                return;
            }
        }

        $_SESSION['request_parts'][] = $part;
        $json_['status'] = 'ok';
        $html = '';
        foreach ($_SESSION['request_parts'] as $part) {
            $html .= "<tr>
                        <td>{$part['component']}</td>
                        <td>{$part['part_no']}</td>
                        <td>{$part['description']}</td>
                        <td>{$part['qty']}</td>
                        <td>{$part['comment']}</td>
                        <td>
                            <a class='pointer' onclick='remove_part(`{$part['description']}`)'>
                                <i class='fa fa-trash'></i>
                            </a>
                        </td>
                    </tr>";
        }
        $json_['parts'] = $html;
        echo json_encode($json_);
        return;
        break;

    case "remove_image";
        unset($_SESSION['upload_images'][$_POST['key']]);

        if (isset($_SESSION['upload_images'])) {
            if (count($_SESSION['upload_images']) > 0) {
                echo    "<div class='row'>";
                foreach ($_SESSION['upload_images'] as $key => $image) {

                    echo "<div class='col-md-3'>
                            <i onclick='remImage(`{$key}`)' class='fa fa-times fa-2x removeX'></i>
                            <img width='200px' src='{$image['image']}' />
                        </div>";
                }
                echo    "</div>";
            }
        }
        break;

    case "upload_img":
        /*

            Upload Image

        */

        if (isset($_SESSION['upload_images'])) {
            $amount = count($_SESSION['upload_images']);
        } else {
            $amount = 0;
        }

        if ($amount >= $_POST['limit']) {
            echo "<small>{$_POST['limit']} photos max</small>
            <div class='row'>";
            foreach ($_SESSION['upload_images'] as $key => $image) {

                echo "<div class='col-md-3'>
                            <i onclick='remImage(`{$key}`)' class='fa fa-times fa-2x removeX'></i>
                            <img width='200px' src='{$image['image']}' /></div>";
            }
            echo    "</div>";
            exit();
        }

        if (strlen($_POST['image']) > 20) {
            $_SESSION['upload_images'][] = [
                'image' => $_POST['image'],
                'type' => $_POST['type']
            ];
        }

        if (isset($_SESSION['upload_images'])) {
            if (count($_SESSION['upload_images']) > 0) {
                echo    "<div class='row'>";
                foreach ($_SESSION['upload_images'] as $key => $image) {
                    echo "<div class='col-md-3'>
                            <i onclick='remImage(`{$key}`)' class='fa fa-times fa-2x removeX'></i>
                            <img width='200px' src='{$image['image']}' />
                        </div>";
                }
                echo    "</div>";
            } else {
                echo "<p>Images Zero</p>";
            }
        } else {
            echo "<p>Images not set</p>";
        }


        break;

    case "search":
        switch ($_POST['type']) {
            case "plant-checklists":
                $get_checklists = dbq("select * from checklist_results where
                (
                    datetime like '%{$_POST['search']}%'
                    || plant_id in (select plant_id from plants_tbl where plant_number like '{$_POST['search']}%') 
                    || user_id in (select user_id from users_tbl where (name like '{$_POST['search']}%' or last_name like '{$_POST['search']}%'))
                ) order by datetime DESC");

                if ($get_checklists) {
                    if (dbr($get_checklists) > 0) {
                        while ($row = dbf($get_checklists)) {
                            require "pages/manager/plants/list_checklists.php";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Nothing found for '{$_POST['search']}'</td></tr>";
                    }
                }
                break;

            case "open-jobs":
                if ($_SESSION['user']['role'] == 'mechanic') {
                    $query_ = " and mechanic_id={$_SESSION['user']['user_id']}";
                } else {
                    $query_ = " || mechanic_id in (select user_id as mechanic_id from users_tbl where role='mechanic' and (name like '{$_POST['search']}%' or last_name like '{$_POST['search']}%'))";
                }

                // $get_users = dbq("select * from jobcards where (jobcard_number like '%{$_POST['search']}%' || fleet_number like '%{$_POST['search']}%') and (status='busy' || status='open'){$query_}");
                // if ($get_users) {
                //     if (dbr($get_users) > 0) {
                //         while ($row = dbf($get_users)) {
                //             $items_list[] = $row;
                //         }
                //     }
                // }

                // $get_users = dbq("select * from jobcards where (status='busy' || status='open') and logged_by in (select user_id as logged_by from users_tbl where (name like '#" . esc($_POST['search']) . "#' || name like '#" . esc($_POST['search']) . "#')");


                $get_users = dbq("select * from jobcards where (
                                    jobcard_number like '%{$_POST['search']}%' 
                                    || plant_id in (select plant_id from plants_tbl where plant_number like '%{$_POST['search']}%')                                     
                                    {$query_}
                                    )");

                if ($get_users) {
                    if (dbr($get_users) > 0) {
                        while ($row = dbf($get_users)) {
                            $items_list[] = $row;
                        }
                    }
                }

                if (isset($items_list)) {
                    if (count($items_list) > 0) {
                        foreach ($items_list as $row) {
                            ($_SESSION['user']['role'] == 'mechanic') ? require "pages/mechanic/list_open_jobcards.php" : require "pages/manager/jobcards/list_open_jobcards.php";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Could not find '{$_POST['search']}'</td></tr>";
                    }
                }

                break;

            case "completed-jobs":
                $get_users = dbq("select * from jobcards where (jobcard_number like '%{$_POST['search']}%' || fleet_number like '%{$_POST['search']}%') and status='completed'");
                if ($get_users) {
                    if (dbr($get_users) > 0) {
                        while ($row = dbf($get_users)) {
                            $items_list[] = $row;
                        }
                    }
                }

                $get_users = dbq("select * from jobcards where status='completed' and logged_by in (select user_id as logged_by from users_tbl where (name like '#" . esc($_POST['search']) . "#' || name like '#" . esc($_POST['search']) . "#')");
                if ($get_users) {
                    if (dbr($get_users) > 0) {
                        while ($row = dbf($get_users)) {
                            $items_list[] = $row;
                        }
                    }
                }

                if (isset($items_list)) {
                    if (count($items_list) > 0) {
                        foreach ($items_list as $row) {
                            require "pages/manager/jobcards/list_completed_jobcards.php";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Could not find '{$_POST['search']}'</td></tr>";
                    }
                }

                break;


            case "users":
                $get_users = dbq("select * from users_tbl where (name like '%{$_POST['search']}%' || last_name like '%{$_POST['search']}%' || email like '%{$_POST['search']}%') and role!='system'");
                if ($get_users) {
                    if (dbr($get_users) > 0) {
                        while ($row = dbf($get_users)) {
                            require "pages/manager/users/list_users.php";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Could not find '{$_POST['search']}'</td></tr>";
                    }
                }
                break;

            case "tyre-report-list";
                $get_tyre_report = dbq("select * from jobcard_tyre_reports where checked_by>0 
                and 
                (  job_id in (select job_id from jobcards where jobcard_number like '%{$_POST['search']}%') 
                    || checked_by in (select user_id as checked_by from users_tbl where role='mechanic' and (name like '{$_POST['search']}%' or last_name like '{$_POST['search']}%'))
                ) order by date_time DESC");

                if ($get_tyre_report) {
                    if (dbr($get_tyre_report) > 0) {
                        while ($row = dbf($get_tyre_report)) {
                            require "pages/manager/jobcards/list_job_tyre_reports_all.php";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Nothing to list: searched '{$_POST['search']}'</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>SQL error: " . dbe() . "</td></tr>";
                }
                break;

            case "plants":
                $get_plants = dbq("select * from plants_tbl where (
                                    vehicle_type like '%{$_POST['search']}%' 
                                    || reg_number like '%{$_POST['search']}%' 
                                    || vin_number like '%{$_POST['search']}%'
                                    || make like '%{$_POST['search']}%'
                                    || model like '%{$_POST['search']}%'
                                    )");
                if ($get_plants) {
                    if (dbr($get_plants) > 0) {
                        while ($row = dbf($get_plants)) {
                            require "pages/manager/plants/list_plants.php";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Could not find '{$_POST['search']}'</td></tr>";
                    }
                }
                break;

            case "user-plants":
                $get_plants = dbq("select * from plants_tbl where  (
                                        vehicle_type like '%{$_POST['search']}%' 
                                        || reg_number like '%{$_POST['search']}%' 
                                        || vin_number like '%{$_POST['search']}%'
                                        || make like '%{$_POST['search']}%'
                                        || model like '%{$_POST['search']}%'
                                        ) and plant_id in (select plant_id from plat_user_tbl where user_id={$_POST['user_id']})");
                if ($get_plants) {
                    if (dbr($get_plants) > 0) {
                        while ($row = dbf($get_plants)) {
                            require "pages/user/list_plants.php";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Could not find '{$_POST['search']}'</td></tr>";
                    }
                }
                break;

            case "job-requisitions-completed":
                if ($_SESSION['user']['role'] == 'clerk') {
                    $query_ = " and clerk_id={$_SESSION['user']['user_id']}";
                } else if ($_SESSION['user']['role'] == 'buyer') {
                    $query_ = " and buyer_id={$_SESSION['user']['user_id']}";
                } else if ($_SESSION['user']['role'] == 'mechanic') {
                    $query_ = " and requested_by-{$_SESSION['user']['user_id']}";
                } else {
                    $query_ = "";
                }

                $get_requisitions = dbq("select * from jobcard_requisitions where (status='completed' || status='canceled' || status='rejected'){$query_} 
                            and 
                            (
                                request_id='{$_POST['search']}'
                                || plant_id in (select plant_id from plants_tbl where plant_number like '{$_POST['search']}%') 
                                || job_id in (select job_id from jobcards where jobcard_number like '%{$_POST['search']}%') 
                                || requested_by in (select user_id as requested_by from users_tbl where role='mechanic' and (name like '{$_POST['search']}%' or last_name like '{$_POST['search']}%'))
                            ) order by datetime DESC");
                if (!$get_requisitions) error_log('SQL: ' . dbe());
                if (dbr($get_requisitions) > 0) while ($row = dbf($get_requisitions))  $search_results[] = $row;
                if (is_array($search_results) && count($search_results) > 0) {
                    foreach ($search_results as $row) {
                        require "pages/manager/jobcards/list_job_requisitions_completed.php";
                    }
                } else {
                    echo "<tr><td style='column-span: all;'>Nothing found</td></tr>";
                }
                break;

            case "job-card-archive":

                if ($_SESSION['user']['role'] == 'clerk') {
                    $query_ = " and clerk_id={$_SESSION['user']['user_id']}";
                } else {
                    $query_ = '';
                }

                $get_jobcards = dbq("select * from jobcards where status='closed'{$query_} and (jobcard_number like '%{$_POST['search']}%' || mechanic_id in (select user_id as mechanic_id from users_tbl where role='mechanic' and (name like '{$_POST['search']}%' or last_name like '{$_POST['search']}%')) || plant_id in (select plant_id from plants_tbl where plant_number like '{$_POST['search']}%'))");
                if (dbr($get_jobcards) > 0) while ($row = dbf($get_jobcards)) $search_results[] = $row;

                if (is_array($search_results) && count($search_results) > 0) {
                    foreach ($search_results as $row) {
                        require "pages/manager/jobcards/list_archive_jobcards.php";
                    }
                } else {
                    echo "<tr><td style='column-span: all;'>Nothing found</td></tr>";
                }


                break;
        }
        break;

    case "get_plant_details":
        $get_plant = dbq("select * from plants_tbl where plant_id='{$_POST['plant_id']}'");
        if ($get_plant) {
            if (dbr($get_plant) > 0) {
                $plant_ = dbf($get_plant);
                $json_['status'] = 'ok';
                $json_['result'] = $plant_;
            } else {
                $json_['status'] = 'error';
                $json_['status'] = 'No plants found';
            }
        } else {
            $json_['status'] = 'error';
            $json_['status'] = 'SQL error: ' . dbe();
        }

        echo json_encode($json_);
        break;

    case "remove_user_plant":
        echo inp('user_id', '', 'hidden', $_POST['user_id'])
            . inp('plant_id', '', 'hidden', $_POST['plant_id'])
            . "<div class='modal-text'>
                <p>Are you sure that you want to remove this user from the plant?</p>
            </div>";

        break;

    case "get_users_plant":
        $get_users = dbq("select * from users_tbl where role='user' and user_id not in (select user_id from plant_user_tbl where plant_id='{$_POST['plant_id']}')");
        if ($get_users) {
            echo "<table class='table table-responsive-md mb-0'>
                    <thead>
                        <tr>                            
                            <th width='47'>Action</th>
                            <th >Name</th>
                            <th >Surname</th>
                            <th >Email</th>
                            <th >Contact Number</th>
                        </tr>
                    </thead>";
            if (dbr($get_users) > 0) {
                while ($user = dbf($get_users)) {
                    echo "<tr>                            
                            <th width='47'><input name='user_id[]' type='checkbox' value='{$user['user_id']}' /></th>
                            <th >{$user['name']}</th>
                            <th >{$user['last_name']}</th>
                            <th >{$user['email']}</th>
                            <th >{$user['contact_number']}</th>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No users available to allocate.</td></tr>";
            }
            echo "</table>";
        } else {
            echo "SQL Error: " . dbe();
        }
        break;

    case "get_del_plant";
        $get_plant = dbq("select * from plants_tbl where plant_id='{$_POST['plant_id']}'");
        if ($get_plant) {
            if (dbr($get_plant) > 0) {
                $plant_ = dbf($get_plant);
                echo inp('plant_id', '', 'hidden', $plant_['plant_id'])
                    . "<div class='modal-wrapper'>
                            <div class='modal-icon'>
                                <i class='fas fa-times-circle'></i>
                            </div>
                            <div class='modal-text'>
                                <h4>Danger</h4>
                                <p>Are you sure that you want to delete this plant {$plant_['vehicle_type']}, plant no. {$plant_['plant_number']}, fleet no. {$plant_['fleet_number']}?</p>
                            </div>
                        </div>";
            }
        }
        break;
    case "get_edit_plant":
        if (isset($_POST['plant_id'])) {
            $get_plant = dbq("select * from plants_tbl where plant_id='{$_POST['plant_id']}'");
            if ($get_plant) {
                if (dbr($get_plant) > 0) {
                    $plant_ = dbf($get_plant);

                    switch ($plant_['reading_type']) {
                        case "km":
                            $reading = $plant_['km_reading'];
                            break;

                        case "hr":
                            $reading = $plant_['hr_reading'];
                            break;
                    }

                    echo inp('plant_id', '', 'hidden', $plant_['plant_id'])
                        . "<div class='row'>
						<div class='col-sm-12 col-md-4 pb-sm-3 pb-md-0'>
							<label class='col-form-label' for='formGroupExampleInput'>Plant No.</label>
							<input type='text' name='plant_number' class='form-control' value='{$plant_['plant_number']}'>
						</div>
						<div class='col-sm-12 col-md-4 pb-sm-3 pb-md-0'>
							<label class='col-form-label' for='formGroupExampleInput'>Vehicle Type</label>
							<input type='text' name='vehicle_type' placeholder='Truck, TLB ...' class='form-control' value='{$plant_['vehicle_type']}'>
						</div>
						<div class='col-sm-12 col-md-4 pb-sm-3 pb-md-0'>
							<label class='col-form-label' for='formGroupExampleInput'>Make</label>
							<input type='text' name='make' placeholder='Make' class='form-control' value='{$plant_['make']}'>
						</div>
					</div>
					<div class='row'>
                        <div class='col-sm-12 col-md-4 pb-sm-3 pb-md-0'>
                            <label class='col-form-label' for='formGroupExampleInput'>Model</label>
                            <input type='text' name='model' placeholder='Model' class='form-control' value='{$plant_['model']}'>
                        </div>
						<div class='col-sm-12 col-md-4 pb-sm-3 pb-md-0'>
							<label class='col-form-label' for='formGroupExampleInput'>Registration Number</label>
							<input type='text' name='reg_number' placeholder='AAA-456-L' class='form-control' value='{$plant_['reg_number']}'>
						</div>
						<div class='col-sm-12 col-md-4 pb-sm-3 pb-md-0'>
							<label class='col-form-label' for='formGroupExampleInput'>VIN Number</label>
							<input type='text' name='vin_number' placeholder='VIN Number' class='form-control' value='{$plant_['vin_number']}'>
						</div>";

                    $reading_types_select_ = [
                        ['name' => 'KM - Kilometers', 'value' => 'km'],
                        ['name' => 'HR - Hours', 'value' => 'hr'],
                    ];

                    echo inp('reading_type', 'Type of reading', 'select', $plant_['reading_type'], '', 0, $reading_types_select_)
                        .   "
						<div class='col-sm-12 col-md-4 pb-sm-3 pb-md-0'>
							<label class='col-form-label' for='formGroupExampleInput'>Reading</label>
							<input type='text' name='reading' placeholder='KM Reading' class='form-control' value='{$reading}'>
						</div>
                        <div class='col-sm-12 col-md-4 pb-sm-3 pb-md-0'>
                            <label class='col-form-label' for='formGroupExampleInput'>Next Service Reading</label>
                            <input type='number' name='next_service_reading' placeholder='Next Service Reading' class='form-control' value='{$plant_['next_service_reading']}'>
                        </div>
                    </div>";
                }
            }
        }
        break;



    case "get_del_user";
        $get_user = dbq("select * from users_tbl where user_id='{$_POST['user_id']}'");
        if ($get_user) {
            if (dbr($get_user) > 0) {
                $user_ = dbf($get_user);
                echo inp('user_id', '', 'hidden', $user_['user_id'])
                    . "<div class='modal-wrapper'>
                        <div class='modal-icon'>
                            <i class='fas fa-times-circle'></i>
                        </div>
                        <div class='modal-text'>
                            <h4>Danger</h4>
                            <p>Are you sure that you want to delete this user {$user_['name']} {$user_['last_name']}?</p>
                        </div>
                    </div>";
            }
        }
        break;

    case "get_view_user";
        $get_user = dbq("select * from users_tbl where user_id='{$_POST['user_id']}'");
        if ($get_user) {
            if (dbr($get_user) > 0) {
                $user_ = dbf($get_user);
                echo "<b>Name</b>&nbsp;{$user_['name']} {$user_['last_name']}"
                    . inp('user_id', '', 'hidden', $user_['user_id']);

                if ($user_['out_of_office'] == 0) {
                    echo inp('out_of_office', '', 'submit', 'Out of Office', 'btn-primary');
                } else {
                    echo inp('back_at_office', '', 'submit', 'Back at Office', 'btn-primary');
                }
            }
        }
        break;

    case "get_edit_user":
        if (isset($_POST['user_id'])) {
            $get_user = dbq("select * from users_tbl where user_id='{$_POST['user_id']}'");
            if ($get_user) {
                if (dbr($get_user) > 0) {
                    $user_ = dbf($get_user);

                    echo inp('user_id', '', 'hidden', $user_['user_id'])
                        . "<div class='row'>
                            <div class='col-sm-12 col-md-4 pb-sm-3 pb-md-0'>
                                <label class='col-form-label' for='formGroupExampleInput'>First Name</label>
                                <input type='text' name='name' placeholder='First Name' class='form-control' value='{$user_['name']}'>
                            </div>
                            <div class='col-sm-12 col-md-4 pb-sm-3 pb-md-0'>
                                <label class='col-form-label' for='formGroupExampleInput'>Last Name</label>
                                <input type='text' name='last_name' placeholder='Last Name' class='form-control' value='{$user_['last_name']}'>
                            </div>
                            <div class='col-sm-12 col-md-4 pb-sm-3 pb-md-0'>
                                <label class='col-form-label' for='formGroupExampleInput'>ID Number</label>
                                <input name='id_number' data-plugin-masked-input data-input-mask='999999-9999-999' placeholder='______-____-___' class='form-control' value='{$user_['id_number']}'>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-12 col-md-4 pb-sm-3 pb-md-0'>
                                <label class='col-form-label' for='formGroupExampleInput'>Contact Number</label>
                                <input name='contact_number' data-plugin-masked-input data-input-mask='999-999-9999' placeholder='___-___-____' class='form-control' value='{$user_['contact_number']}'>
                            </div>
                            <div class='col-sm-12 col-md-4 pb-sm-3 pb-md-0'>
                                <label class='col-form-label' for='formGroupExampleInput'>Employee Number</label>
                                <input id='employee_number' type='text' name='employee_number' placeholder='Employee Number' class='form-control' value='{$user_['employee_number']}'>
                            </div>
                            <div class='col-sm-12 col-md-4 pb-sm-3 pb-md-0'>
                                <label class='col-form-label' for='company_number'>Company Number</label>
                                <input type='text' name='company_number' id='company_number' placeholder='Company Number' value='{$user_['company_number']}' class='form-control'>
                            </div>
                        </div>"
                        . inp('fake-creds', '', 'fake-creds')
                        . "<div class='row'>
                            <div class='col-sm-12 col-md-4 pb-sm-3 pb-md-0'>
                                <label class='col-form-label' for='formGroupExampleInput'>Username</label>
                                <input id='username' type='username' name='username' placeholder='Email Address' class='form-control' value='{$user_['username']}'>
                            </div>
                            <div class='col-sm-12 col-md-4 pb-sm-3 pb-md-0'>
                                <label title='Leave blank to keep password unchanged.' class='col-form-label' for='formGroupExampleInput'>Password</label>
                                <input title='Leave blank to keep password unchanged.' type='password' name='password' placeholder='Password' class='form-control'>
                            </div>
                            <div class='col-sm-12 col-md-4 pb-sm-3 pb-md-0'>
                                <label class='col-form-label' for='formGroupExampleInput'>Confirm Password</label>
                                <input type='password' name='confirmpassword' placeholder='Confirm Password' class='form-control'>
                            </div>
                            <div class='col-sm-12 col-md-4 pb-sm-3 pb-md-0'>
                                <label class='col-form-label' for='formGroupExampleInput'>User Roll</label>
                                <select name='role' class='form-control mb-3' id='roll'>";

                    foreach ($dash_roles as $role) {
                        if ($user_['role'] == $role) {
                            echo "<option selected='selected' value='{$role}'>" . ucfirst($role) . "</option>";
                        } else {
                            echo "<option value='{$role}'>" . ucfirst($role) . "</option>";
                        }
                    }


                    echo "          </select>
                            </div>
                            <div class='col-sm-12 col-md-4 pb-sm-3 pb-md-0'>
                                <label class='col-form-label' for='formGroupExampleInput'>Email Address</label>
                                <input id='email' type='email' name='email' placeholder='Email Address' class='form-control' value='{$user_['email']}'>
                            </div>
                            <div class='col-sm-12 col-md-4 pb-sm-3 pb-md-0'>
                                    <label class='col-form-label' for='photo-edt'>Photo</label>
                                <div class='input-group mb-3'>
                                    <input name='photo' id='photo-edt' type='file' style='display:none'>
                                        <input id='photo-box-edt' type='text' class='form-control'>
                                        <button id='photo-btn-edt' type='button' class='input-group-text'><i class='fa fa-image'></i></button>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-12 col-md-12 pb-sm-3 pb-md-0'>";

                    if (file_exists("../images/users/{$user_['user_id']}.jpg")) {
                        echo "<img style='width:150px;' src='images/users/{$user_['user_id']}.jpg' />";
                    }

                    echo " </div>
                        </div>";



                    echo "<script>
								$('#photo-btn-edt').click(function (){ 
									$('#photo-edt').click();

								});
								
								$('#photo-box-edt').click(function (){ 
									$('#photo-edt').click();
								});
						</script>
						";
                }
            }
        }
        break;
}
