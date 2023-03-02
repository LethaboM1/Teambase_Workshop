<?php
$plant_ = dbf(dbq("select * from plants_tbl where plant_id={$row['plant_id']}"));
$operator_ = dbf(dbq("select name, last_name from users_tbl where user_id={$row['user_id']}"));

echo "<tr class='pointer' onclick='window.open(`print.php?type=plant-checklist&id={$row['list_id']}`,`_blank`)'>
        <td>{$row['datetime']}</td>
        <td>{$plant_['plant_number']}</td>
        <td>{$plant_['vehicle_type']} {$plant_['make']} {$plant_['model']}</td>
        <td>{$row['reading']} (" . strtoupper($row['reading_type']) . ")</td>
        <td>{$operator_['name']} {$operator_['last_name']}</td>
        <td class='actions'>            
            <i class='fa-solid fa-magnifying-glass fa-2x'></i>
        </td>
    </tr>";
