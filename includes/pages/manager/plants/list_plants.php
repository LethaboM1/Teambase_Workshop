<?php
switch ($row['reading_type']) {
    case "km":
        $reading = $row['km_reading'];
        break;
    case "hr":
        $reading = $row['hr_reading'];
        break;
}

echo "<tr>
        <td>{$row['plant_number']}</td>
        <td>{$row['vehicle_type']} {$row['make']}</td>
        <td>{$row['model']}</td>
        <td>{$reading} (" . strtoupper($row['reading_type']) . ")</td>
        <td>{$row['next_service_reading']} (" . strtoupper($row['reading_type']) . ")</td>
        <td class='actions'>
            <i onclick='edit_plant(`{$row['plant_id']}`)' class='fas fa-pencil-alt pointer'></i> 
            <i onclick='delete_plant(`{$row['plant_id']}`)' class='far fa-trash-alt pointer'></i>
            <a href='dashboard.php?page=view-plant&id={$row['plant_id']}'><i class='fa-solid fa-magnifying-glass'></i></a>
        </td>
    </tr>";
