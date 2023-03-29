<?php
/* 
    <th width="100">Date/Time</th>
    <th width="200">Plant No.</th>
    <th width="200">Operator</th>
    <th width="120">Reading</th>
    <th width="150"></th>
    <th width="100">Status</th>
    <th width="25">Action</th>
*/
$plant_ = get_plant($row['plant_id']);
$operator_ = get_user($row['operator_id']);
echo "<tr class='pointer' onclick='window.open(`print.php?type=operator-log&id={$row['log_id']}`,`_SELF`)'>
        <td>{$row['start_datetime']}</td>
        <td>{$plant_['plant_number']} {$plant_['make']} {$plant_['model']}</td>
        <td>" . (strlen($operator_['name']) > 0 ? $operator_['name'] . ' ' : "") . (strlen($operator_['last_name']) > 0 ? $operator_['last_name'] : "") . "</td>
        <td>" . ($row['end_reading'] > 0 ? $row['end_reading'] : $row['start_reading']) . "</td>
        <td class='actions'>
            <i class='fa fa-folder-open'></i>
        </td>
    </tr>";
