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
        <td>{$row['name']}</td>
        <td class='actions'>
            <i onclick='edit_site(`{$row['id']}`)' class='fas fa-pencil-alt pointer'></i> 
            <i onclick='delete_site(`{$row['id']}`)' class='far fa-trash-alt pointer'></i>
        </td>
    </tr>";
