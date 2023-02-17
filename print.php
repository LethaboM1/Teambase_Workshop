<?php
require_once "includes/check.php";

if (isset($_POST['html_code'])) {
    $html = $_POST['html_code'];
    printPDF($html);
}

switch ($_GET['type']) {
    case "job-card":
        if (isset($_GET['id'])) {
            $get_jobcard = dbq("select * from jobcards where job_id={$_GET['id']}");
            if ($get_jobcard) {
                if (dbr($get_jobcard) > 0) {
                    $jobcard_ = dbf($get_jobcard);
                    $plant_ = dbf(dbq("select * from plants_tbl where plant_id={$jobcard_['plant_id']}"));
                    $mechanic_ = dbf(dbq("select name, last_name,employee_number from users_tbl where user_id={$jobcard_['mechanic_id']}"));
                    $logged_by = dbf(dbq("select name, last_name,employee_number from users_tbl where user_id={$jobcard_['logged_by']}"));
                    $authorized_by = dbf(dbq("select name, last_name,employee_number from users_tbl where user_id={$jobcard_['authorized_by']}"));
                    $extras = json_decode(base64_decode($jobcard_['safety_audit']), true);

                    $font = ""; //"font-family: 'Open Sans', sans-serif;";
                    $pdf = "
                            <table style=\"width: 700px; border-collapse: collapse; table-layout: fixed;\"> 
                                <tr>
                                    <th style=\"width: 50%; font-weight: bold; font-size: 20px; text-align: left; border: none;\">Job Card # {$jobcard_['jobcard_number']}</th>
                                    <th style=\"width: 50%; font-weight: bold; font-size: 20px; text-align: left; border: none;\">Plant # {$plant_['plant_number']}</th>
                                </tr> 
                            </table>
                            <br>
                            <table style=\"width: 700px; border-collapse: collapse; table-layout: fixed;\">
                                <tr>
                                    <td style=\"width: 50%; font-weight: normal; font-size: 13px; text-align: left; border: 1.5px solid rgb(39, 39, 39); border-bottom: none; padding-left: 5px; padding-top: 5px;\"><strong>Status:</strong> " . ucfirst($jobcard_['status']) . "</td>
                                    <td style=\"width: 50%; font-weight: normal; font-size: 13px; text-align: left; border: 1.5px solid rgb(39, 39, 39); border-left: none; border-bottom: none; padding-left: 5px; padding-top: 5px;\"><strong>Type:</strong> " . ucfirst($jobcard_['jobcard_type']) . "</td>
                                </tr>
                                <tr>
                                    <td style=\"width: 50%;  font-weight: normal; font-size: 13px; text-align: left; border: 1.5px solid rgb(39, 39, 39); border-bottom: none; border-top: none; padding-left: 5px;\"><strong>Date:</strong> " . date('Y-m-d', strtotime($jobcard_['job_date'])) . "</td>
                                    <td style=\"width: 50%;  font-weight: normal; font-size: 13px; text-align: left; border: 1.5px solid rgb(39, 39, 39); border-left: none; border-bottom: none; border-top: none; padding-left: 5px;\"><strong>Logged By:</strong>  {$logged_by['name']} {$logged_by['last_name']}</td>
                                </tr>
                                <tr>
                                    <td style=\"width: 50%;  font-weight: normal; font-size: 13px; text-align: left; border: 1.5px solid rgb(39, 39, 39); border-top: none; padding-left: 5px; padding-bottom: 5px;\"><strong>Site: {$jobcard_['site']}</strong> </td>
                                    <td style=\"width: 50%;  font-weight: normal; font-size: 13px; text-align: left; border: 1.5px solid rgb(39, 39, 39); border-left: none; border-top: none; padding-left: 5px; padding-bottom: 5px;\"><strong>Authorized By:</strong> {$authorized_by['name']} {$authorized_by['last_name']}</td>
                                </tr>
                            </table>
                            <br>";

                    if (is_array($extras) && count($extras) > 0) {

                        $pdf .= "<table style=\"width: 700px; border-collapse: collapse; table-layout: fixed; background-color: rgb(231, 231, 231);\">
                                    <thead>
                                        <tr>
                                            <th style=\"font-weight: bold; font-size: 16; text-align: left; padding: 10px;\">Extras</th>
                                            <th style=\"text-align: left; padding: 10px;\"></th>
                                            <th style=\"text-align: left; padding: 10px;\"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style=\"width: 33%; font-weight: normal; font-size: 13px; text-align: left; padding-left: 10px;\"><strong>{$extras[0]['name']}:</strong> {$extras[0]['answer']}</td>
                                            <td style=\"width: 33%; font-weight: normal; font-size: 13px; text-align: left; padding-left: 10px;\"><strong>{$extras[1]['name']}:</strong> {$extras[1]['answer']}</td>
                                            <td style=\"width: 33%; font-weight: normal; font-size: 13px; text-align: left; padding-left: 10px;\"><strong>{$extras[2]['name']}:</strong> {$extras[2]['answer']}</td>
                                        </tr> 
                                        <tr>
                                            <td style=\"width: 33%; font-weight: normal; font-size: 13px; text-align: left; padding-left: 10px;\"><strong>{$extras[3]['name']}:</strong> {$extras[3]['answer']}</td>
                                            <td style=\"width: 33%; font-weight: normal; font-size: 13px; text-align: left; padding-left: 10px;\"><strong>{$extras[4]['name']}:</strong> {$extras[4]['answer']}</td>
                                            <td style=\"width: 33%; font-weight: normal; font-size: 13px; text-align: left; padding-left: 10px;\"><strong>{$extras[5]['name']}:</strong> {$extras[5]['answer']}</td>
                                        </tr>
                                        <tr>
                                            <td style=\"width: 33%; font-weight: normal; font-size: 13px; text-align: left; padding-left: 10px; padding-bottom: 10px;\"><strong>{$extras[6]['name']}:</strong> {$extras[6]['answer']}</td>
                                            <td style=\"width: 33%; font-weight: normal; font-size: 13px; text-align: left; padding-left: 10px; padding-bottom: 10px;\"><strong>{$extras[7]['name']}:</strong> {$extras[7]['answer']}</td>
                                            <td style=\"width: 33%; font-weight: normal; font-size: 13px; text-align: left; padding-left: 10px; padding-bottom: 10px;\"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>";
                    }

                    $pdf .= "<table style=\"width: 700px; border-collapse: collapse; table-layout: fixed;\">
                                <thead>
                                    <tr>
                                        <th style=\" font-weight: bold; font-size: 16px; text-align: left; padding: 10px;\">Fault Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style=\"width: 100%;  font-weight: normal; font-size: 13px; text-align: left; padding: 10px;\">{$jobcard_['fault_description']}</td>
                                    </tr>
                                </tbody>
                            </table>
                 
                            <br>
                            <table style=\"border-collapse: collapse; table-layout: fixed;\">
                                <thead>
                                    <tr>
                                        <th style=\"width: 12%; font-weight: bold; font-size: 16px; text-align: left; padding: 10px;\">Events</th>
                                        <th style=\"width: 40%; font-weight: bold; font-size: 16px; text-align: left; padding: 10px;\"></th>
                                        <th style=\"width: 10%; font-weight: bold; font-size: 16px; text-align: left; padding: 10px;\"></th>
                                        <th style=\"width: 38%; font-weight: bold; font-size: 16px; text-align: left; padding: 10px;\"></th>
                                    </tr>
                                    <tr style=\"background-color: rgb(85, 85, 85);\">
                                        <th style=\"font-weight: bold; font-size: 13px; color: #FFFFFF; text-align: left; padding: 10px;\">Date</th>
                                        <th style=\"font-weight: bold; font-size: 13px; color: #FFFFFF; text-align: left; padding: 10px;\">Event</th>
                                        <th style=\"font-weight: bold; font-size: 13px; color: #FFFFFF; text-align: left; padding: 10px;\">Hours</th>
                                        <th style=\"font-weight: bold; font-size: 13px; color: #FFFFFF; text-align: left; padding: 10px;\">Comment</th>
                                    </tr>
                                </thead>
                                <tbody>";

                    $get_events = dbq("select * from jobcard_events where job_id={$jobcard_['job_id']} order by start_datetime");
                    if ($get_events) {
                        if (dbr($get_events) > 0) {
                            $stripe = false;
                            while ($event = dbf($get_events)) {
                                $pdf .= "<tr " . ($stripe ? "style=\"background-color: #f1f1f1;\"" : "") . ">
                                            <td style=\"font-weight: normal; font-size: 13px; text-align: left; padding: 10px;\">" . date('Y-m-d', strtotime($event['start_datetime'])) . "</td>
                                            <td style=\"font-weight: normal; font-size: 13px; text-align: left; padding: 10px;\">{$event['event']}</td>
                                            <td style=\"font-weight: normal; font-size: 13px; text-align: left; padding: 10px;\">{$event['total_hours']}</td>
                                            <td style=\"font-weight: normal; font-size: 13px; text-align: left; padding: 10px;\">{$event['comment']}</td>
                                        </tr>";
                                $stripe = !$stripe;
                            }
                        } else {
                            $pdf .= "<tr>
                                                        <td colspan='4' style='width:700px'>No events</td>                                
                                                    </tr>";
                        }
                    }

                    $pdf .= "</tbody>
                    <tbody></tbody>
                  </table>";




                    printPDF($pdf, "{$jobcard_['jobcard_number']}");
                } else {
                    error_log("print error : {$_GET['type']} : report not found ");
                    http_response_code(404);
                    die();
                }
            } else {
                error_log("print error : {$_GET['type']} :  " . dbe());
                http_response_code(404);
                die();
            }
        } else {
            http_response_code(404);
            die();
        }
        break;

    case "risk-assessment":
        if (isset($_GET['id'])) {
            $get_risk_assessment = dbq("select * from jobcard_risk_assessments where id={$_GET['id']}");
            if ($get_risk_assessment) {
                if (dbr($get_risk_assessment) > 0) {
                    $risk_assessment = dbf($get_risk_assessment);
                    $jobcard_ = dbf(dbq("select * from jobcards where job_id={$risk_assessment['job_id']}"));
                    $plant_ = dbf(dbq("select * from plants_tbl where plant_id={$jobcard_['plant_id']}"));
                    $mechanic_ = dbf(dbq("select name, last_name,employee_number from users_tbl where user_id={$jobcard_['mechanic_id']}"));

                    $get_items = json_decode(base64_decode($risk_assessment['results']), true);
                    $pdf = "
                                <div style='margin:15px;>
                                    <h3>Risk Assessment</h3>                                     
                                    <b>Job#</b> {$jobcard_['jobcard_number']}<br>                                            
                                    <b>Plant#</b> {$plant_['plant_number']}<br>
                                    <b>Make:</b> {$plant_['make']}<br>
                                    <b>Model:</b> {$plant_['model']}<br><br>"
                        . (strlen($risk_assessment['note']) ? "<p>" . $risk_assessment['note'] . "</p>" : "")
                        . "
                                    <table style='; border-collapse:collapse'>
                                        <thead>
                                            <tr>
                                                <th style='border:1px solid black; padding:3px;'>#</th>
                                                <th style='border:1px solid black; padding:3px;'>Question</th>
                                                <th style='border:1px solid black; padding:3px;'>Ans.</th>
                                                <th style='border:1px solid black; padding:3px;'>Comment</th>
                                            </tr>
                                        </thead>
                                        <tbody>";
                    if (is_array($get_items)) {

                        if (count($get_items) > 0) {
                            $count = 1;
                            foreach ($get_items as $item) {
                                $pdf .= "<tr>
                                            <td style='border:1px solid black; padding:3px;width:45px;'>#{$count}</td>
                                            <td style='border:1px solid black; padding:3px;width:300px;'>{$item['question']}</td>
                                            <td style='border:1px solid black; padding:3px;width:35px;'>{$item['answer']}</td>
                                            <td style='border:1px solid black; padding:3px;width:300px;'>" . ucfirst($item['comment']) . "</td>                               
                                        </tr>";
                                $count++;
                            }
                        } else {
                            $pdf .= "<tr><td colspan='8'>Nothing to show</td></tr>";
                        }
                    }

                    $pdf .= "        </tbody>
                                    </table>
                                    <p>
                                        <h3>Terms and conditions</h3>
                                        <p>I, " . (strlen($mechanic_['name']) ? $mechanic_['name'] : "") . " " . (strlen($mechanic_['last_name']) ? $mechanic_['last_name'] : "") . " " . (strlen($mechanic_['employee_number']) ? $mechanic_['employee_number'] : "") . " , confirm and acknowledge that I have been involved with the HIRA and am aware of all hazards and risks associated with the task and undertake to follow the Safe Work Procedure, I aslo understand that my Safty is my own responsibility and that I must at all times report unsafe conditions.</p>
                                        
                                    </p>
                                </div>
                              ";
                    //echo $pdf;
                    printPDF($pdf, "{$jobcard_['jobcard_number']}-{$_GET['type']}-{$risk_assessment['id']}");
                } else {
                    error_log("print error : {$_GET['type']} : report not found ");
                    http_response_code(404);
                    die();
                }
            } else {
                error_log("print error : {$_GET['type']} :  " . dbe());
                http_response_code(404);
                die();
            }
        } else {
            http_response_code(404);
            die();
        }
        break;

    case "tyre-report":
        if (isset($_GET['id'])) {
            $get_tyre_report = dbq("select * from jobcard_tyre_reports where id={$_GET['id']}");
            if ($get_tyre_report) {
                if (dbr($get_tyre_report) > 0) {
                    $tyre_report = dbf($get_tyre_report);
                    $jobcard_ = dbf(dbq("select * from jobcards where job_id={$tyre_report['job_id']}"));
                    $plant_ = dbf(dbq("select * from plants_tbl where plant_id={$jobcard_['plant_id']}"));

                    $get_items = dbq("select * from jobcard_tyre_report_lines where tyre_rep_id={$tyre_report['id']}");
                    if ($get_items) {
                        while ($item = dbf($get_items)) $tyres[] = $item;

                        $pdf = "
                                <div style='margin:15px;>
                                    <h3>Tyre Report</h3>                                     
                                    <b>Job#</b> {$jobcard_['jobcard_number']}<br>                                            
                                    <b>Plant#</b> {$plant_['plant_number']}<br>
                                    <b>Make:</b> {$plant_['make']}<br>
                                    <b>Model:</b> {$plant_['model']}<br><br>
                                    <table style='border-collapse:collapse; font-size: 12px'>
                                        <thead>
                                            <tr>
                                                <th style='border:1px solid black; padding:3px;width:35px;'>Pos.</th>
                                                <th style='border:1px solid black; padding:3px;width:170px;'>Make</th>
                                                <th style='border:1px solid black; padding:3px;width:170px;'>Size</th>
                                                <th style='border:1px solid black; padding:3px;width:40px;'>Type</th>
                                                <th style='border:1px solid black; padding:3px;width:60px;'>Tread</th>
                                                <th style='border:1px solid black; padding:3px;width:60px;'>Pres.</th>
                                                <th style='border:1px solid black; padding:3px;width:45px;'>V.Cap</th>
                                                <th style='border:1px solid black; padding:3px;width:45px;'>V.Ext</th>
                                            </tr>
                                        </thead>
                                        <tbody>";
                        if (count($tyres) > 0) {
                            foreach ($tyres as $tyre) {
                                $pdf .= "<tr>
                                            <td style='border:1px solid black; padding:3px;'>#{$tyre['position']}</td>
                                            <td style='border:1px solid black; padding:3px;'>{$tyre['make']}</td>
                                            <td style='border:1px solid black; padding:3px;'>{$tyre['size']}</td>
                                            <td style='border:1px solid black; padding:3px;'>" . ucfirst($tyre['tyre_type']) . "</td>    
                                            <td style='border:1px solid black; padding:3px;'>{$tyre['tread']} mm</td>
                                            <td style='border:1px solid black; padding:3px;'>{$tyre['pressure']} lb</td> 
                                            <td style='border:1px solid black; padding:3px;'>" . ($tyre['valve_cap'] ? "Yes" : "No") . "</td>
                                            <td style='border:1px solid black; padding:3px;'>" . ($tyre['valve_ext'] ? "Yes" : "No") . "</td>                                       
                                        </tr>";
                            }
                        } else {
                            $pdf .= "<tr><td colspan='8'>Nothing to show</td></tr>";
                        }

                        $pdf .= "        </tbody>
                                    </table>
                                    <br>
                                        <img src='img/1.jpg' width='130'>
                                        <img src='img/2.jpg' width='130'>
                                        <img src='img/3.jpg' width='130'>
                                        <img src='img/4.jpg' width='130'>
                                        <img src='img/5.jpg' width='130'>
                                   

                                </div>
                              ";
                        //echo $pdf;
                        printPDF($pdf, "{$jobcard_['jobcard_number']}-{$_GET['type']}-{$tyre_report['id']}");
                    } else {
                        $json_['status'] = 'error';
                        $json_['message'] = "SQL error: " . dbe();
                    }
                } else {
                    error_log("print error : {$_GET['type']} : report not found ");
                    http_response_code(404);
                    die();
                }
            } else {
                error_log("print error : {$_GET['type']} :  " . dbe());
                http_response_code(404);
                die();
            }
        } else {
            http_response_code(404);
            die();
        }
        break;

    default:
        http_response_code(404);
        die();
}

if (isset($json_)) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($json_);
}
