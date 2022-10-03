<?php

if (isset($_POST['save_profile'])) {
    if (file_exists($_FILES['photo']['tmp_name'])) {
        $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        if ($ext == 'jpg' || $ext == 'jpeg') {
            $path = "images/users/{$_POST['user_id']}.jpg";
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $path)) {
                msg('Photo saved!');
            } else {
                error("Error saving photo.");
            }
        } else {
            error('Only JPG file types allowed');
        }
    }

    if (strlen($_POST['password']) > 0) {
        if ($_POST['password'] == $_POST['confirmpassword']) {
            if (validPass($_POST['password'])) {
                $update_password = dbq("update users_tbl set
                                            password='" . password_hash($_POST['password'], PASSWORD_DEFAULT) . "'
                                            where user_id={$_POST['user_id']}");
                if ($update_password) {
                    msg("Password changed!");
                } else {
                    sqlError('Password change error', 'Password change error');
                }
            } else {
                $error[] = "Unsafe password. Password must have uppercase, lowercase, numbers, special characters and must be atleast 8 characters in length.";
            }
        } else {
            $error[] = "Could not change password. Passwords dont match.";
        }
    }

    $user_ = dbf(dbq("select * from users_tbl where user_id='{$_POST['user_id']}'"));
    $chk_duplicate_username = dbq("select * from users_tbl where username='{$_POST['username']}' and user_id!='{$user_['user_id']}'");
    if (dbr($chk_duplicate_username) == 0) {
        $update_user = dbq("update users_tbl set 
                                email='{$_POST['email']}',
                                contact_number='{$_POST['contact_number']}',
                                username='{$_POST['username']}',
                                where user_id='{$_POST['user_id']}'
                                ");
        if ($update_user) {
            msg("User saved {$_POST['firstName']}!");
            go("dashboard.php?page=add-user");
        } else {
            sqlError();
        }
    } else {
        error("User with username '{$_POST['username']}' already exists.");
    }
}
