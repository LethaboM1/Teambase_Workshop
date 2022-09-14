<?php

echo "<tr>
        <td>{$row['name']}</td>
        <td>{$row['last_name']}</td>
        <td>{$row['email']}</td>
        <td>{$row['contact_number']}</td>
        <td>{$row['id_number']}</td>
        <td>{$row['employee_number']}</td>
        <td>" . strtoupper($row['role']) . "</td>
        <td class='actions'>
            <i onclick='edit_user(`{$row['user_id']}`)' class='fas fa-pencil-alt pointer'></i>
            <i onclick='delete_user(`{$row['user_id']}`)' class='far fa-trash-alt pointer'></i>
            <i onclick='view_user(`{$row['user_id']}`)' class='fa-solid fa-magnifying-glass pointer'></i>
        </td>
    </tr>";
