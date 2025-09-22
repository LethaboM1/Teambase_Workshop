<?php
$plant_ = ($row['plant_id'] > 0) ? dbf(dbq("SELECT * FROM plants_tbl WHERE plant_id={$row['plant_id']}")) : ['plant_number' => 'None'];
$operator_ = ($row['user_id'] > 0) ? dbf(dbq("SELECT name, last_name FROM users_tbl WHERE user_id={$row['user_id']}")) : ['name' => 'None', 'last_name' => ''];

echo "<tr class='pointer' onclick=\"window.open('includes/pages/user/list_plant_quality_inspection_sheet.php?plant_id={$row['plant_id']}', '_blank')\">
        <td>{$row['datetime']}</td>
        <td>{$plant_['plant_number']}</td>
        <td>{$plant_['vehicle_type']} {$plant_['make']} {$plant_['model']}</td>
        <td>{$row['reading']} (" . strtoupper($row['reading_type']) . ")</td>
        <td>{$operator_['name']} {$operator_['last_name']}</td>
        <td class='actions'>            
            <i class='fa-solid fa-magnifying-glass fa-2x'></i>
        </td>
    </tr>";

