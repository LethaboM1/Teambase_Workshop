<?php

$fleet_ = ($row['fleet_id'] > 0) 
    ? dbf(dbq("SELECT * FROM fleet_tbl WHERE fleet_id={$row['fleet_id']}")) 
    : ['fleet_no' => 'None'];

$operator_ = ($row['driver_id'] > 0) 
    ? dbf(dbq("SELECT name, last_name FROM users_tbl WHERE user_id={$row['driver_id']}")) 
    : ['name' => 'None', 'last_name' => ''];

echo "<tr class='pointer' onclick='window.open(`print.php?type=fleet-checklist&id={$row['list_id']}`, `_blank`)'
        <td>{$row['datetime']}</td>
        <td>{$fleet_['fleet_no']}</td>
        <td>{$row['site']}</td>
        <td>{$row['hrs_km_driver']}</td>
        <td>{$operator_['name']} {$operator_['last_name']}</td>
        <td class='actions'>            
            <i class='fa-solid fa-magnifying-glass fa-2x'></i>
        </td>
    </tr>";
