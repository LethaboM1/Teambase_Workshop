<?php
require_once "includes/check.php";
require_once 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_POST['html_code'])) {
    $html = $_POST['html_code'];
    printPDF($html);
}



switch ($_GET['type']) {
    case 'next-service':
        $km_diff = 2600;
        $hr_diff = 100;

        $get_plants = dbq("select plant_number, make,model, reading_type, km_reading, hr_reading, next_service_reading from plants_tbl");
        if ($get_plants) {
            if (dbr($get_plants) > 0) {
                /* 2600 km , 100hrs */
                while ($plant_ = dbf($get_plants)) {
                    $show = false;

                    switch ($plant_['reading_type']) {
                        case 'km':
                            if ($plant_['next_service_reading'] != null) {
                                if ($plant_['km_reading'] < $plant_['next_service_reading']) {
                                    $diff = $plant_['next_service_reading'] - $plant_['km_reading'];
                                    if ($diff <= $km_diff) {
                                        $show = true;
                                    }
                                } else if ($plant_['km_reading'] >= $plant_['next_service_reading']) {
                                    $diff = $plant_['next_service_reading'] - $plant_['km_reading'];
                                    $show = true;
                                }
                            }
                            break;

                        case 'hr':
                            if ($plant_['next_service_reading'] != null) {
                                if ($plant_['hr_reading'] < $plant_['next_service_reading']) {
                                    $diff = $plant_['next_service_reading'] - $plant_['hr_reading'];
                                    if ($diff <= $hr_diff) {
                                        $show = true;
                                    }
                                } else if ($plant_['hr_reading'] >= $plant_['next_service_reading']) {
                                    $diff = $plant_['next_service_reading'] - $plant_['hr_reading'];
                                    $show = true;
                                }
                            }
                            break;
                    }
                    if ($show) {
                        $plant_['diff'] = $diff;
                        $service_list[] = $plant_;
                    }
                }
            }
        }

        $title = [
            'font' => [
                'bold' => true,
                'size' => 14

            ],
        ];

        $header = [
            'font' => [
                'bold' => true,
            ],
        ];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Plants to service')
            ->setCellValue('A2', 'Date Printed: ' . date('Y-m-d'))

            ->setCellValue('A4', 'Plant No.')
            ->setCellValue('B4', 'Make')
            ->setCellValue('C4', 'Model')
            ->setCellValue('D4', 'Reading')
            ->setCellValue('E4', 'Service')
            ->setCellValue('F4', 'Variance');

        $sheet->getStyle('A1')->applyFromArray($title);
        $sheet->getStyle('A4:F4')->applyFromArray($header);


        $sheet->getColumnDimension('A')->setWidth(100, 'px');
        $sheet->getColumnDimension('B')->setWidth(100, 'px');
        $sheet->getColumnDimension('C')->setWidth(100, 'px');
        $sheet->getColumnDimension('D')->setWidth(100, 'px');
        $sheet->getColumnDimension('E')->setWidth(100, 'px');
        $sheet->getColumnDimension('F')->setWidth(100, 'px');

        $sheet_row = 5;
        if (isset($service_list) && count($service_list) > 0) {
            error_log(count($service_list));
            foreach ($service_list as $list_item) {
                $sheet->setCellValue("A{$sheet_row}", $list_item['plant_number'])
                    ->setCellValue("B{$sheet_row}",  $list_item['make'])
                    ->setCellValue("C{$sheet_row}",  $list_item['model'])
                    ->setCellValue("D{$sheet_row}",  $list_item[$list_item['reading_type'] . '_reading'])
                    ->setCellValue("E{$sheet_row}",  $list_item['next_service_reading'])
                    ->setCellValue("F{$sheet_row}",  $list_item['diff']);
                $sheet_row++;
            }
        }


        $writer = new Xlsx($spreadsheet);


        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="next-service-' . date('Y_m_d') . '.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0


        $writer->save('php://output');

        break;

    case 'plant-checklist':
        if ($_GET['id'] > 0) {
            $get_checklist = dbq("select * from checklist_results where list_id={$_GET['id']}");
            if ($get_checklist) {
                if (dbr($get_checklist) > 0) {
                    $check_list = dbf($get_checklist);
                    $plant_ = dbf(dbq("select * from plants_tbl where plant_id={$check_list['plant_id']}"));
                    $operator_ = dbf(dbq("select name, last_name from users_tbl where user_id={$check_list['user_id']}"));

                    if (strlen($check_list['results']) > 0) {
                        $lines = (is_json($check_list['results'])) ? json_decode($check_list['results'], true) : json_decode(base64_decode($check_list['results']), true);
                    } else {
                        $lines = [];
                    }


                    $pdf = "<table style='width: 750px; border-collapse: collapse; table-layout: fixed;'>   
                            <tr>
                            <th style='width: 50%; font-weight: bold; font-size: 20px; text-align: left; border: none;'>Pre-Check Report</th>
                            </tr>   
                        </table>
                        <br>
                        <table style='width: 750px; border-collapse: collapse; table-layout: fixed;'>
                            <tr>
                            <td style='width: 50%; font-weight: normal; font-size: 13px; text-align: left; border: 1.5px solid rgb(39, 39, 39); border-bottom: none; padding-left: 5px; padding-top: 5px;'><strong>Plant No #:</strong> {$plant_['plant_number']}</td>
                            <td style='width: 50%; font-weight: normal; font-size: 13px; text-align: left; border: 1.5px solid rgb(39, 39, 39); border-left: none; border-bottom: none; padding-left: 5px; padding-top: 5px;'><strong>Date:</strong> {$check_list['datetime']}</td>
                            </tr>
                            <tr>
                            <td style='width: 50%;  font-weight: normal; font-size: 13px; text-align: left; border: 1.5px solid rgb(39, 39, 39); border-top: none; padding-left: 5px; padding-bottom: 5px; '><strong>Opperator:</strong> {$operator_['name']} {$operator_['last_name']}</td>
                            <td style='width: 50%;  font-weight: normal; font-size: 13px; text-align: left; border: 1.5px solid rgb(39, 39, 39); border-left: none; border-top: none; padding-left: 5px;'><strong>Reading:</strong> {$check_list['reading']} " . strtoupper($check_list['reading_type']) . "</td>
                            </tr>
                        </table>
                        <br>
                        <table style='width: 750px; border-collapse: collapse; table-layout: fixed;'>
                            <thead>
                                <tr style='background-color: rgb(85, 85, 85);'>
                                    <th style='width:645px;font-weight: bold; font-size: 13px; color: #FFFFFF; text-align: left; padding: 10px;'>Question</th>
                                    <th style='font-weight: bold; font-size: 13px; color: #FFFFFF; text-align: left; padding: 10px;'>Answer</th>
                                </tr>
                            </thead>";
                    $stripe = false;
                    foreach ($lines as $line) {
                        $pdf .= " 
                                <tr" . ($stripe ? " style='background-color: #f1f1f1;'" : "") . ">
                                    <td style='font-weight: normal; font-size: 13px; text-align: left; padding: 10px;'>{$line['Question']}</td>
                                    <td style='font-weight: normal; font-size: 13px; text-align: left; padding: 10px;'>" . ucfirst($line['Result']) . "</td>
                                </tr>
                                ";
                        $stripe = !$stripe;
                    }


                    $pdf .= "</table>
                        <br>
                        <table style='width: 750px; border-collapse: collapse; table-layout: fixed;'>
                          <thead>
                            <tr>
                              <th style=' font-weight: bold; font-size: 16px; text-align: left; padding: 10px;'>Comment</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td style='width: 100%;  font-weight: normal; font-size: 13px; text-align: left; padding: 10px;'>{$check_list['comments']}</td>
                            </tr>
                          </tbody>
                        </table>
                        <br>
                        <br>
                        <table style='width: 750px;'>
                            <tfoot>
                                <tr>
                                  <td style='width: 100%; text-align: right; font-weight: bold; font-size: 11px;'>PL02 REV00 101001</td>
                                </tr>
                              </tfoot>
                        </table>  ";

                    $file_name = "{$check_list['datetime']}-{$plant_['plant_number']}-{$operator_['name']} {$operator['last_name']}";
                    $file_name = clean_path_($file_name);

                    printPDF($pdf, $file_name);
                }
            }
        }
        break;

    case "open-requisitions":
        if ($_SESSION['user']['role'] != 'manager' && $_SESSION['user']['role'] != 'buyer') die();
        $query = "select 
                        * 
                    from 
                        jobcard_requisition_parts 
                    where  
                        request_id in (
                                select 
                                    request_id 
                                from 
                                    jobcard_requisitions 
                                where 
                                    (
                                        status!='completed' 
                                        && status!='canceled' 
                                        && status!='rejected'
                                    )
                                )";
        if ($sql = dbq($query)) {
            $title = [
                'font' => [
                    'bold' => true,
                    'size' => 14

                ],
            ];

            $header = [
                'font' => [
                    'bold' => true,
                ],
            ];

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'Job Requisitions')
                ->setCellValue('A2', 'Date Printed: ' . date('Y-m-d'))

                ->setCellValue('A4', 'Date')
                ->setCellValue('B4', 'Days Outstanding')
                ->setCellValue('C4', 'ETA Parts')
                ->setCellValue('D4', 'Days remaining to ETA')
                ->setCellValue('E4', 'Plant No.')
                ->setCellValue('F4', 'Req No.')
                ->setCellValue('G4', 'Purchase Order No.')
                ->setCellValue('H4', 'Qty')
                ->setCellValue('I4', 'Description')
                ->setCellValue('J4', 'Req By')
                ->setCellValue('K4', 'Buyers name')
                ->setCellValue('L4', 'Supplier')
                ->setCellValue('M4', 'WorkShop feedback')
                ->setCellValue('N4', 'Plant Manager Comments');

            $sheet->getStyle('A1')->applyFromArray($title);
            $sheet->getStyle('A4:N4')->applyFromArray($header);
            $sheet->getStyle('B4')->getAlignment()->setWrapText(true);
            $sheet->getStyle('D4')->getAlignment()->setWrapText(true);

            $sheet->getColumnDimension('A')->setWidth(100, 'px');
            $sheet->getColumnDimension('B')->setWidth(85, 'px');
            $sheet->getColumnDimension('C')->setWidth(100, 'px');
            $sheet->getColumnDimension('D')->setWidth(85, 'px');
            $sheet->getColumnDimension('E')->setWidth(200, 'px');
            $sheet->getColumnDimension('F')->setWidth(100, 'px');
            $sheet->getColumnDimension('G')->setWidth(150, 'px');
            $sheet->getColumnDimension('H')->setWidth(45, 'px');
            $sheet->getColumnDimension('I')->setWidth(300, 'px');
            $sheet->getColumnDimension('J')->setWidth(200, 'px');
            $sheet->getColumnDimension('K')->setWidth(200, 'px');
            $sheet->getColumnDimension('L')->setWidth(200, 'px');
            $sheet->getColumnDimension('M')->setWidth(200, 'px');
            $sheet->getColumnDimension('N')->setWidth(200, 'px');

            if (dbr($sql)) {
                $sheet_row = 5;
                while ($row = dbf($sql)) {
                    $requisition_ = dbf(dbq("select * from jobcard_requisitions where request_id={$row['request_id']}"));
                    $plant_ = dbf(dbq("select plant_number from plants_tbl where plant_id={$requisition_['plant_id']}"));

                    $today = date_create();
                    $today_ = date_format($today, 'Y-m-d');

                    $date = date_create($requisition_['datetime']);
                    $date_ = date_format($date, 'Y-m-d');

                    $date_eta = date_create($row['date_eta']);


                    $days =  (strlen($date_) > 0 && strlen($today_) > 0) ? (calc_days($date_, $today_) > 0 ? calc_days($date_, $today_) : 0) : 0;;
                    $eta_days = (strlen($row['date_eta']) > 0) ? (calc_days($today_, $row['date_eta']) > 0 ? calc_days($today_, $row['date_eta']) : 0) : 0;
                    $buyer_ = ($requisition_['buyer_id'] > 0) ? dbf(dbq("select name, last_name from users_tbl where user_id={$requisition_['buyer_id']}")) : ['name' => 'No Buyer Allocated', 'last_name' => ''];
                    $requested_by = ($requisition_['requested_by'] > 0) ? dbf(dbq("select name, last_name from users_tbl where user_id={$requisition_['requested_by']}")) : ['name' => 'None', 'last_name' => ''];

                    $sheet->setCellValue("A{$sheet_row}", $date_)
                        ->setCellValue("B{$sheet_row}", $days)
                        ->setCellValue("C{$sheet_row}", $row['date_eta'])
                        ->setCellValue("D{$sheet_row}", $eta_days)
                        ->setCellValue("E{$sheet_row}", $plant_['plant_number'])
                        ->setCellValue("F{$sheet_row}", $row['request_id'])
                        ->setCellValue("G{$sheet_row}", $row['purchase_order'])
                        ->setCellValue("H{$sheet_row}", $row['qty'])
                        ->setCellValue("I{$sheet_row}", $row['part_description'])
                        ->setCellValue("J{$sheet_row}", $requested_by['name'] . ' ' . $requested_by['last_name'])
                        ->setCellValue("K{$sheet_row}", $buyer_['name'] . ' ' . $buyer_['last_name'])
                        ->setCellValue("L{$sheet_row}", $row['supplier']);

                    $sheet_row++;
                }
            }


            $writer = new Xlsx($spreadsheet);


            // Redirect output to a client’s web browser (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="quote-parts list-' . $quote_ref . '-' . date('Y_m_d') . '.xlsx"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0


            $writer->save('php://output');
        } else {
        }

        break;

    case "job-card":
        if (isset($_GET['id'])) {
            $get_jobcard = dbq("select * from jobcards where job_id={$_GET['id']}");
            if ($get_jobcard) {
                if (dbr($get_jobcard) > 0) {
                    $jobcard_ = dbf($get_jobcard);
                    $plant_ = dbf(dbq("select * from plants_tbl where plant_id={$jobcard_['plant_id']}"));
                    $mechanic_ = dbf(dbq("select name, last_name,employee_number from users_tbl where user_id={$jobcard_['mechanic_id']}"));
                    $logged_by = dbf(dbq("select name, last_name,employee_number from users_tbl where user_id={$jobcard_['logged_by']}"));

                    ($jobcard_['authorized_by'] > 0) ? $authorized_by = dbf(dbq("select name, last_name,employee_number from users_tbl where user_id={$jobcard_['authorized_by']}")) : $authorized_by['name'] = 'Not Authorized';

                    $extras = json_decode(base64_decode($jobcard_['safety_audit']), true);

                    $font = ""; //"font-family: 'Open Sans', sans-serif;";
                    $pdf = "
                            <table style=\"width: 760px; border-collapse: collapse; table-layout: fixed;\"> 
                                <tr>
                                    <th style=\"width: 50%; font-weight: bold; font-size: 20px; text-align: left; border: none;\">Job Card # {$jobcard_['jobcard_number']}</th>
                                    <th style=\"width: 50%; font-weight: bold; font-size: 20px; text-align: left; border: none;\">Plant # {$plant_['plant_number']}</th>
                                </tr> 
                            </table>
                            <br>
                            <table style=\"width: 750px; border-collapse: collapse; table-layout: fixed;\">
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

                        $pdf .= "<table style=\"width: 760px; border-collapse: collapse; table-layout: fixed; background-color: rgb(231, 231, 231);\">
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

                    $pdf .= "<table style=\"width: 760px; border-collapse: collapse; table-layout: fixed;\">
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
                                        <th style=\"width: 20%; font-weight: bold; font-size: 16px; text-align: left; padding: 10px;\"></th>
                                        <th style=\"width: 10%; font-weight: bold; font-size: 16px; text-align: left; padding: 10px;\"></th>
                                        <th style=\"width: 58%; font-weight: bold; font-size: 16px; text-align: left; padding: 10px;\"></th>
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
                                            <td style=\"font-weight: normal; font-size: 13px; text-align: left; padding: 10px; width: 300px;\">{$event['comment']}</td>
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
                  </table>
                  <br>
                  <br>
                  <table style='width: 750px;'>
                      <tfoot>
                          <tr>
                            <td style='width: 100%; text-align: right; font-weight: bold; font-size: 11px;'>PL05 REV04 190524</td>
                          </tr>
                        </tfoot>
                  </table>  ";




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
                    $pdf = "<table style=\"width: 750px; border-collapse: collapse; table-layout: fixed;\">   
                                <tr>
                                    <th style=\"font-weight: bold; font-size: 20px; text-align: left; border: none;\">Risk Assessment</th>
                                </tr>   
                            </table>
                            <br>
                            <table style=\"width: 750px; border-collapse: collapse; table-layout: fixed;\">
                                <tr>
                                    <td style=\"font-weight: normal; font-size: 13px; text-align: left;\"><strong>Job #:</strong> {$jobcard_['jobcard_number']}</td>
                                </tr>
                                <tr>  
                                    <td style=\"font-weight: normal; font-size: 13px; text-align: left;\"><strong>Plant #:</strong> {$plant_['plant_number']}</td>
                                </tr>
                                <tr>
                                    <td style=\"font-weight: normal; font-size: 13px; text-align: left;\"><strong>Make:</strong> {$plant_['make']}</td> 
                                </tr>
                                <tr>  
                                    <td style=\"font-weight: normal; font-size: 13px; text-align: left;\"><strong>Model:</strong> {$plant_['model']}</td>
                                </tr>
                            </table>"
                        . (strlen($risk_assessment['note']) ? "<p style=\"font-weight: normal; font-size: 13px; text-align: left;\">{$risk_assessment['note']}</p>" : "<p>&nbsp;</p>")
                        . "<table style=\"width: 750px; border-collapse: collapse; table-layout: fixed;\">
                            <thead>
                                <tr>
                                    <th style=\"width: 5%; font-weight: bold; font-size: 13px; text-align: left; padding: 5px; border: 1px solid rgb(39, 39, 39);\">#</th>
                                    <th style=\"width: 45%; font-weight: bold; font-size: 13px; text-align: left; padding: 5px; border: 1px solid rgb(39, 39, 39);\">Question</th>
                                    <th style=\"width: 7%; font-weight: bold; font-size: 13px; text-align: left; padding: 5px; border: 1px solid rgb(39, 39, 39);\">Ans.</th>
                                    <th style=\"width: 43%; font-weight: bold; font-size: 13px; text-align: left; padding: 5px; border: 1px solid rgb(39, 39, 39);\">Comment</th>
                                </tr>
                            </thead>
                            <tbody>";
                    if (is_array($get_items)) {

                        if (count($get_items) > 0) {
                            $count = 1;
                            foreach ($get_items as $item) {
                                $pdf .= "<tr>
                                            <td style=\"width: 5%; font-weight: normal; font-size: 13px; text-align: left; padding: 5px; border: 1px solid rgb(39, 39, 39);\">{$count}</td>
                                            <td style=\"width: 45%; word-wrap: break-word; font-weight: normal; font-size: 13px; text-align: left; padding: 5px; border: 1px solid rgb(39, 39, 39);\">{$item['question']}</td>
                                            <td style=\"width: 7%; font-weight: normal; font-size: 13px; text-align: left; padding: 5px; border: 1px solid rgb(39, 39, 39);\">{$item['answer']}</td>
                                            <td style=\"width: 43%; font-weight: normal; font-size: 13px; text-align: left; padding: 5px; border: 1px solid rgb(39, 39, 39);\">" . ucfirst($item['comment']) . "</td>
                                        </tr>";

                                $count++;
                            }
                        } else {
                            $pdf .= "<tr><td colspan='8'>Nothing to show</td></tr>";
                        }
                    }

                    $pdf .= "</tbody>
                    </table>
                    <h1 style=\"font-weight: bold; font-size: 20px; text-align: left;\">Terms and conditions</h1>
                    <p style=\"font-weight: normal; font-size: 13px; text-align: left;\">I, <b>" . (strlen($mechanic_['name']) ? $mechanic_['name'] : "") . " " . (strlen($mechanic_['last_name']) ? $mechanic_['last_name'] : "") . " " . (strlen($mechanic_['employee_number']) ? $mechanic_['employee_number'] : "") . "</b>  , confirm and acknowledge that I have been involved with the HIRA and am aware of all hazards and risks associated with the task and undertake to follow the Safe Work Procedure, I aslo understand that my Safty is my own responsibility and that I must at all times report unsafe conditions.</p>
                    <br>
                    <br>
                    <table style='width: 750px;'>
                        <tfoot>
                            <tr>
                            <td style='width: 100%; text-align: right; font-weight: bold; font-size: 11px;'>HS01 REV04 190522</td>
                            </tr>
                        </tfoot>
                    </table>  ";
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
                        if (is_array($tyres) && count($tyres) > 0) {
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
                                <br>
                                <br>
                                <table style='width: 750px;'>
                                    <tfoot>
                                        <tr>
                                          <td style='width: 100%; text-align: right; font-weight: bold; font-size: 11px;'>PL07 REV02 190522</td>
                                        </tr>
                                      </tfoot>
                                </table>     
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

    case 'operator-log':
        if (
            $_GET['id'] > 0
            && strlen($_GET['start']) > 0
            && strlen($_GET['end']) > 0
        ) {
            $plant_ = get_plant($_GET['id']);

            $start_date = date_create($_GET['start']);
            $end_date = date_create($_GET['end']);

            if (date_format($start_date, 'Y-m-d') <= date_format($end_date, 'Y-m-d')) {
                $get_logs = dbq("select * from operator_log where plant_id='{$_GET['id']}' and start_datetime > '" . date_format($start_date, 'Y-m-d 00:00:00') . "' and start_datetime <= '" . date_format($end_date, 'Y-m-d 23:59:59') . "'");
                if (!$get_logs) error_log("sql error: " . dbe());

                $pdf = "<table style='width: 1090px; table-layout: fixed;'>
                        <thead>
                            <tr>
                            <th style='width: 100%; font-weight: bold; font-size: 25px; color: black; text-align: center; border: 1px; padding: 5px;'>Drivers / Operators Log Sheet</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td></td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <table style='width: 1090px; table-layout: fixed;' cellspacing='-1'>
                        
                            <tr>
                                <td style='width: 15%; font-weight: bold; font-size: 11px; color: black; text-align: right; border: 1px; padding: 5px;'>Plant:</td>
                                <td style='width: 35%; font-size: 11px; color: black; text-align: left; border: 1px; padding: 5px;'>{$plant_['plant_number']} - {$plant_['make']} {$plant_['model']}</td>
                                <td style='width: 15%; font-weight: bold; font-size: 11px; color: black; text-align: right; border: 1px; padding: 5px;'>Company No:</td>
                                <td style='width: 35%; font-size: 11px; color: black; text-align: left; border: 1px; padding: 5px;'>{$operator_['company_number']}</td>
                            </tr>";
                /* 
                    
                            <tr>
                                <td style='width: 15%; font-weight: bold; font-size: 11px; color: black; text-align: right; border: 1px; padding: 5px;'>Plant No:</td>
                                <td style='width: 35%; font-size: 11px; color: black; text-align: left; border: 1px; padding: 5px;'>{$plant_['plant_number']}</td>
                                <td style='width: 15%; font-weight: bold; font-size: 11px; color: black; text-align: right; border: 1px; padding: 5px;'>&nbsp;</td>
                                <td style='width: 35%; font-size: 11px; color: black; text-align: left; border: 1px; padding: 5px;'>&nbsp;</td>
                            </tr>
                    */
                $pdf .= "</table>
                    <table style='width: 1090px; table-layout: fixed;' cellspacing='-1'>
                        <tbody>
                            <tr>
                                <td rowspan='2' style='width: 6%; font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>Date</td>
                                <td rowspan='2' style='width: 5%; font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>Day</td>
                                <td rowspan='2' style='width: 10%; font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>Site No</td>
                                <td colspan='2' style='width: 5%; font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>Operating Time</td>
                                <td colspan='2' style='width: 8%; font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>Michine HR/ KM Reading</td>
                                <td rowspan='2' style='width: 5%; font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>Fuel Liters Issued</td>
                                <td colspan='2' style='width: 5%; font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>Breakdown Time</td>
                                <td rowspan='2' style='width: 16%; font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>Reason for breakdown or other remarks</td>
                                <td style='width: 9%; font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>DR / OP's Name</td>
                                <td colspan='2' style='width: 19%; font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>Supervisor</td>
                            </tr>
                            <tr>
                                <td style='width: 5%; font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>Start</td>
                                <td style='width: 5%; font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>End</td>
                                <td style='width: 5%; font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>Start</td>
                                <td style='width: 5%; font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>End</td>
                                <td style='width: 5%; font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>From</td>
                                <td style='width: 5%; font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>To</td>

                                <td style='font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>Signature</td>
                                <td style='font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>Name</td>
                                <td style='font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>Signature</td>
                            </tr>";
                if (dbr($get_logs) > 0) {
                    while ($log = dbf($get_logs)) {
                        $operator_ = get_user($log['operator_id']);
                        $startdate = date_create($log['start_datetime']);
                        $enddate = date_create($log['end_datetime']);
                        $breakdown = get_record('operator_events', 'operator_log', $log['log_id'], "type='breakdown'");
                        $refuel = get_record('operator_refuel', 'operator_log', $log['log_id']);

                        if ($breakdown) {
                            $bd_start = date_create($log['start_datetime']);
                            $bd_end = date_create($log['end_datetime']);

                            $bd_start = date_format($bd_start, 'H:i');
                            $bd_end = date_format($bd_end, 'H:i');
                        }

                        $pdf .= " <tr>
                                        <td style='font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>" . date_format($startdate, 'Y-m-d') . "</td>
                                        <td style='font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>" . date_format($startdate, 'l') . "</td>
                                        <td style='font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>{$log['site']}</td>
                                        <td style='font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>" . date_format($startdate, 'H:i') . "</td>
                                        <td style='font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>" . date_format($startdate, 'H:i') . "</td>
                                        <td style='font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>{$log['start_reading']}</td>
                                        <td style='font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>{$log['end_reading']}</td>
                                        <td style='font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>{$refuel['liters']}</td>
                                        <td style='font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>" . ($bd_start ? $bd_start : "-") . "</td>
                                        <td style='font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>" . ($bd_end ? $bd_end : "-") . "</td>
                                        <td style='font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>" . ($breakdown['start_comment'] ? $breakdown['start_comment'] : " - ") . "</td>
                                        <td style='font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>" . (strlen($operator_['name']) > 0 ? $operator_['name'] . ' ' : "") . (strlen($operator_['name']) > 0 ? $operator_['last_name'] : "") . "</td>
                                        <td style='font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>&nbsp;</td>
                                        <td style='font-size: 11px; color: black; text-align: center; border: 1px; padding: 5px;'>&nbsp;</td>
                                    </tr>";
                    }
                } else {
                    $pdf .= "
                                <tr><td colspan='15'>No logs to show.</td></tr>
                                ";
                }

                $pdf .= "
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <br>
                    <table style='width: 1090px; table-layout: fixed;'>
                        <tr>
                            <td style='width: 10%; font-size: 11px; color: black; text-align: center; padding: 5px;'>Received from operator by:</td>
                            <td style='width: 20%; font-size: 11px; color: black; text-align: center; border-bottom: 1px; padding: 5px;'>&nbsp;</td>
                            <td style='width: 10%; font-size: 11px; color: black; text-align: center; padding: 5px;'>Date Recieved:</td>
                            <td style='width: 20%; font-size: 11px; color: black; text-align: center; border-bottom: 1px; padding: 5px;'>&nbsp;</td>
                            <td style='width: 10%; font-size: 11px; color: black; text-align: center; padding: 5px;'>Signature:</td>
                            <td style='width: 20%; font-size: 11px; color: black; text-align: center; border-bottom: 1px; padding: 5px;'>&nbsp;</td>
                        </tr>
                    </table>                   
                    <table style='width: 1090px; border-collapse: collapse; table-layout: fixed;'>
                        <tbody>
                            <tr>
                                <th style='width: 100%; font-weight: bold; font-size: 11px; color: black; text-align: right; padding: 5px;'>PL13 Rev 00 061011</th>
                            </tr>
                        </tbody>
                    </table>
                    ";

                printPDF($pdf, 'temp', false, false, 'L');
            } else {
                http_response_code(404);
                die();
            }
        } else {
            error_log('Missing data.');
            http_response_code(404);
            die();
        }
        break;

    case 'jobcard-events':
        if (
            strlen($_GET['start']) > 0
            && strlen($_GET['end']) > 0
        ) {
            $title = [
                'font' => [
                    'bold' => true,
                    'size' => 14

                ],
            ];

            $header = [
                'font' => [
                    'bold' => true,
                ],
            ];
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'Job Card Events')
                ->setCellValue('A2', 'Dates: ' . $_GET['start'] . ' to ' . $_GET['end'])

                ->setCellValue('A4', 'Date')
                ->setCellValue('B4', 'Job card No.')
                ->setCellValue('C4', 'Mechanic')
                ->setCellValue('D4', 'Hours')
                ->setCellValue('E4', 'Component')
                ->setCellValue('F4', 'Event');

            $sheet->getStyle('A1')->applyFromArray($title);
            $sheet->getStyle('A4:E4')->applyFromArray($header);
            $sheet->getStyle('E4')->getAlignment()->setWrapText(true);


            $sheet->getColumnDimension('A')->setWidth(100, 'px');
            $sheet->getColumnDimension('B')->setWidth(100, 'px');
            $sheet->getColumnDimension('C')->setWidth(120, 'px');
            $sheet->getColumnDimension('D')->setWidth(85, 'px');
            $sheet->getColumnDimension('E')->setWidth(120, 'px');
            $sheet->getColumnDimension('F')->setWidth(300, 'px');

            $get_events = dbq("select * from jobcard_events where start_datetime>='{$_GET['start']}' and start_datetime<='{$_GET['end']}' order by start_datetime");
            $line = 5;
            if (dbr($get_events) > 0) {
                while ($row = dbf($get_events)) {
                    $date = date_create($row['start_datetime']);
                    $date = date_format($date, 'Y-m-d');
                    $jobcard_ = get_jobcard($row['job_id']);
                    $mechanic = get_user($jobcard_['mechanic_id']);
                    $sheet->setCellValue("A{$line}", $date)
                        ->setCellValue("B{$line}", $jobcard_['jobcard_number'])
                        ->setCellValue("C{$line}", $mechanic['name'] . ' ' . $mechanic['last_name'])
                        ->setCellValue("D{$line}", $row['total_hours'])
                        ->setCellValue("E{$line}", $row['event'])
                        ->setCellValue("F{$line}", $row['comment']);
                    $line++;
                }
            } else {
                $sheet->setCellValue("A{$line}", 'No event at the date range.');
            }


            $writer = new Xlsx($spreadsheet);


            // Redirect output to a client’s web browser (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="job-card-events-' . $_GET['start'] . '-' . $_GET['end'] . '.xlsx"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0


            $writer->save('php://output');
        } else {
            error_log("Report: Job Card Events : Cannot find range: {$_GET['start']} to {$_GET['end']}");
            http_response_code(404);
            die();
        }
        break;

    case 'defect-report':
        if ($_GET['id'] > 0) {
            if ($defect_report_ = get_record('ws_defect_reports', 'id', $_GET['id'])) {
                $plant_ = get_plant($defect_report_['plant_id']);
                $operator_ = get_user($defect_report_['operator_id']);
                $inspector_ = get_user($defect_report_['inspector_id']);
                if ($defect_report_['job_id'] > 0) {
                    $jobcard_ = get_jobcard($defect_report_['job_id']);

                    $receieved_by = get_user($jobcard_['clerk_id']);
                    $received_by_date = $jobcard_['job_date'];
                    $completed_date =  ($jobcard_['complete_datetime'] != null) ? $jobcard_['complete_datetime'] : "Not Completed";
                    $jobcard_number = (strlen($jobcard_['jobcard_number']) > 0 ? $jobcard_['jobcard_number'] : "None");
                } else {
                    $jobcard_number = 'No Job Card Logged';
                    $completed_date = '';
                    $receieved_by = ['name' => '', 'last_name' => ''];
                    $received_by_date = '';
                }

                $defect_report_number = $defect_report_['id'];
                $logged_date = $defect_report_['date'];




                $pdf = "
                                <table style='width: 750px; border-collapse: collapse; table-layout: fixed;'>
                                    <thead>
                                        <tr>
                                            <th style='width: 90%; font-weight: bold; font-size: 25px; color: black; text-align: left; padding: 5px;'>Defect Report</th>
                                            <th># {$_GET['id']}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                        <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <br>
                                <br>
                                <table style='width: 750px; border-collapse: collapse; table-layout: fixed;'>                                
                                    <tr>
                                        <td style='margin:3px; width: 10%; font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 5px;'>Date:</td>
                                        <td style='margin:3px; width: 20%; font-weight: bold; font-size: 11px; color: black; text-align: left;  padding: 5px;'>{$defect_report_['date']}</td>
                                        <td style='margin:3px; width: 10%; font-weight: bold; font-size: 11px; color: black; text-align: right; padding: 5px;'>Site:</td>
                                        <td style='margin:3px; width: 20%; font-weight: bold; font-size: 11px; color: black; text-align: left;  padding: 5px;'>{$defect_report_['site']}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td style='margin:3px; width: 10%; font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 5px;'>Plant No:</td>
                                        <td style='margin:3px; width: 20%; font-weight: bold; font-size: 11px; color: black; text-align: left;  padding: 5px;'>{$plant_['plant_number']}</td>
                                        <td style='margin:3px; width: 15%; font-weight: bold; font-size: 11px; color: black; text-align: right; padding: 5px;'>Registation No:</td>
                                        <td style='margin:3px; width: 20%; font-weight: bold; font-size: 11px; color: black; text-align: left;  padding: 5px;'>{$plant_['reg_number']}</td>
                                        <td style='margin:3px; width: 10%; font-weight: bold; font-size: 11px; color: black; text-align: right; padding: 5px;'>" . strtoupper($plant_['reading_type']) . ":</td>
                                        <td style='margin:3px; width: 20%; font-weight: bold; font-size: 11px; color: black; text-align: left;  padding: 5px;'>{$defect_report_['reading']}</td>
                                    </tr>
                                </table>
                                <br>
                                <br>
                                <br>
                                <table style='width: 750px; border-collapse: collapse; table-layout: fixed;'>
                                        <tr>
                                            <td style='width: 30%; font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 10px;'>Engine:</td>
                                            <td style='width: 20%  font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 10px;'>" . ($defect_report_['engine_fault'] ? "Yes" : "No") . "</td>
                                            <td style='width: 50%; font-weight: bold; font-size: 11px; color: black; text-align: left; border-bottom: 1px; padding: 10px;'>{$defect_report_['engine_comment']}</td>
                                        </tr>
                                        <tr>
                                            <td style='width: 30%; font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 10px;'>Cooling System:</td>
                                            <td style='width: 20%  font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 10px;'>" . ($defect_report_['cooling_system_fault'] ? "Yes" : "No") . "</td>
                                            <td style='width: 50%; font-weight: bold; font-size: 11px; color: black; text-align: left; border-bottom: 1px; padding: 10px;'>{$defect_report_['cooling_system_comment']}</td>
                                        </tr>
                                        <tr>
                                            <td style='width: 30%; font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 10px;'>Gear Box / Gear Selection / Clutch:</td>
                                            <td style='width: 20%  font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 10px;'>" . ($defect_report_['gear_clutch_fault'] ? "Yes" : "No") . "</td>
                                            <td style='width: 50%; font-weight: bold; font-size: 11px; color: black; text-align: left; border-bottom: 1px; padding: 10px;'>{$defect_report_['gear_clutch_comment']}</td>
                                        </tr>
                                        <tr>
                                            <td style='width: 30%; font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 10px;'>Electrical & Batteries:</td>
                                            <td style='width: 20%  font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 10px;'>" . ($defect_report_['electrical_batteries_fault'] ? "Yes" : "No") . "</td>
                                            <td style='width: 50%; font-weight: bold; font-size: 11px; color: black; text-align: left; border-bottom: 1px; padding: 10px;'>{$defect_report_['electrical_batteries_comment']}</td>
                                        </tr>
                                        <tr>
                                            <td style='width: 30%; font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 10px;'>Hydraulics:</td>
                                            <td style='width: 20%  font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 10px;'>" . ($defect_report_['hydraulics_fault'] ? "Yes" : "No") . "</td>
                                            <td style='width: 50%; font-weight: bold; font-size: 11px; color: black; text-align: left; border-bottom: 1px; padding: 10px;'>{$defect_report_['hydraulics_comment']}</td>
                                        </tr>
                                        <tr>
                                            <td style='width: 30%; font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 10px;'>Instruments:</td>
                                            <td style='width: 20%  font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 10px;'>" . ($defect_report_['instruments_fault'] ? "Yes" : "No") . "</td>
                                            <td style='width: 50%; font-weight: bold; font-size: 11px; color: black; text-align: left; border-bottom: 1px; padding: 10px;'>{$defect_report_['instruments_comment']}</td>
                                        </tr>
                                        <tr>
                                            <td style='width: 30%; font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 10px;'>Brakes:</td>
                                            <td style='width: 20%  font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 10px;'>" . ($defect_report_['brakes_fault'] ? "Yes" : "No") . "</td>
                                            <td style='width: 50%; font-weight: bold; font-size: 11px; color: black; text-align: left; border-bottom: 1px; padding: 10px;'>{$defect_report_['brakes_comment']}</td>
                                        </tr>
                                        <tr>
                                            <td style='width: 30%; font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 10px;'>Body Work:</td>
                                            <td style='width: 20%  font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 10px;'>" . ($defect_report_['body_work_fault'] ? "Yes" : "No") . "</td>
                                            <td style='width: 50%; font-weight: bold; font-size: 11px; color: black; text-align: left; border-bottom: 1px; padding: 10px;'>{$defect_report_['body_work_comment']}</td>
                                        </tr>
                                        <tr>
                                            <td style='width: 30%; font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 10px;'>Steering:</td>
                                            <td style='width: 20%  font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 10px;'>" . ($defect_report_['steering_fault'] ? "Yes" : "No") . "</td>
                                            <td style='width: 50%; font-weight: bold; font-size: 11px; color: black; text-align: left; border-bottom: 1px; padding: 10px;'>{$defect_report_['steering_comment']}</td>
                                        </tr>
                                        <tr>
                                            <td style='width: 30%; font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 10px;'>All Glass & Mirrors:</td>
                                            <td style='width: 20%  font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 10px;'>" . ($defect_report_['glass_mirrors_fault'] ? "Yes" : "No") . "</td>
                                            <td style='width: 50%; font-weight: bold; font-size: 11px; color: black; text-align: left; border-bottom: 1px; padding: 10px;'>{$defect_report_['glass_mirrors_comment']}</td>
                                        </tr>
                                        <tr>
                                            <td style='width: 30%; font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 10px;'>Tracks / Under Carriage / Tyres:</td>
                                            <td style='width: 20%  font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 10px;'>" . ($defect_report_['tracks_carriage_tyres_fault'] ? "Yes" : "No") . "</td>
                                            <td style='width: 50%; font-weight: bold; font-size: 11px; color: black; text-align: left; border-bottom: 1px; padding: 10px;'>{$defect_report_['tracks_carriage_tyres_comment']}</td>
                                        </tr>
                                </table>
                                <br>
                                <br>
                               
                                <table style='width: 750px; table-layout: fixed;'>
                                    <thead>
                                        <tr>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>";

                if (strlen($defect_report_['extras']) > 0) {
                    if (is_json($defect_report_['extras'])) {
                        $safety_audit = json_decode($defect_report_['extras'], true);
                    } else {
                        $safety_audit = json_decode(base64_decode($defect_report_['extras']), true);
                    }
                } else {
                    $safety_audit = [];
                }

                if (count($safety_audit) > 0) {
                    $pos = 1;


                    $pdf .= "<tr>
                                        <td style='width: 20%; font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 5px;'>{$safety_audit[0]['name']}:</td>
                                        <td style='width: 10%; font-weight: bold; font-size: 11px; color: black; text-align: center; border-bottom: 1px; border-top: 1px; border-left: 1px; border-right: 1px; padding: 5px;'>{$safety_audit[0]['answer']}</td>
                                        <td style='width: 20%;'></td>
                                        <td style='width: 20%; font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 5px;'>{$safety_audit[1]['name']}:</td>
                                        <td style='width: 10%; font-weight: bold; font-size: 11px; color: black; text-align: center; border-bottom: 1px; border-top: 1px; border-left: 1px; border-right: 1px; padding: 5px;'>{$safety_audit[1]['answer']}</td>
                                    </tr>
                                    <tr>
                                        <td style='width: 20%; font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 5px;'>{$safety_audit[2]['name']}:</td>
                                        <td style='width: 10%; font-weight: bold; font-size: 11px; color: black; text-align: center; border-bottom: 1px; border-top: 1px; border-left: 1px; border-right: 1px; padding: 5px;'>{$safety_audit[2]['answer']}</td>
                                        <td style='width: 20%;'></td>
                                        <td style='width: 20%; font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 5px;'>{$safety_audit[3]['name']}:</td>
                                        <td style='width: 10%; font-weight: bold; font-size: 11px; color: black; text-align: center; border-bottom: 1px; border-top: 1px; border-left: 1px; border-right: 1px; padding: 5px;'>{$safety_audit[3]['answer']}</td>
                                    </tr>
                                    <tr>
                                        <td style='width: 20%; font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 5px;'>{$safety_audit[4]['name']}:</td>
                                        <td style='width: 10%; font-weight: bold; font-size: 11px; color: black; text-align: center; border-bottom: 1px; border-top: 1px; border-left: 1px; border-right: 1px; padding: 5px;'>{$safety_audit[4]['answer']}</td>
                                        <td style='width: 20%;'></td>
                                        <td style='width: 20%; font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 5px;'>{$safety_audit[5]['name']}:</td>
                                        <td style='width: 10%; font-weight: bold; font-size: 11px; color: black; text-align: center; border-bottom: 1px; border-top: 1px; border-left: 1px; border-right: 1px; padding: 5px;'>{$safety_audit[5]['answer']}</td>
                                    </tr>
                                    <tr>
                                        <td style='width: 20%; font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 5px;'>{$safety_audit[6]['name']}:</td>
                                        <td style='width: 10%; font-weight: bold; font-size: 11px; color: black; text-align: center; border-bottom: 1px; border-top: 1px; border-left: 1px; border-right: 1px; padding: 5px;'>{$safety_audit[6]['answer']}</td>
                                        <td style='width: 20%;'></td>
                                        <td style='width: 20%; font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 5px;'>{$safety_audit[7]['name']}:</td>
                                        <td style='width: 10%; font-weight: bold; font-size: 11px; color: black; text-align: center; border-bottom: 1px; border-top: 1px; border-left: 1px; border-right: 1px; padding: 5px;'>{$safety_audit[7]['answer']}</td>
                                    </tr>";
                }



                $pdf .= "</tbody>
                                </table>
                                <br>
                                <br>
                                <table style='width: 750px; border-collapse: collapse; table-layout: fixed;'>
                                    <thead>
                                        <tr>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style='width: 20%; font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 10px;'>Reported By:</td>
                                            <td style='width: 30%; font-weight: bold; font-size: 11px; color: black; text-align: left; border-bottom: 1px; padding: 10px;'>{$inspector_['name']} {$inspector_['last_name']}</td>
                                            <td style='width: 20%; font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 10px;'>Date:</td>
                                            <td style='width: 30%; font-weight: bold; font-size: 11px; color: black; text-align: left; border-bottom: 1px; padding: 10px;'>{$defect_report_['date']}</td>
                                        </tr>
                                        <tr>
                                            <td style='width: 20%; font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 10px;'>Received By:</td>
                                            <td style='width: 30%; font-weight: bold; font-size: 11px; color: black; text-align: left; border-bottom: 1px; padding: 10px;'>{$receieved_by['name']} {$receieved_by['last_name']}</td>
                                            <td style='width: 20%; font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 10px;'>Date:</td>
                                            <td style='width: 30%; font-weight: bold; font-size: 11px; color: black; text-align: left; border-bottom: 1px; padding: 10px;'>{$receieved_by['date']}</td>
                                        </tr>
                                        <tr>
                                            <td style='width: 20%; font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 10px;'>Job No#:</td>
                                            <td style='width: 30%; font-weight: bold; font-size: 11px; color: black; text-align: left; border-bottom: 1px; padding: 10px;'>{$jobcard_number}</td>
                                            <td style='width: 20%; font-weight: bold; font-size: 11px; color: black; text-align: left; padding: 10px;'>Job Completed Date:</td>
                                            <td style='width: 30%; font-weight: bold; font-size: 11px; color: black; text-align: left; border-bottom: 1px; padding: 10px;'>{$completed_date}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <br>
                                <table style='width: 750px; border-collapse: collapse; table-layout: fixed;'>
                                    <thead>
                                        <tr>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th style='width: 100%; font-weight: bold; font-size: 11px; color: black; text-align: right; padding: 5px;'>DFR Rev 00 200801</th>
                                        </tr>
                                    </tbody>
                                </table>
                                ";

                printPDF($pdf);
            } else {
                error_log("Print: defect-Report: Cannot find Job Card: {$_GET['id']}");
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
